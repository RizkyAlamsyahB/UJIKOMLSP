<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Products;
use App\Models\CartProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{


    public function index()
    {
        $user = Auth::user();
        $cart = $user->cart()->with('products')->first();


        if (!$cart) {
            return view('frontend.carts.index', ['cartItems' => collect(), 'totalPrice' => 0]);
        }

        $cartItems = $cart->products;
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->pivot->quantity * $item->pivot->price;
        });

        $cartCount = $cartItems->sum('pivot.quantity'); // Menghitung total jumlah produk

        return view('frontend.carts.index', compact('cartItems', 'totalPrice', 'cartCount'));
    }

    /**
     * Add a product to the cart.
     */
    // Add product to the cart
    public function addProduct(Request $request, $productId)
    {
        $user = Auth::user();
        $product = Products::findOrFail($productId);

        // Cek apakah pengguna sudah memiliki keranjang, jika tidak buat keranjang baru
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Cek apakah produk sudah ada di keranjang
        $cartProduct = CartProduct::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartProduct) {
            // Jika produk sudah ada, tambahkan kuantitasnya
            $cartProduct->quantity += $request->input('quantity', 1);
            $cartProduct->save();
        } else {
            // Jika produk belum ada, tambahkan ke keranjang
            CartProduct::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $request->input('quantity', 1),
                'price' => $product->price,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

   /**
 * Remove a product from the cart.
 */
public function removeProduct($productId)
{
    $user = Auth::user();
    $cart = Cart::where('user_id', $user->id)->first();

    if ($cart) {
        CartProduct::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->delete();
    }

    return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
}

/**
 * Update the quantity of a product in the cart.
 */
public function updateProduct(Request $request, $productId)
{
    $user = Auth::user();
    $cart = Cart::where('user_id', $user->id)->first();

    if ($cart) {
        $cartProduct = CartProduct::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        $product = Products::findOrFail($productId); // Temukan produk yang terkait

        // Ambil kuantitas dari form dan validasi agar tidak melebihi stok
        $requestedQuantity = $request->input('quantity', 1);

        if ($requestedQuantity > $product->stock_quantity) {
            return redirect()->back()->withErrors('Kuantitas yang diminta melebihi stok yang tersedia.');
        }

        if ($cartProduct) {
            $cartProduct->quantity = $requestedQuantity;
            $cartProduct->save();
        }
    }

    return redirect()->back()->with('success', 'Kuantitas produk berhasil diperbarui.');
}




}
