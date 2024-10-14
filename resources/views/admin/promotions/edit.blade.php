@extends('layouts.app')

@section('content')
    {{-- Konten utama halaman --}}

@section('main-content')
    {{-- Konten spesifik halaman --}}

@section('page-title')
    {{-- Judul halaman --}}
    <h3>Edit Promotion</h3>
@endsection

@section('breadcrumb')
    {{-- Breadcrumb navigasi --}}
    Edit Promotion
@endsection

    {{-- Isi Konten Utama Di Sini --}}
    <div class="card" style="border-radius: 12px;">
        <div class="card-header">
            <a href="{{ route('promotions.index') }}" class="btn btn-secondary" style="border-radius: 16px;">Back to List</a>
        </div>
        <div class="card-body">
            <form action="{{ route('promotions.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description', $promotion->description) }}">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $promotion->start_date->format('Y-m-d')) }}" placeholder="Select Start Date...">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $promotion->end_date->format('Y-m-d')) }}" placeholder="Select End Date...">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image_path" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image_path') is-invalid @enderror" id="image_path" name="image_path">
                    @error('image_path')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Maximum file size: 10MB. Allowed formats: jpg, jpeg, png.</small>
                    @if($promotion->image_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $promotion->image_path) }}" alt="Promotion Image" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                @endif

                </div>

                <button type="submit" class="btn btn-primary" style="border-radius:8px;">Save</button>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#start_date", {
            dateFormat: "d-m-Y",
        });
    </script>
    <script>
        flatpickr("#end_date", {
            dateFormat: "d-m-Y",
        });
    </script>
@endsection
