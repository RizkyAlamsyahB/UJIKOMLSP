<!-- resources/views/order/success.blade.php -->
@extends('frontend.layouts.app')

@section('content')
<div class="container">
    <h1>Order Success!</h1>
    <p>Your payment was successful!</p>
    <p>Order ID: {{ $order->id }}</p>
    <p>Total Price: ${{ $order->total_price }}</p>
    <p>Status: {{ ucfirst($order->status) }}</p>
    <p>Thank you for your order!</p>
</div>
@endsection
