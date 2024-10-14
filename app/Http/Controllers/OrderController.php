<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showSuccessPage($orderId)
    {
        $order = \App\Models\Order::findOrFail($orderId);
        return view('order.success', compact('order'));
    }


}
