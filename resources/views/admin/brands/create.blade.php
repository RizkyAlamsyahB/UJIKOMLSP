@extends('layouts.app')

@section('content')
    @section('main-content')
        @section('page-title')
            <h3>Brands</h3>
        @endsection

        @section('breadcrumb')
            Create Brands
        @endsection

        <section class="row">
            <div class="col-lg-12">
                <div class="card" style="border-radius: 24px;">
                    <div class="card-body">

                        <form action="{{ route('brands.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    @endsection
@endsection
