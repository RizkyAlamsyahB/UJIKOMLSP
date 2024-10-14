<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PromotionController extends Controller
{
    public function index(Request $request)
    {
        // Cache promotions selama 60 menit
        $promotions = Cache::remember('promotions', 60, function () {
            return Promotion::all();
        });

        // Update status promosi jika perlu
        foreach ($promotions as $promotion) {
            if (now()->gt($promotion->end_date) && $promotion->status) {
                $promotion->update(['status' => false]);
            }
        }

        if ($request->ajax()) {
            $data = Promotion::query();

            return DataTables::of($data)
                ->addIndexColumn() // Menambahkan kolom DT_RowIndex
                ->addColumn('action', function ($row) {
                    $editUrl = route('promotions.edit', $row->id);
                    $deleteUrl = route('promotions.destroy', $row->id);
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

        return view('admin.promotions.index');
    }



    // Menampilkan formulir untuk membuat promosi baru
    public function create()
    {
        return view('admin.promotions.create');
    }

    // Menyimpan promosi baru
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'image_path' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'nullable|boolean',
        ]);

        // Simpan file
        $path = $request->file('image_path')->store('promotions', 'public');

        // Set status promosi berdasarkan end_date
        $status = now()->lte($request->input('end_date'));

        // Simpan data ke database
        Promotion::create([
            'image_path' => $path,
            'description' => $request->input('description'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => $status,
        ]);

        return redirect()->route('promotions.index')
                         ->with('success', 'Promotion created successfully.');
    }


    // Menampilkan detail promosi
    public function show(Promotion $promotion)
    {
        return view('promotions.show', compact('promotion'));
    }

    // Menampilkan formulir untuk mengedit promosi
    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    // Memperbarui promosi yang sudah ada
   // Memperbarui promosi yang sudah ada
public function update(Request $request, Promotion $promotion)
{
    $request->validate([
        'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'status' => 'nullable|boolean',
    ]);

    if ($request->hasFile('image_path')) {
        // Hapus gambar lama jika ada
        if ($promotion->image_path) {
            Storage::disk('public')->delete($promotion->image_path);
        }
        $path = $request->file('image_path')->store('promotions', 'public');
        $promotion->image_path = $path;
    }

    // Set status promosi berdasarkan end_date
    $status = now()->lte($request->input('end_date'));

    $promotion->update([
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'status' => $status,
    ]);

    return redirect()->route('promotions.index')
                     ->with('success', 'Promotion updated successfully.');
}

    // Menghapus promosi
    public function destroy(Promotion $promotion)
    {
        // Hapus gambar dari storage
        if ($promotion->image_path) {
            Storage::disk('public')->delete($promotion->image_path);
        }

        $promotion->delete();

        // Hapus cache promosi
        Cache::forget('promotions');

        return redirect()->route('promotions.index')
                     ->with('success', 'Promotion deleted successfully.');
    }
}
