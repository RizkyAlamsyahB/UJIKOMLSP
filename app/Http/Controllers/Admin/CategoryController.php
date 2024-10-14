<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Cache categories selama 60 menit
        $categories = Cache::remember('categories', 60, function () {
            return Category::all();
        });
        if ($request->ajax()) {
            $data = Category::query();

            return DataTables::of($data)
                ->addIndexColumn() // Adds the DT_RowIndex column
                ->addColumn('action', function ($row) {
                    $editUrl = route('categories.edit', $row->id);
                    $deleteUrl = route('categories.destroy', $row->id);
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

        return view('admin.categories.index');
    }
    public function getData(Request $request)
    {
        $categories = Category::select('id', 'name');

        return DataTables::of($categories)
            ->addColumn('action', function ($category) {
                return '
                    <button class="btn btn-warning btn-edit" data-id="' .
                    $category->id .
                    '">Edit</button>
                    <button class="btn btn-danger btn-delete" data-id="' .
                    $category->id .
                    '">Delete</button>
                ';
            })
            ->make(true);
    }
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
        ]);

        // Buat kategori baru; slug akan diatur otomatis oleh model
        Category::create([
            'name' => $request->input('name'),
            // 'slug' diatur otomatis oleh model jika tidak disediakan
        ]);
        // Hapus cache
        Cache::forget('categories');
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
        ]);

        // Update the category
        $category->update([
            'name' => $request->input('name'),
            // 'slug' diatur otomatis oleh model jika tidak disediakan
        ]);

        // Hapus cache
        Cache::forget('categories');
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        // Hapus cache
        Cache::forget('categories');

        return response()->json(['success' => 'Category deleted successfully.']);
    }
}
