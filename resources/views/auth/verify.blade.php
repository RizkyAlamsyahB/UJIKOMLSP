@extends('layouts.app')

@section('content')
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ url('/') }}"><img src="{{ asset('template/dist/assets/compiled/png/logo.png') }}"
                                alt="Logo" style="width: 150px; height: auto;"></a>
                    </div>
                    <h1 class="auth-title" style="color: #435EBE; font-weight: bold;">{{ __('Verify Your Email Address') }}
                    </h1>
                    <p class="auth-subtitle mb-5">
                        {{ __('Before proceeding, please check your email for a verification link.') }}</p>

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5"
                            style="background-color: #435EBE; color: white;">{{ __('click here to request another') }}</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
@endsection
