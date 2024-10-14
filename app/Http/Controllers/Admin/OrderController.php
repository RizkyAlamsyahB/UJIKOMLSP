<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrdersController extends Controller
{


    public function index()
    {
        // Retrieve all orders
        $orders = Order::all();
        $orderCount = $orders->count();

        // No need for totalOrderPrice, just return the orders data
        return view('admin.orders.index', compact('orders', 'orderCount'));
    }
    



}
