@extends('frontend.layouts.app')

@section('content')
    <div class="container bg-transparent" style="padding-top: 100px;">
        <h2 class="mb-4">Checkout</h2>

        @if ($cartItems->isEmpty())
            <div class="alert alert-info">Cart Kosong!</div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
                        <div class="card-header bg-light">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Pilih</th>
                                        <th class="text-center">Produk</th>
                                        <th class="text-center">Gambar</th>
                                        <th class="text-center">Kuantitas</th>
                                        <th class="text-center">Harga Satuan</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Aksi</th> <!-- Add column for action -->
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
                                                <td class="align-middle">{{ $item->name }}</td>
                                                <td class="align-middle">
                                                    @if ($item->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                                                             alt="{{ $item->name }}" class="img-fluid"
                                                             style="max-width: 100px; max-height: 100px;">
                                                    @else
                                                        <img src="{{ asset('images/default-product.png') }}" alt="Default Image"
                                                             class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                                    @endif
                                                </td>
                                                <td class="text-center align-middle">
                                                    {{ $item->pivot->quantity }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    Rp. {{ number_format($item->pivot->price, 2) }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    Rp. {{ number_format($item->pivot->quantity * $item->pivot->price, 2) }}
                                                </td>
                                                <td class="text-center align-middle">
                                                    <!-- Add delete form here -->
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-times"></i> <!-- FontAwesome icon for 'X' -->
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 text-right">
                <div class="card shadow mb-5 bg-body-tertiary rounded" style="display: inline-block; float: right; width: 300px;">
                    <div class="card-body text-right">
                        <div class="form-group">
                            <label for="totalAmount" class="font-weight-bold">Grand Total:</label>
                            <h4>Total: Rp. <span id="totalPrice">0.00</span></h4>
                        </div>
                        <form action="{{ route('checkout.pay') }}" method="POST">
                            @csrf
                            <input type="hidden" name="totalAmount" id="totalAmount" value="0">
                            <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                            <button type="submit" class="btn" style="background-color: #ED127C; color: white; border-radius: 50px;">Buat Pesanan</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script>
            document.querySelectorAll('.product-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let totalPrice = 0;
                    document.querySelectorAll('.product-checkbox:checked').forEach(function(checkedBox) {
                        totalPrice += parseFloat(checkedBox.getAttribute('data-price'));
                    });
                    document.getElementById('totalPrice').innerText = totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 2 });
                    document.getElementById('totalAmount').value = totalPrice.toLocaleString('id-ID', { minimumFractionDigits: 2 });
                });
            });
        </script>
    </div>
@endsection
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<style>
    .table {
        font-family: 'sans-serif';
    }
</style>
