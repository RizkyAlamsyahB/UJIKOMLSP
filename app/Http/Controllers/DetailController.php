<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    //
    public function show($id)
    {
        // Ambil data produk berdasarkan ID
        $product = Products::with(['category', 'brand', 'images'])->findOrFail($id);

        // Ambil produk lain yang memiliki kategori yang sama, kecuali produk yang sedang dibuka
        $relatedProducts = Products::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', value: $id)
            ->get();

        // Tampilkan view dengan data produk dan produk terkait
        return view('frontend.products.detail', compact('product', 'relatedProducts'));
    }
}
