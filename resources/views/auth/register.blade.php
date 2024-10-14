@extends('layouts.app')

@section('content')
<div id="auth" class="d-flex justify-content-center align-items-center vh-100"> <!-- Centering the content -->
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 100%; max-width: 700px;  margin: auto;"> <!-- Card wrapper -->
                <div class="auth-logo mb-3 text-center">
                    <a href="{{ url('/') }}"><img src="{{ asset('template/dist/assets/compiled/png/medical_life.png') }}" alt="Logo" style="width: 200px; height: auto;"></a>
                </div>
                <h5 class="auth-title text-center" style="color: #27292C; font-weight: bold;">Sign Up</h5>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="name" type="text" class="form-control form-control-xl @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Name" required autocomplete="name" autofocus>
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="email" type="email" class="form-control form-control-xl @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email">
                        <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password" type="password" class="form-control form-control-xl @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="new-password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input id="password-confirm" type="password" class="form-control form-control-xl" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block btn-lg shadow-lg mt-4" style="background-color: #87C6ED; color: white;">Sign Up</button>
                </form>

                <div class="text-center mt-4 text-lg fs-4">
                    <p class='text-gray-600'>Already have an account? <a href="{{ route('login') }}" class="font-bold" style="color: #87C6ED;">Log in</a>.</p>
                </div>
            </div> <!-- End of Card -->
        </div>
    </div>
</div>
@endsection
