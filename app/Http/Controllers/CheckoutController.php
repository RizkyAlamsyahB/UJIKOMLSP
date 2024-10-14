<?php

namespace App\Http\Controllers;




use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cart = $user->cart()->with('products')->first();

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
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Prepare transaction details
        $user = Auth::user();
        $orderId = uniqid(); // Generate a unique order ID
        $totalPrice = $request->total_price; // Use the total_price sent from the form

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice, // Total amount to be paid
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
            'item_details' => $this->getItemDetails($user->cart->products), // Use your method to get item details
        ];

        // Create a Snap token
        try {
            $snapToken = Snap::getSnapToken($params);
            return view('frontend.payment', compact('snapToken', 'totalPrice', 'orderId'));
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function paymentSuccess(Request $request)
    {
        $user = Auth::user();

        // Generate a UUID for the order
        $orderId = (string) \Str::uuid(); // Ensure this is a string

        // Create an order
        $order = \App\Models\Order::create([
            'id' => $orderId, // Set the generated UUID here
            'user_id' => $user->id,
            'total_price' => $request->total_price,
            'status' => $request->transaction_status === 'success' ? 'completed' : 'pending',
            'order_date' => now(),
        ]);

        // Clear the cart after successful payment
        $user->cart->products()->detach();

        // Check the order ID before redirection
        dd($order->id); // This should output the UUID, not 0

        return redirect()->route('frontend.order.showSuccessPage', ['order' => $order->id])
            ->with('success', 'Your payment was successful! Order has been placed.');
    }




    protected function getItemDetails($cartItems)
    {
        $items = [];
        foreach ($cartItems as $item) {
            $items[] = [
                'id' => $item->id,
                'price' => $item->pivot->price,
                'quantity' => $item->pivot->quantity,
                'name' => $item->name,
            ];
        }
        return $items;
    }
}
