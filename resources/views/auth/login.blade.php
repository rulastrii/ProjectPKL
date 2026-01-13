@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card card-md">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Login to your account</h2>
@if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tambahan alert khusus inactive --}}
@if ($errors->has('inactive'))
    <div class="alert alert-warning">
        {{ $errors->first('inactive') }}
    </div>
@endif
        <form action="{{ route('login.post') }}" method="POST" autocomplete="off" novalidate>
            @csrf
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" autocomplete="off" required>
            </div>

            <div class="mb-2">
                <label class="form-label">
                    Password
                    <span class="form-label-description">
                        <a href="{{ route('forgot-password.form') }}">I forgot password</a>
                    </span>
                </label>
                <div class="input-group input-group-flat">
    <input type="password" id="password" name="password" class="form-control" placeholder="Your password" autocomplete="off" required>
    <span class="input-group-text">
        <a href="javascript:void(0)" id="togglePassword" class="link-secondary" title="Show password">
            
            <!-- Eye (default) -->
            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
            </svg>

            <!-- Eye-off -->
            <svg id="icon-eye-off" style="display:none;" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 3l18 18"/>
                <path d="M10.584 10.587a2 2 0 0 0 2.829 2.828"/>
                <path d="M9.88 4.12c.66 -.075 1.34 -.12 2.12 -.12c3.6 0 6.6 2 9 6c-.563 .938 -1.166 1.773 -1.805 2.5m-2.527 2.177c-1.47 .92 -3.11 1.403 -4.668 1.323c-3.217 -.187 -5.969 -2.26 -7.999 -5.999c.538 -.938 1.143 -1.773 1.805 -2.5"/>
            </svg>

        </a>
    </span>
</div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
            </div>
        </form>
    </div>
</div>

<div class="text-center text-secondary mt-3">
    Belum punya akun guru?
    <a href="{{ route('register') }}">Daftar Guru</a>
    <div class="small mt-1">
        <span class="text-success">
            ✔ Data guru akan diverifikasi oleh admin sebelum akun diaktifkan
        </span>
    </div>
</div>


@endsection
