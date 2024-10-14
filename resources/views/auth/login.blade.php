@extends('layouts.app')

@section('content')
<div id="auth" class="d-flex justify-content-center align-items-center vh-100"> <!-- Center vertically and horizontally -->
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="card shadow p-3 mb-5 bg-body-tertiary rounded" style="width: 100%; max-width: 700px; margin: auto;"> <!-- Card with fixed max width -->
                <div class="auth-logo mb-3 text-center">
                    <a href="{{ url('/') }}"><img src="{{ asset('template/dist/assets/compiled/png/medical_life.png') }}" alt="Logo" style="width: 200px; height: auto;"></a>
                </div>
                <h1 class="auth-title text-center" style="color: #27292C; font-weight: bold;">Log in.</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" id="email" name="email" class="form-control form-control-xl @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" id="password" name="password" class="form-control form-control-xl @error('password') is-invalid @enderror" required
                            autocomplete="current-password" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-check form-check-lg d-flex align-items-end">
                        <input class="form-check-input me-2" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-gray-600" for="remember">
                            Keep me logged in
                        </label>
                    </div>
                    <button type="submit" class="btn btn-block btn-lg shadow-lg mt-4" style="background-color: #87C6ED; color: white;">
                        {{ __('Login') }}
                    </button>
                </form>

                <div class="text-center mt-4">
                    <h6 class="text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="font-bold" style="color: #87C6ED;">Sign up</a>.</h6>
                    <p>
                        <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #87C6ED; font-size:20px;">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    </p>
                </div>
            </div> <!-- End of Card -->
        </div>
    </div>
</div>
@endsection
