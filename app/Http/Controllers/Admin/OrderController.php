<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order; // Pastikan model Order sudah ada
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Mengambil semua data order
        $orders = Order::all(); // Anda bisa menggunakan paginasi jika data banyak
        $orderCount = $orders->count(); // Menghitung jumlah order

        return view('admin.orders.index', compact('orders', 'orderCount'));
    }
}
