@extends('frontend.layouts.app')

@section('content')
    <div class="container bg-transparant" style="padding-top: 100px;">
        <h2 class="mb-4">Cart</h2>

        @if ($cartItems->isEmpty())
            <div class="alert alert-info">
                Cart Kosong!
            </div>
        @else
            <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
                <div class="card-header bg-light">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Pilih</th>
                                <th class="text-center align-middle">Produk</th>
                                <th class="text-center align-middle">Kuantitas</th>
                                <th class="text-center align-middle">Harga Satuan</th>
                                <th class="text-center align-middle">Total</th>
                                <th class="text-center align-middle">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <td class="align-middle">
                                            <input type="checkbox" class="product-checkbox" data-price="{{ $item->pivot->quantity * $item->pivot->price }}">
                                          
                                        </td>
                                        <td class="align-middle">
                                            @if ($item->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                                                    alt="{{ $item->name }}" class="img-fluid"
                                                    style="max-width: 100px; max-height: 100px;">
                                            @else
                                                <img src="{{ asset('images/default-product.png') }}" alt="Default Image"
                                                    class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                            @endif
                                            {{ $item->name }}
                                        </td>
                                        <td class="text-center align-middle">
                                            Rp. {{ number_format($item->pivot->price, 2) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                                        <button type="button"
                                                            class="btn btn-outline-secondary decrease-quantity"
                                                            data-id="{{ $item->id }}">-</button>
                                                        <input type="number" id="quantityInput{{ $item->id }}"
                                                            name="quantity" value="{{ $item->pivot->quantity }}"
                                                            class="form-control text-center mx-2" style="max-width: 60px;"
                                                            min="1" required>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary increase-quantity"
                                                            data-id="{{ $item->id }}">+</button>
                                                    </div>
                                                    <div>
                                                        <button type="submit" class="btn btn-sm">Update</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="text-center align-middle">
                                            Rp. {{ number_format($item->pivot->quantity * $item->pivot->price, 2) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <h4>Total Harga: Rp. <span id="totalPrice">0.00</span></h4>
            </div>
        @endif
        <!-- Checkout Button -->
        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn" id="checkoutBtn" style="background-color: #ED127C; color: white;">Checkout</button>

        </div>
    @section('related-product')
    @endsection
    <script>
        document.getElementById('checkoutBtn').addEventListener('click', function() {
            const selectedProducts = Array.from(document.querySelectorAll('.product-check:checked'))
                .map(checkbox => checkbox.value);

            if (selectedProducts.length > 0) {
                // Process checkout with selected products
                console.log('Selected products:', selectedProducts);
                // Add your checkout logic here, e.g., submit via AJAX or form
            } else {
                alert('Please select at least one product to checkout.');
            }
        });
    </script>

</div>
<style>
    .table {
        font-family: 'sans-serif';
    }
</style>

<!-- Script for increase and decrease button -->
<script>
    document.querySelectorAll('.product-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            let totalPrice = 0;
            document.querySelectorAll('.product-checkbox:checked').forEach(function(checkedBox) {
                totalPrice += parseFloat(checkedBox.getAttribute('data-price'));
            });
            document.getElementById('totalPrice').innerText = totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 2 });
        });
    });
</script>

@endsection
