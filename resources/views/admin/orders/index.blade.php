@extends('layouts.app')

@section('content')
    {{-- Konten utama halaman --}}

@section('main-content')
    {{-- Konten spesifik halaman --}}

@section('page-title')
    {{-- Judul halaman --}}
    <h3>Order</h3>
@endsection

@section('breadcrumb')
    {{-- Breadcrumb navigasi --}}
    Index Order
@endsection

    {{-- Isi Konten Utama Di Sini --}}
    <div class="card" style="border-radius: 12px;">
        <div class="card-header">

        </div>
        <div class="card-body">
            <h5>Total Orders: {{ $orderCount }}</h5>
            <div class="table-responsive">
                <table class="table table-bordered yajra-datatable" id="orders-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->total }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Include CSS and JavaScript files --}}
    <link href="{{ asset('template/dist/assets/extensions/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('template/dist/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/static/js/pages/datatables.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.orders.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'status', name: 'status' },
                    { data: 'total', name: 'total' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var url = $(this).data('url');

                $('#deleteModal').find('form').attr('action', url);
                $('#deleteModal').find('.modal-body').text('Are you sure you want to delete order "' + name + '"?');
                $('#deleteModal').modal('show');
            });
        });
    </script>

    <script type="text/javascript">
        @if(session('success'))
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
@endsection
