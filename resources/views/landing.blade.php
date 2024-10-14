@extends('frontend.layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">



    <section id="promotion" class="hero text-center" style="margin-top: 100px;">
        <div class="container">
            <div id="promotionCarousel" class="carousel slide">
                <div class="carousel-inner">
                    @foreach ($promotions as $promotion)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="card" style="background: #FFFFFF; border:none; position: relative;">
                                <img src="{{ asset('storage/' . $promotion->image_path) }}" loading="lazy" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $promotion->title }}</h5>
                                </div>

                                <!-- Custom Buttons Inside Card -->
                                <button class="carousel-control-custom prev-btn" type="button" data-bs-target="#promotionCarousel"
                                    data-bs-slide="prev">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button class="carousel-control-custom next-btn" type="button" data-bs-target="#promotionCarousel"
                                    data-bs-slide="next">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="brands" class="mb-5 mt-5">
        <div class="container">
            <h2 class="text-center mb-4" style="color: #333; font-weight: 700;">Brands</h2>
            <div class="row g-4"> <!-- Gunakan g-4 untuk jarak antar kartu yang lebih lebar -->
                @foreach ($brands as $brand)
                    <div class="col-6 col-md-4 col-lg-3"> <!-- Sesuaikan lebar kolom untuk tampilan responsif -->
                        <div class="card text-center border-0 rounded-3 brand-card position-relative overflow-hidden">
                            <div class="card-body p-4">
                                <!-- Logo Brand -->
                                {{-- <div class="brand-logo mb-3">
                                    <img src="{{ asset('storage/' . $brand->logo_path) }}" alt="{{ $brand->name }}" style="width: 60px; height: auto;">
                                </div> --}}
                                <h5 class="card-title mb-3" style="color: #fff;">{{ $brand->name }}</h5>
                                <a href="{{ route('products.filter', ['brand' => $brand->id]) }}" class="btn btn-outline-light rounded-pill px-4">View Products</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>



    <section id="shop" class="mb-5 mt-5">
        <!-- Main Content -->
        <div class="container mt-5">
            <!-- Filter and Sort Options -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <button class="btn fs-3">FILTER +</button>
                {{-- <div>
                    <button class="btn fs-3">SORT BY: NEWEST</button>
                </div> --}}
            </div>

            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-4 g-4"> <!-- Ubah g-1 menjadi g-3 atau g-4 -->

                @foreach ($products as $product)
                    <div class="col">
                        <div class="card product-card h-100 rounded-4 shadow p-3 mb-5 bg-body-tertiary rounded position-relative py-4"> <!-- Tambahkan py-4 -->


                            <!-- Check if product is new and add a badge -->
                            @if ($product->created_at->diffInDays(now()) <= 7) <!-- 7 days for "New" -->
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">New</span>
                            @endif

                            @php
                                $primaryImage = $product->images()->where('is_primary', true)->first();
                            @endphp
                            @if ($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->image_path) }}" loading="lazy"
                                    class="card-img-top rounded-4" alt="{{ $product->name }}">
                            @else
                                <img src="default-image.jpg" loading="lazy" class="card-img-top rounded-4"
                                    alt="Default Image">
                            @endif

                            <div class="card-body d-flex flex-column bg-transparant">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <div class="d-flex justify-content-between align-items-end mt-auto">
                                    <p class="card-text fw-bold mb-0 me-3 me-md-0" style="color: #ED127C;">Rp.
                                        {{ number_format($product->price, 2) }}</p>
                                    <a href="{{ route('detail', $product->id) }}" class="btn btn-light rounded-circle">
                                        <i class="bi bi-arrow-up-right" style="color: #ED127C; font-size: 1rem;"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </section>

<!-- Menambahkan Section untuk Kategori -->
{{-- <section id="categories" class="mb-5 mt-5">
    <div class="container">
        <h2 class="text-center mb-4">Categories</h2>
        <div class="row g-3">
            @foreach ($categories as $category)
                <div class="col">
                    <div class="card text-center border-0 rounded-3" style="background: linear-gradient(to right, #FF9A00, #FF6A00);">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <a href="{{ route('products.filter', ['category' => $category->id]) }}" class="btn btn-light">View Products</a> <!-- Link untuk melihat produk -->
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section> --}}


    <style>
        @media (max-width: 576px) {
            .card-body {
                padding: 4px;
            }

            .card-title {
                font-size: 1rem;
            }

            .card-text {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 1.2rem;
            }
        }
        /* Brand Card Styling */
.brand-card {
    background: #87C6ED;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.brand-card .brand-logo img {
    transition: transform 0.3s ease;
}

.brand-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.brand-card:hover .brand-logo img {
    transform: scale(1.1);
}

.brand-card .btn-outline-light {
    border-color: #fff;
    color: #fff;
}

.brand-card .btn-outline-light:hover {
    background-color: #fff;
    color: #000000;
    border-color: #fff;
}


    </style>

@endsection
