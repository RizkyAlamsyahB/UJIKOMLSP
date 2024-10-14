<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart()->with('products')->first();

        // Check if the cart is empty
        if (!$cart || $cart->products->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty!');
        }

        $cartItems = $cart->products;

        // Calculate the total price based on cart items
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->pivot->price * $item->pivot->quantity;
        });

        return view('frontend.checkout', compact('cartItems', 'totalPrice'));
    }
    public function pay(Request $request)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Set konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // Ambil pengguna yang terautentikasi
            $user = Auth::user();
            $totalPrice = $request->total_price;

            // Pastikan total harga disediakan
            if (!$totalPrice) {
                return redirect()->route('checkout')->with('error', 'Total price is required.');
            }

            // Generate unique order ID
            $orderId = Str::uuid()->toString();

            // Ambil cart dan cek ketersediaan stok
            $cart = $user->cart()->with('products')->first();
            if (!$cart || $cart->products->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Cart is empty!');
            }

            // Cek ketersediaan stok untuk setiap produk
            foreach ($cart->products as $product) {
                if ($product->pivot->quantity > $product->stock_quantity) {
                    return redirect()->route('checkout')->with('error', 'Insufficient stock for ' . $product->name);
                }
            }

            // Siapkan detail transaksi untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
                'item_details' => $this->getItemDetails($cart->products),
            ];

            // Buat Snap token
            $snapToken = Snap::getSnapToken($params);

            // Cek apakah order sudah ada
            $existingOrder = Order::where('id', $orderId)->first();
            if ($existingOrder) {
                return redirect()->route('checkout')->with('error', 'Order already exists.');
            }

            // Simpan order ke database
            $order = Order::create([
                'id' => $orderId,
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'status' => 'pending', // Status awal adalah pending
                'order_date' => now(),
            ]);

            // Update stock quantity for each product in the order
            foreach ($cart->products as $product) {
                $product->decrement('stock_quantity', $product->pivot->quantity);
            }

            // Remove products from cart
            $cart->products()->detach(); // Detach all products from the cart

            // Komit transaksi jika semuanya sukses
            DB::commit();

            // Pass token ke view untuk pemrosesan pembayaran
            return view('frontend.payment', compact('snapToken', 'totalPrice', 'orderId'));

        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            Log::error('Payment failed: ' . $e->getMessage());

            // Redirect kembali ke checkout dengan pesan kesalahan
            return redirect()->route('checkout')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }


    private function getItemDetails($products)
    {
        // Get item details from cart
        $itemDetails = [];
        foreach ($products as $product) {
            $itemDetails[] = [
                'id' => $product->id,
                'price' => $product->price,
                'quantity' => $product->pivot->quantity, // If using pivot table
                'name' => $product->name,
            ];
        }
        return $itemDetails;
    }

    public function paymentSuccess(Request $request)
    {
        $user = Auth::user();
        $orderId = $request->input('order_id');

        // Cek apakah order sudah ada
        $existingOrder = Order::where('id', $orderId)->first();
        if ($existingOrder) {
            return redirect()->route('frontend.order.showSuccessPage', ['order' => $existingOrder->id])
                ->with('success', 'Your payment was successful! Order has already been placed.');
        }

        // Create the order
        $order = Order::create([
            'id' => $orderId,
            'user_id' => $user->id,
            'total_price' => $request->total_price,
            'status' => $request->transaction_status === 'success' ? 'completed' : 'pending',
            'order_date' => now(),
        ]);

        // Redirect to the success page
        return redirect()->route('frontend.order.showSuccessPage', ['order' => $order->id])
            ->with('success', 'Your payment was successful! Order has been placed.');
    }

    public function paymentNotification(Request $request)
    {
        // Midtrans sends a JSON payload with the transaction status
        $data = $request->all();

        // Log the notification for debugging purposes
        Log::info('Midtrans Notification: ', $data);

        // Check if the notification is valid
        if (isset($data['order_id']) && isset($data['transaction_status'])) {
            // Find the order in the database
            $order = Order::where('id', $data['order_id'])->first();

            if ($order) {
                // Save the Midtrans order ID for reference
                $order->midtrans_order_id = $data['transaction_id']; // Save the Midtrans transaction ID
                $order->save();

                // Update the order status based on transaction_status
                switch ($data['transaction_status']) {
                    case 'capture':
                        if ($data['fraud_status'] == 'challenge') {
                            $order->update(['status' => 'pending']);
                        } else {
                            $order->update(['status' => 'completed']);
                        }
                        break;
                    case 'settlement':
                        $order->update(['status' => 'completed']);
                        break;
                    case 'pending':
                        $order->update(['status' => 'pending']);
                        break;
                    case 'deny':
                        $order->update(['status' => 'failed']);
                        break;
                    case 'expire':
                        $order->update(['status' => 'expired']);
                        break;
                    case 'cancel':
                        $order->update(['status' => 'canceled']);
                        break;
                    case 'processing': // Handle processing status if you plan to use it
                        $order->update(['status' => 'processing']);
                        break;
                    default:
                        Log::warning('Unexpected transaction status: ' . $data['transaction_status']);
                        break;
                }
            } else {
                Log::warning('Order not found for order_id: ' . $data['order_id']);
            }
        } else {
            Log::warning('Invalid notification data: ', $data);
        }

        // Return a 200 response to acknowledge the notification
        return response()->json(['status' => 'success'], 200);
    }
}
