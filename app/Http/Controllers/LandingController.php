<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Promotion;
use App\Models\Category; // Import model Category
use App\Models\Brand; // Import model Brand
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil data promosi dari cache atau database
        $promotions = Cache::remember('landing_promotions', 60, function () {
            return Promotion::where('status', true)
                            ->where('start_date', '<=', now())
                            ->where('end_date', '>=', now())
                            ->get();
        });

        $products = Cache::remember('landing_products', 60, function () {
            return Products::with(['category', 'brand'])
                ->where('stock_quantity', '>=', 1) // Filter produk dengan stok lebih dari atau sama dengan 1
                ->get();
        });

        $categories = Cache::remember('landing_categories', 60, function () {
            return Category::all(); // Ambil semua kategori
        });

        $brands = Cache::remember('landing_brands', 60, function () {
            return Brand::all(); // Ambil semua brand
        });

        return view('landing', compact('promotions', 'products', 'categories', 'brands'));
    }
    public function filter(Request $request)
    {
        $query = Products::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('brand')) {
            $query->where('brand_id', $request->brand);
        }

        $products = $query->with(['category', 'brand'])->get();

        return view('products.index', compact('products'));
    }
}
