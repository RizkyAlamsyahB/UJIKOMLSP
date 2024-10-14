@extends('frontend.layouts.app')

@section('content')
<div class="order-success-container">
    <div class="order-success-box" id="orderSuccessBox">
        <div class="icon-checkmark">
            <span>&#10004;</span>
        </div>
        <h1>Thank you for ordering!</h1>
        <p>Your payment was successful!</p>
        <div class="order-details">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Total Price:</strong> Rp.{{ number_format($order->total_price, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Order Date:</strong> {{ $order->order_date }}</p> <!-- Display order date -->
        </div>
        <div class="order-actions">
            <a href="/" class="btn btn-continue-shopping">Lanjut Belanja</a>
            <button class="btn btn-print" onclick="printOrder()">Print</button> <!-- Print button -->
        </div>
    </div>
</div>

<style>
    .order-success-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        background-color: #f7f7f7;
    }

    .order-success-box {
        background-color: white;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
        max-width: 500px;
    }

    .icon-checkmark {
        font-size: 50px;
        color: #ff6600;
        margin-bottom: 20px;
        position: relative;
    }

    .icon-checkmark span {
        font-size: 48px;
        display: inline-block;
    }

    h1 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .order-details {
        margin: 20px 0;
        text-align: left;
        font-size: 16px;
        color: #333;
    }

    .order-details p {
        margin-bottom: 10px;
    }

    .order-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .btn-continue-shopping {
        background-color: #ED127C;  /* Sets the button color to #ED127C */
        color: white;
        border: none;
        padding: 10px 30px;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease; /* Smooth transition on hover */
    }

    .btn-continue-shopping:hover {
        background-color: #C21066;  /* Slightly darker color on hover */
        cursor: pointer;
    }

    .btn {
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        margin-left: 10px; /* Add some margin between buttons */
    }

    .btn-print {
        background-color: #e1c300;  /* Set button color to blue */
        color: white;
        border: none;
        transition: background-color 0.3s ease; /* Smooth transition on hover */
    }

    .btn-print:hover {
        background-color: #ffde08;  /* Slightly darker blue on hover */
        cursor: pointer;
    }
</style>

<script>
    function printOrder() {
        // Get the HTML content to print excluding the order actions
        var orderDetails = document.querySelector('.order-details').innerHTML;
        var printContents = `
            <div style="text-align: center;">
                <h1>Thank you for ordering!</h1>
                <p>Your payment was successful!</p>
                <div style="text-align: left;">
                    ${orderDetails}
                </div>
            </div>
        `;

        var originalContents = document.body.innerHTML;

        // Replace body content with print content
        document.body.innerHTML = printContents;

        // Print the content
        window.print();

        // Restore original body content after printing
        document.body.innerHTML = originalContents;
        // Reload the page to apply any JavaScript functionality again if necessary
        location.reload();
    }
</script>

@endsection
