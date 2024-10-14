<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply checkAdmin middleware to the HomeController
        $this->middleware(['auth', 'checkAdmin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
{
    $user = Auth::user();
    $cartCount = 0;

    if ($user) {
        $cart = $user->cart()->with('products')->first();
        if ($cart) {
            $cartCount = $cart->products->sum('pivot.quantity');
        }
    }

    return view('home', compact('cartCount'));
}

}
