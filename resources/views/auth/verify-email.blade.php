@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="page page-center">
    <div class="container container-tight py-4">
        <h2 class="h2 text-center mb-4">Verify Your Email</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card card-md">
            <div class="card-body text-center">
                <p class="text-secondary mb-4">
                    Please verify your email address before logging in.
                </p>
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">
                        Resend Verification Email
                    </button>
                </form>
                <p class="mt-3">
                    Already verified? <a href="{{ route('login') }}">Login here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
