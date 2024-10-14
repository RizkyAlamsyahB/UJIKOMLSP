<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function showSuccessPage($orderId)
    {
        // Retrieve the order by ID
        $order = Order::findOrFail($orderId);

        // Return a view to display the order success page
        return view('frontend.order.showSuccessPage', compact('order'));
    }


}
