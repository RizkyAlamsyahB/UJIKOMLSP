<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // use Illuminate\Support\Facades\View;
    // use App\Models\Cart;

    // use Illuminate\Support\Facades\View;
    // use Illuminate\Support\Facades\Auth;
    // use App\Models\Cart;

    public function boot()
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            $cartCount = 0;

            if ($user) {
                $cart = $user->cart()->with('products')->first();
                if ($cart) {
                    $cartCount = $cart->products->sum('pivot.quantity');
                }
            }

            $view->with('cartCount', $cartCount);
        });
    }


}
