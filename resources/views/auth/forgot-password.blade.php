@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="card card-md">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Forgot Password</h2>

        @if(session('success'))
            <div class="alert alert-success">
                Password reset code has been sent! Please check your email and open the 
                <a href="{{ route('reset-password.form') }}">Reset Password</a> page to set a new password.
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('forgot-password.send') }}" method="POST" autocomplete="off" novalidate>
            @csrf
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter email" required value="{{ old('email') }}">
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    <!-- Mail icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                        <path d="M3 7l9 6l9 -6" />
                    </svg>
                    Send me reset code
                </button>
            </div>
        </form>

        <div class="text-center text-secondary mt-3">
            Remember your password? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>
@endsection
