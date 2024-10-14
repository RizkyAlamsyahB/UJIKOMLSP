@extends('layouts.app')

@section('page-title')
    {{-- Judul halaman --}}
    <h3>Products</h3>
@endsection

@section('breadcrumb')
    {{-- Breadcrumb navigasi --}}
    Index Products
@endsection

@section('main-content')
    {{-- Isi Konten Utama Di Sini --}}
    <div class="card" style="border-radius: 12px;">
        <div class="card-header">
            <a href="{{ route('products.create') }}" class="btn btn-primary" style="border-radius: 16px;">+ Products</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered yajra-datatable" id="products-table">
                    <thead>
                        <tr>
                            <th>No</th> {{-- Index column --}}
                            <th>Name</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock Quantity</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include CSS and JavaScript files -->
    <link href="{{ asset('template/dist/assets/extensions/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}">
    </script>
    <script src="{{ asset('template/dist/assets/static/js/pages/datatables.js') }}"></script>
    <link rel="stylesheet"
        href="{{ asset('template/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        $(document).ready(function() {
            $('#products-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('products.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image',
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'stock_quantity',
                        name: 'stock_quantity'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'brand',
                        name: 'brand'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var url = $(this).data('url');

                $('#deleteModal').find('form').attr('action', url);
                $('#deleteModal').find('.modal-body').text('Are you sure you want to delete category "' +
                    name + '"?');
                $('#deleteModal').modal('show');
            });
        });
    </script>

    <script type="text/javascript">
        @if (session('success'))
            Toastify({
                text: "{{ session('success') }}",
                duration: 3000,
                close: true,
                gravity: "bottom", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                backgroundColor: "#4fbe87",
            }).showToast();
        @endif
    </script>

    <!-- Modal untuk Show Product -->
    <div class="modal fade" id="showProductModal" tabindex="-1" aria-labelledby="showProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showProductModalLabel">Product Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="product-details">
                        <!-- Data produk akan dimuat di sini -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
    // Event handler untuk tombol "Show"
    $(document).on('click', '.show-btn', function() {
        var productId = $(this).data('id');

        // Buat request AJAX untuk mendapatkan data produk
        $.ajax({
            url: '/products/' + productId, // Asumsikan ada route yang menangani ini
            type: 'GET',

            success: function(response) {
                var carouselIndicators = '';
                var carouselInner = '';

                response.images.forEach(function(image, index) {
                    var isActive = index === 0 ? 'active' : '';
                    var altText = `Product Image ${index + 1} - ${response.name}`;

                    carouselIndicators += `<button type="button" data-bs-target="#carouselProductImages" data-bs-slide-to="${index}" class="${isActive}" aria-current="true" aria-label="Slide ${index + 1}"></button>`;
                    carouselInner += `
                        <div class="carousel-item ${isActive}">
                            <img src="/storage/${image.image_path}" class="d-block w-100" alt="${altText}" style="max-height: auto;">
                        </div>
                    `;
                });

                var carouselHtml = `
                    <div id="carouselProductImages" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            ${carouselIndicators}
                        </div>
                        <div class="carousel-inner">
                            ${carouselInner}
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselProductImages" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselProductImages" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                `;

                // Tampilkan data produk di dalam modal
                $('#product-details').html(`
                    <p><strong></strong><br>${carouselHtml}</p>
                    <p><strong>Name:</strong> ${response.name}</p>
                    <p><strong>Description:</strong> ${response.description}</p>
                    <p><strong>Price:</strong> ${response.price}</p>
                    <p><strong>Stock Quantity:</strong> ${response.stock_quantity}</p>
                    <p><strong>Category:</strong> ${response.category ? response.category : '-'}</p>
                    <p><strong>Brand:</strong> ${response.brand ? response.brand : '-'}</p>

                `);

                // Tampilkan modal
                $('#showProductModal').modal('show');
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
});


    </script>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- This will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <form method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Di dalam tag <head> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Di dalam tag <body> sebelum akhir -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endsection
