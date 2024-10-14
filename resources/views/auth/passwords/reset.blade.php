@extends('layouts.app')

@section('content')
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('template/dist/assets/compiled/png/logo.png') }}" alt="Logo" style="width: 200px; height: auto;"></a>
                    </div>
                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">Reset Password</h1>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input id="email" type="email" class="form-control form-control-xl @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Email Address" required autocomplete="email" autofocus>
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
                                <i class="bi bi-lock"></i>
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
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5" style="background-color: #435EBE; color: white;">Reset Password</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>

    </div>
@endsection
