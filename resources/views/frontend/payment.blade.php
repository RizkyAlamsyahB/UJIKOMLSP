@extends('frontend.layouts.app')

@section('content')
    <div class="container" style="padding-top: 100px;">
        <div class="card shadow-sm border-0 rounded-lg">
            <div class="card-header text-center bg-primary text-white rounded-top">
                <h2>Invoice</h2>
            </div>
            <div class="card-body">
                <!-- Order Details Section -->
                <div class="mb-4">
                    <h4 class="font-weight-bold">Order Details</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Order ID: <strong>{{ $orderId }}</strong></li>
                        <li class="list-group-item">Payment Status: <strong id="payment-status">Pending</strong></li>
                        <li class="list-group-item">Total Amount: <strong>Rp. {{ number_format((float) $totalPrice, 2) }}</strong></li>
                    </ul>
                </div>

                <!-- Total Amount to Pay Section -->
                <h3 class="mb-4">Total to Pay: <strong>Rp. {{ number_format((float) $totalPrice, 2) }}</strong></h3>

                <!-- Buttons Section -->
                <div class="text-right">
                    <button id="pay-button" class="btn btn-primary btn-lg shadow mr-2">Proceed to Payment</button>
                    <button class="btn btn-secondary btn-lg shadow mr-2" onclick="printInvoice()">Print</button>
                    <button class="btn btn-warning btn-lg shadow">Cancel Order</button>
                </div>

                <form action="{{ route('payment.success') }}" id="submit_form" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $orderId }}">
                    <input type="hidden" name="transaction_status" id="transaction_status">
                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                </form>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    document.getElementById('transaction_status').value = result.transaction_status;
                    document.getElementById('submit_form').submit();
                    document.getElementById('payment-status').textContent = 'Success';
                },
                onPending: function(result) {
                    document.getElementById('transaction_status').value = result.transaction_status;
                    document.getElementById('submit_form').submit();
                    document.getElementById('payment-status').textContent = 'Pending';
                },
                onError: function(result) {
                    alert('Payment failed!');
                    document.getElementById('payment-status').textContent = 'Failed';
                }
            });
        });

        function printInvoice() {
            // Hide non-printable elements
            var nonPrintableElements = document.querySelectorAll('.card-header, .text-right');
            nonPrintableElements.forEach(function(el) {
                el.style.display = 'none';
            });

            // Print the document
            window.print();

            // Show non-printable elements again after printing
            nonPrintableElements.forEach(function(el) {
                el.style.display = '';
            });
        }
    </script>

    <style>
        .card {
            border-radius: 1.5rem; /* Rounded corners */
        }
        .card-header {
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            transform: scale(1.05);
        }
        .btn-warning {
            background-color: #ff9800;
            border-color: #ff9800;
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn-warning:hover {
            background-color: #e68900;
            transform: scale(1.05);
        }
        .list-group-item {
            background-color: #f8f9fa;
            border: none;
        }
        .list-group-item strong {
            color: #343a40;
        }
    </style>
@endsection
