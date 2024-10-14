<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    // List all brands
    public function index(Request $request)
    {
        // Cache brands selama 60 menit
        $brands = Cache::remember('brands', 60, function () {
            return Brand::all();
        });
        if ($request->ajax()) {
            $data = Brand::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('brands.edit', $row->id);
                    $deleteUrl = route('brands.destroy', $row->id);
                    return '
                        <div class="dropdown dropup">
                            <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' .
                        $row->id .
                        '" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' .
                        $row->id .
                        '">
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
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.brands.index');
    }

    // Show the form for creating a new brand
    public function create()
    {
        return view('admin.brands.create');
    }

    // Store a newly created brand
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
        ]);

        Brand::create([
            'name' => $request->input('name'),
        ]);
        // Hapus cache
        Cache::forget('brands');

        return redirect()->route('brands.index')->with('success', 'Brand berhasil dibuat.');
    }

    // Show the form for editing the specified brand
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    // Update the specified brand
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug,' . $brand->id,
        ]);

        $brand->update([
            'name' => $request->input('name'),
        ]);
        // Hapus cache
        Cache::forget('brands');

        return redirect()->route('brands.index')->with('success', 'Brand berhasil diperbarui.');
    }

    // Delete the specified brand
    public function destroy(Brand $brand)
    {
        $brand->delete();
        // Hapus cache
        Cache::forget('brands');

        return redirect()->route('brands.index')->with('success', 'Brand berhasil dihapus.');
    }

    // Get data for DataTables
    public function getData(Request $request)
    {
        $brands = Brand::select('id', 'name');

        return DataTables::of($brands)
            ->addColumn('action', function ($brand) {
                $editUrl = route('brands.edit', $brand->id);
                $deleteUrl = route('brands.destroy', $brand->id);
                return '
                    <div class="dropdown dropup">
                        <button class="btn btn-secondary dropdown-toggle btn-sm mt-2 mb-2 me-2" type="button" id="dropdownMenuButton-' .
                    $brand->id .
                    '" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-' .
                    $brand->id .
                    '">
                            <li><a href="' .
                    $editUrl .
                    '" class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a></li>
                            <li><button type="button" class="dropdown-item delete-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" data-id="' .
                    $brand->id .
                    '" data-name="' .
                    $brand->name .
                    '" data-url="' .
                    $deleteUrl .
                    '">
                                <i class="bi bi-trash"></i> Delete
                            </button></li>
                        </ul>
                    </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
