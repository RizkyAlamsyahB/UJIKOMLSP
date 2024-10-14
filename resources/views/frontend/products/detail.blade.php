@extends('frontend.layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <div class="container " style="padding-top: 100px;">
        <div class="row">



            <!-- Main Image Column with Carousel -->
            <div class="col-md-5">
                <div id="carouselMainImage" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach ($product->images as $index => $image)
                            <div class="carousel-item @if ($index === 0) active @endif">
                                <div class="card mx-auto rounded-4" style="width: 100%; max-width: 500px;">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                        class="card-img-top img-fluid rounded-4" loading="lazy" alt="{{ $product->name }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMainImage"
                        data-bs-slide="prev">
                        <i class="bi bi-chevron-left" style="font-size: 2rem; color: black;"></i>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMainImage"
                        data-bs-slide="next">
                        <i class="bi bi-chevron-right" style="font-size: 2rem; color: black;"></i>
                    </button>
                </div>
                <!-- Image Preview Row -->
                <div class="d-flex justify-content-start mt-3 ">
                    @foreach ($product->images as $index => $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                            class="  img-fluid rounded mx-1 preview-image @if ($index === 0) border border-dark @endif"
                            alt="{{ $product->name }}" style="max-width: 70px; max-height: 70px; cursor: pointer;"
                            data-bs-target="#carouselMainImage" data-bs-slide-to="{{ $index }}"
                            data-index="{{ $index }}">
                    @endforeach
                </div>


                <!-- Accordion for Description and Technical Details -->
                <div class="accordion mt-4" id="productAccordion">
                    <div class="accordion-item" style="background: transparent; border: none;">
                        <h2 class="accordion-header" id="headingDescription">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDescription" aria-expanded="true"
                                aria-controls="collapseDescription" style="background: transparent;">
                                <strong>Deskripsi Produk</strong>
                            </button>
                        </h2>
                        <div id="collapseDescription" class="accordion-collapse collapse show"
                            aria-labelledby="headingDescription" data-bs-parent="#productAccordion">
                            <div class="accordion-body" style="background: transparent;">
                                {{ $product->description }}
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item" style="background: transparent; border: none;">
                        <h2 class="accordion-header" id="headingDetails">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDetails" aria-expanded="false" aria-controls="collapseDetails"
                                style="background: transparent;">
                                <strong>Detail Teknis</strong>
                            </button>
                        </h2>
                        <div id="collapseDetails" class="accordion-collapse collapse" aria-labelledby="headingDetails"
                            data-bs-parent="#productAccordion">
                            <div class="accordion-body" style="background: transparent;">
                                <ul>
                                    <li><strong>Berat:</strong> {{ $product->weight }} kg</li>
                                    <li><strong>Dimensi:</strong> {{ $product->dimensions }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Product Info Card -->
            <div class="col-md-6">
                <div class="card shadow" style="background-color: transparent; border: none;">
                    <div class="card-body">
                        <!-- Product Name -->
                        <h2 style="font-family: 'Anton'; font-size:45px; color:#ED127C;">
                            {{ $product->name }}
                        </h2>

                        <!-- Product Stock Info -->
                        <p>
                            Stok:
                            <span class="stock-icon">
                                <x-heroicon-s-check-circle style="width: 20px; height: 20px; fill: #16a34a;" />
                            </span>
                            {{ $product->stock_quantity }} Remaining In Stock<br><br>
                            Warna : Black <br><br>

                            <!-- Image Thumbnails -->
                            @foreach ($product->images as $index => $image)
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    class="img-fluid rounded-4 mx-1 preview-image @if ($index === 0) border border-dark @endif"
                                    alt="{{ $product->name }}" style="max-width: 70px; max-height: 70px; cursor: pointer;"
                                    data-bs-target="#carouselMainImage" data-bs-slide-to="{{ $index }}"
                                    data-index="{{ $index }}">
                            @endforeach
                        </p>

                        <!-- Product Price -->
                        <h3 class="text-dark" style="font-family: 'Anton'; font-size:20px;">
                            Rp. {{ number_format($product->price, 2) }}
                        </h3>

                        @php
                            $stockQuantity = $product->stock_quantity; // Ambil jumlah stok produk
                        @endphp

                        <!-- Quantity Selector -->
                        <div class="row mb-3">
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-outline-secondary" id="decreaseQuantity">-</button>
                                <input type="number" name="quantity" id="quantityInput" value="1" min="1"
                                    max="{{ $stockQuantity }}" class="form-control text-center mx-2"
                                    style="max-width: 60px;" required />
                                <button type="button" class="btn btn-outline-secondary" id="increaseQuantity">+</button>
                            </div>
                        </div>

                        <!-- Buttons Layout -->
                        <div class="row">
                            @auth
                                <!-- If the user is authenticated -->
                                <div class="col-6">
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" id="formQuantityInput" value="1">
                                        <button type="submit" class="btn w-100 text-sm text-md"
                                            style="background-color: #ED127C; color: white;">
                                            <i class="bi bi-cart-plus"></i>
                                            <span class="d-none d-sm-inline">Tambah ke Keranjang</span>
                                            <span class="d-inline d-sm-none">Keranjang</span>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('checkout') }}" class="btn w-100 text-sm text-md" style="background-color: white; color: #ED127C;">
                                        <i class="bi bi-bag"></i>
                                        <span class="d-none d-sm-inline">Beli Sekarang</span>
                                        <span class="d-inline d-sm-none">Beli</span>
                                    </a>

                                </div>
                            @else
                                <!-- If the user is not authenticated -->
                                <div class="col-6">
                                    <a href="{{ route('login') }}" class="btn w-100 text-sm text-md"
                                        style="background-color: #ED127C; color: white;">
                                        <i class="bi bi-cart-plus"></i>
                                        <span class="d-none d-sm-inline">Tambah ke Keranjang</span>
                                        <span class="d-inline d-sm-none">Keranjang</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('login') }}" class="btn w-100 text-sm text-md"
                                        style="background-color: white; color: #ED127C;">
                                        <i class="bi bi-bag"></i>
                                        <span class="d-none d-sm-inline">Beli Sekarang</span>
                                        <span class="d-inline d-sm-none">Beli</span>
                                    </a>
                                </div>
                            @endauth
                        </div>
                    </div>

                </div>
            </div>


        </div>

    </div>



    <!-- Tambahkan Carousel Produk Terkait -->
    <div class="related-products mt-5 mb-5 d-none d-md-block">
        <h4 class="mb-4 ms-5" style="font-family: 'Geologica'; font-size:30px;">
            <strong>Produk Ini Juga Cocok Untukmu</strong>
        </h4>

        <div id="relatedProductsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($relatedProducts->chunk(3) as $key => $chunk)
                    <!-- Mengelompokkan produk ke dalam grup yang terdiri dari 3 produk -->
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="row">
                            @foreach ($chunk as $relatedProduct)
                                <div class="col-md-4">
                                    <div class="card rounded-4 shadow p-3 mb-5 bg-body-tertiary position-relative py-4">
                                        <a href="{{ route('detail', $relatedProduct->id) }}"
                                            class="text-decoration-none text-dark">
                                            <img src="{{ asset('storage/' . $relatedProduct->images->first()->image_path) }}"
                                                class="card-img-top small-carousel-img d-flex and justify-content-center"
                                                alt="{{ $relatedProduct->name }}" loading="lazy"
                                                style="max-width: 150px; height: auto; margin: 0 auto;">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                                <p class="card-text text-success">Rp.
                                                    {{ number_format($relatedProduct->price, 2) }}</p>
                                            </div>
                                        </a>
                                        <!-- Icon arrow up right -->
                                        <a href="{{ route('detail', $relatedProduct->id) }}"
                                            class="btn btn-light rounded-circle position-absolute"
                                            style="bottom: 15px; right: 15px;">
                                            <i class="bi bi-arrow-up-right"
                                                style="color: #EB5633; font-size: 1.5rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#relatedProductsCarousel"
                data-bs-slide="prev">
                <i class="bi bi-chevron-left text-dark"></i>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#relatedProductsCarousel"
                data-bs-slide="next">
                <i class="bi bi-chevron-right text-dark"></i>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div>

    <style>
        .carousel-control-prev,
        .carousel-control-next {}

        .carousel-control-prev i,
        .carousel-control-next i {
            font-size: 24px;
            /* Adjust icon size if needed */
        }

        .accordion-header {

            border-bottom: 1px solid #000;
            /* Bottom border */
        }

        .accordion-button {
            border: none;
            /* Remove button border */
            box-shadow: none !important;
            /* Remove shadow from the button */
            background: transparent;
            /* Ensure background is transparent */
        }

        .accordion-body {
            padding-top: 15px;
            /* Optional: Add padding above the content */
        }
    </style>
    <!-- JavaScript to handle click events and border for active image -->
    <script>
        // Event listener untuk handle preview image click
        document.querySelectorAll('.preview-image').forEach(function(preview) {
            preview.addEventListener('click', function() {
                // Remove the active border from all preview images
                document.querySelectorAll('.preview-image').forEach(function(img) {
                    img.classList.remove('border', 'border-dark');
                });

                // Add active border to the clicked preview image
                this.classList.add('border', 'border-dark');

                // Trigger the carousel to slide to the clicked image
                var index = this.getAttribute('data-bs-slide-to');
                var carousel = new bootstrap.Carousel(document.getElementById('carouselMainImage'));
                carousel.to(index);
            });
        });

        // Event listener untuk handle slide change event
        document.getElementById('carouselMainImage').addEventListener('slid.bs.carousel', function(event) {
            // Remove the active border from all preview images
            document.querySelectorAll('.preview-image').forEach(function(img) {
                img.classList.remove('border', 'border-dark');
            });

            // Add active border to the preview image corresponding to the active slide
            var activeIndex = event.to;
            var activePreview = document.querySelector('.preview-image[data-index="' + activeIndex + '"]');
            if (activePreview) {
                activePreview.classList.add('border', 'border-dark');
            }
        });
    </script>

    <script>
        document.getElementById('top-left').addEventListener('click', function() {
            Toastify({
                text: "Top Left Notification",
                duration: 3000,
                gravity: "top", // "top" or "bottom"
                position: "left", // "left", "center" or "right"
                backgroundColor: "#4CAF50", // You can customize color
            }).showToast();
        });

        document.getElementById('top-center').addEventListener('click', function() {
            Toastify({
                text: "Top Center Notification",
                duration: 3000,
                gravity: "top", // "top" or "bottom"
                position: "center", // "left", "center" or "right"
                backgroundColor: "#2196F3", // You can customize color
            }).showToast();
        });
    </script>

<script>
    const decreaseButton = document.getElementById('decreaseQuantity');
    const increaseButton = document.getElementById('increaseQuantity');
    const quantityInput = document.getElementById('quantityInput');
    const formQuantityInput = document.getElementById('formQuantityInput');
    const maxStock = {{ $stockQuantity }}; // Batas stok

    decreaseButton.addEventListener('click', () => {
        if (quantityInput.value > 1) {
            quantityInput.value--;
            formQuantityInput.value = quantityInput.value; // Update hidden input value
            increaseButton.disabled = false; // Enable the "+" button if it was disabled
        }
    });

    increaseButton.addEventListener('click', () => {
        if (quantityInput.value < maxStock) {
            quantityInput.value++;
            formQuantityInput.value = quantityInput.value; // Update hidden input value
        }

        // Disable the "+" button if max stock is reached
        if (quantityInput.value >= maxStock) {
            increaseButton.disabled = true;
        }
    });

    quantityInput.addEventListener('input', () => {
        // Update hidden input value on direct input change
        formQuantityInput.value = quantityInput.value;

        // Ensure input value does not exceed stock
        if (quantityInput.value >= maxStock) {
            increaseButton.disabled = true;
            quantityInput.value = maxStock; // Set to max if exceeded
        } else {
            increaseButton.disabled = false; // Enable "+" button if below max
        }

        // Prevent going below 1
        if (quantityInput.value <= 1) {
            decreaseButton.disabled = true;
        } else {
            decreaseButton.disabled = false;
        }
    });
</script>
    <script src="assets/extensions/toastify-js/src/toastify.js"></script>
    <script src="assets/static/js/pages/toastify.js"></script>
@endsection
