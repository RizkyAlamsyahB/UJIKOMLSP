@extends('frontend.layouts.app')

@section('content')
    <div class="container" style="padding-top: 100px;">
        <h2 class="mb-4">Invoice</h2>

        <div class="card shadow p-3 mb-5 bg-body-tertiary rounded">
            <div class="card-header bg-light">
                <h4>Order Summary</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Kuantitas</th>
                                <th class="text-center">Harga Satuan</th>
                                <th class="text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                                <tr>
                                    <td class="align-middle text-center">{{ $item->product->name }}</td>
                                    <td class="align-middle text-center">{{ $item->quantity }}</td>
                                    <td class="align-middle text-center">Rp. {{ number_format((float)$item->price, 2) }}</td>
                                    <td class="align-middle text-center">Rp. {{ number_format((float)($item->quantity * $item->price), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <h4>Total to Pay: Rp. {{ number_format((float)$totalPrice, 2) }}</h4>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button id="pay-button" class="btn btn-primary" style="margin-top: 20px;">Proceed to Payment</button>
        </div>

        <form action="{{ route('payment.success') }}" id="submit_form" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $orderId }}">
            <input type="hidden" name="transaction_status" id="transaction_status">
        </form>
    </div>

    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    document.getElementById('transaction_status').value = result.transaction_status;
                    document.getElementById('submit_form').submit();
                },
                onPending: function(result) {
                    document.getElementById('transaction_status').value = result.transaction_status;
                    document.getElementById('submit_form').submit();
                },
                onError: function(result) {
                    alert('Payment failed!');
                }
            });
        });
    </script>
@endsection
