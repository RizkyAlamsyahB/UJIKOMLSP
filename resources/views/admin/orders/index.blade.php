@extends('layouts.app')

@section('content')
    @section('main-content')
        @section('page-title')
            <h3>Orders</h3>
        @endsection

        @section('breadcrumb')
            Index Orders
        @endsection

        <div class="card" style="border-radius: 12px;">
            <div class="card-header">
                <h5>Total Orders: {{ $orderCount }}</h5>
                {{-- <h5>Total Order Price: {{ number_format($totalOrderPrice, 2) }}</h5> --}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered yajra-datatable" id="orders-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->status }}</td>
                                    <td>{{ number_format($order->total_price, 2) }}</td>
                                    <td>{{ $order->order_date }}</td>
                                    <td>
                                        <button class="btn btn-danger delete-btn" data-id="{{ $order->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- CSS & JavaScript untuk DataTables -->
        <link href="{{ asset('template/dist/assets/extensions/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">

        <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('template/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

        <!-- Inisialisasi DataTables tanpa server-side -->
        <script>
            $(document).ready(function() {
                $('#orders-table').DataTable();
            });
        </script>
    @endsection
@endsection
