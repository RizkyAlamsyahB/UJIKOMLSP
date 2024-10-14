<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;

use App\Models\Products;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    //
    // List all products
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Products::with(['category', 'brand'])->select('products.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    return $row->category ? $row->category->name : '-';
                })
                ->addColumn('brand', function ($row) {
                    return $row->brand ? $row->brand->name : '-';
                })
                ->addColumn('description', function ($row) {
                    return Str::limit($row->description, 50);
                })
                ->addColumn('image', function ($row) {
                    $primaryImage = $row->images()->where('is_primary', true)->first();
                    if ($primaryImage) {
                        return '<img src="' . asset('storage/' . $primaryImage->image_path) . '" width="50" height="50"/>';
                    } else {
                        return '-'; // Jika tidak ada gambar
                    }
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('products.edit', $row->id);
                    $deleteUrl = route('products.destroy', $row->id);
                    $showUrl = route('products.show', $row->id);
                    return '
                        <div class="dropdown dropdown">
                            <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' .
                        $row->id .
                        '" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' .
                        $row->id .
                        '">
                              <li><button type="button" class="dropdown-item show-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Show" data-id="' .
                        $row->id .
                        '">
                    <i class="bi bi-eye"></i> Show
                </button></li>
                                <li><a href="' .
                        $editUrl .
                        '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a></li>
                                <li><button type="button" class="dropdown-item delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-id="' .
                        $row->id .
                        '" data-name="' .
                        $row->name .
                        '" data-url="' .
                        $deleteUrl .
                        '">
                                    <i class="bi bi-trash"></i> Delete
                                </button></li>
                            </ul>
                        </div>';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.products.index');
    }

    // Show the form for creating a new product
    public function show($id)
    {
        $product = Products::with(['category', 'brand', 'images'])->findOrFail($id);

        // Ambil semua gambar
        $images = $product->images->map(function($image) {
            return [
                'image_path' => $image->image_path,
                'is_primary' => $image->is_primary,
            ];
        });

        return response()->json([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity,
            'category' => $product->category ? $product->category->name : '-',
            'brand' => $product->brand ? $product->brand->name : '-',
            'weight' => $product->weight,
            'dimensions' => $product->dimensions,
            'images' => $images,
        ]);
    }


    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    // Store a newly created product
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'nullable|uuid|exists:categories,id',
            'brand_id' => 'nullable|uuid|exists:brands,id',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk file gambar
            'primary_image' => 'nullable|integer|min:0', // Menentukan gambar utama
        ]);
        dd($validatedData);
        // Buat produk baru
        $product = Products::create([
            'id' => Str::uuid(),
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'price' => $validatedData['price'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'category_id' => $validatedData['category_id'] ?? null,
            'brand_id' => $validatedData['brand_id'] ?? null,
            'weight' => $validatedData['weight'] ?? null,
            'dimensions' => $validatedData['dimensions'] ?? null,
        ]);

        // Simpan gambar produk jika ada
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Simpan file gambar ke storage (misal: public/images/products)
                $imagePath = $image->store('images/products', 'public');

                // Tentukan apakah ini gambar utama
                $isPrimary = $validatedData['primary_image'] == $index;

                // Simpan informasi gambar ke database
                ProductImage::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                    'is_primary' => $isPrimary, // Set sebagai gambar utama jika dipilih
                    'order' => $index + 1, // Urutan sesuai dengan indeks gambar
                ]);
            }
        }
        dd($product);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Show the form for editing the specified product
    public function edit($id)
{
    // Temukan produk berdasarkan ID
    $product = Products::findOrFail($id);

    // Ambil semua kategori dan brand untuk dropdown (opsional)
    $categories = Category::all();
    $brands = Brand::all();

    // Ambil semua gambar yang terkait dengan produk
    $images = ProductImage::where('product_id', $product->id)->get();

    // Kembalikan view dengan data produk, kategori, brand, dan gambar
    return view('admin.products.edit', compact('product', 'categories', 'brands', 'images'));
}


    // Update the specified product
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            // Validasi lainnya
        ]);

        // Dapatkan produk
        $product = Products::findOrFail($id);

        // Update data produk
        $product->update([
            // Update atribut produk lainnya
        ]);

        // Hapus gambar lama dan simpan yang baru jika ada gambar baru
        if ($request->hasFile('images')) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('images/products', 'public');
                ProductImage::create([
                    // Simpan gambar baru
                ]);
            }
        }

        // Perbarui status primary image
        foreach ($product->images as $index => $image) {
            $image->update([
                'is_primary' => $index == $validatedData['primary_image'],
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }




    // Delete the specified product
    public function destroy(Products $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product berhasil dihapus.');
    }



}
