@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="text-center mb-4">
                <h2 class="fw-bold">Verify Your Email</h2>
                <p class="text-muted">We've sent a verification link to your email address.</p>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p class="mb-3">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                    </p>

                    <p class="mb-4">
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                {{ __('click here to request another') }}
                            </button>.
                        </form>
                    </p>

                    <div class="text-center">
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-sign-out-alt me-1"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
