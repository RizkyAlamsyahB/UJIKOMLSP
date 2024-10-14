@extends('layouts.app')

@section('content')
@section('main-content')
@section('page-title')
    <h3>Edit Product</h3>
@endsection

@section('breadcrumb')
    Edit Products
@endsection

<section class="row">
    <div class="col-lg-12">
        <div class="card" style="border-radius: 24px;">
            <div class="card-body">

                <!-- Form for editing an existing product -->
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="media" class="form-label">Product Media</label>
                            <input type="file" name="media[]" class="form-control" id="media" multiple onchange="previewMedia()">
                            <div id="media-preview" class="d-flex flex-wrap mt-3"></div>
                        </div>


                        <div class="row">

                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Select Primary Image</label>
                                <div id="image-preview" class="row">
                                    @foreach($images as $index => $image)
                                        @php
                                            $fileExtension = pathinfo($image->image_path, PATHINFO_EXTENSION);
                                        @endphp

                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                                            <div class="col-lg-3 mb-3 d-flex flex-column align-items-center">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid mb-2" style="max-height: 150px;">

                                                <div class="form-check mt-2">
                                                    <input type="radio" name="primary_image" value="{{ $index }}" class="form-check-input" {{ $image->is_primary ? 'checked' : '' }}>
                                                    <label class="form-check-label">Set as Primary</label>
                                                </div>

                                                <input type="hidden" name="media_orders[{{ $index }}]" value="{{ $index }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control" id="stock_quantity" min="0" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" class="form-select" id="category_id">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select name="brand_id" class="form-select" id="brand_id">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" name="weight" class="form-control" id="weight" step="0.01" value="{{ old('weight', $product->weight) }}">
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="dimensions" class="form-label">Dimensions (cm)</label>
                            <textarea name="dimensions" class="form-control" id="dimensions" rows="3">{{ old('dimensions', $product->dimensions) }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Update</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function previewMedia() {
    const mediaInput = document.getElementById('media');
    const mediaPreviewContainer = document.getElementById('media-preview');
    mediaPreviewContainer.innerHTML = ''; // Clear previous previews

    const files = mediaInput.files;
    if (files.length > 0) {
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const fileReader = new FileReader();

            fileReader.onload = function(event) {
                const mediaElement = document.createElement('div');
                mediaElement.classList.add('col-lg-3', 'mb-3');

                const previewContainer = document.createElement('div');
                previewContainer.classList.add('media-preview-item', 'me-3', 'mb-3');

                if (file.type.startsWith('image/')) {
                    const image = document.createElement('img');
                    image.src = event.target.result;
                    image.alt = file.name;
                    image.classList.add('img-fluid');
                    image.style.maxHeight = '150px';
                    previewContainer.appendChild(image);
                } else if (file.type.startsWith('video/')) {
                    const video = document.createElement('video');
                    video.src = event.target.result;
                    video.controls = true;
                    video.classList.add('img-fluid');
                    video.style.maxHeight = '150px';
                    previewContainer.appendChild(video);
                }

                const formCheck = document.createElement('div');
                formCheck.classList.add('form-check');
                const radioInput = document.createElement('input');
                radioInput.type = 'radio';
                radioInput.name = 'primary_media';
                radioInput.value = i; // Use index as value
                radioInput.classList.add('form-check-input');
                formCheck.appendChild(radioInput);

                const radioLabel = document.createElement('label');
                radioLabel.classList.add('form-check-label');
                radioLabel.textContent = 'Set as Primary';
                formCheck.appendChild(radioLabel);

                previewContainer.appendChild(formCheck);
                mediaElement.appendChild(previewContainer);
                mediaPreviewContainer.appendChild(mediaElement);
            };

            fileReader.readAsDataURL(file);
        }
    }
}

</script>
@endsection
@endsection
