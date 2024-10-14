@extends('layouts.app')

@section('content')
@section('main-content')
@section('page-title')
    <h3>Products</h3>
@endsection

@section('breadcrumb')
    Create Products
@endsection

<section class="row">
    <div class="col-lg-12">
        <div class="card" style="border-radius: 24px;">
            <div class="card-body">

                <!-- Form for creating a new product -->
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="images" class="form-label">Product Images</label>
                            <input type="file" name="images[]" class="form-control" id="images" multiple onchange="previewImages()">
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Select Primary Image</label>
                            <div id="image-preview" class="row"></div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="price" step="0.01"
                                min="0" required>
                        </div>
                        <div class="mb-6 col-lg-6">
                            <label for="dimensions" class="form-label">Dimensions (cm)</label>
                            <textarea name="dimensions" class="form-control" id="dimensions" rows="3"></textarea>

                        </div>


                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" id="stock_quantity"
                                min="0" required>
                        </div>
                        <div class="mb-3 col-lg-6">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" name="weight" class="form-control" id="weight" step="0.01">
                        </div>


                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select name="brand_id" class="form-select" id="brand_id">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-select" id="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>


                    </div>

                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Save</button>
                </form>


            </div>
        </div>
    </div>

</section>
<script>
    function previewImages() {
        var previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = '';
        var files = document.getElementById('images').files;

        Array.from(files).forEach((file, index) => {
            var reader = new FileReader();
            reader.onload = function(e) {
                var imageContainer = document.createElement('div');
                imageContainer.classList.add('col-lg-3', 'mb-3');
                imageContainer.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid mb-2" style="max-height: 150px;">
                    <div class="form-check">
                        <input type="radio" name="primary_image" value="${index}" class="form-check-input" ${index === 0 ? 'checked' : ''}>
                        <label class="form-check-label">Set as Primary</label>
                    </div>
                    <input type="hidden" name="image_orders[${index}]" value="${index}">
                `;
                previewContainer.appendChild(imageContainer);
            };
            reader.readAsDataURL(file);
        });
    }
    </script>
@endsection
@endsection
