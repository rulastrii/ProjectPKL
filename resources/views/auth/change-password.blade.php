@extends('layouts.auth')

@section('title', 'Ganti Password')

@section('content')
<div class="card card-md mx-auto" style="max-width: 480px;">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Change Password</h2>

        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
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

        <form method="POST" action="{{ route('password.update') }}" autocomplete="off" novalidate>
            @csrf

            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <div class="input-group input-group-flat">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password baru" required>
                    <span class="input-group-text">
                        <a href="javascript:void(0)" id="togglePassword" class="link-secondary" title="Tampilkan password">
                            <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                            </svg>
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

            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-group input-group-flat">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Konfirmasi password baru" required>
                    <span class="input-group-text">
                        <a href="javascript:void(0)" id="toggleConfirmPassword" class="link-secondary" title="Tampilkan password">
                            <svg id="confirm-eye" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                            </svg>
                            <svg id="confirm-eye-off" style="display:none;" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                <button type="submit" class="btn btn-primary w-100">Simpan Password</button>
            </div>
        </form>

        <div class="text-center text-secondary mt-3">
            Sudah ingat password Anda? <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
</div>

{{-- Script toggle password --}}
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const iconEye = document.querySelector('#icon-eye');
    const iconEyeOff = document.querySelector('#icon-eye-off');

    togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        iconEye.style.display = type === 'password' ? 'block' : 'none';
        iconEyeOff.style.display = type === 'password' ? 'none' : 'block';
    });

    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const passwordConfirm = document.querySelector('#password_confirmation');
    const confirmEye = document.querySelector('#confirm-eye');
    const confirmEyeOff = document.querySelector('#confirm-eye-off');

    toggleConfirmPassword.addEventListener('click', function () {
        const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirm.setAttribute('type', type);
        confirmEye.style.display = type === 'password' ? 'block' : 'none';
        confirmEyeOff.style.display = type === 'password' ? 'none' : 'block';
    });
</script>
@endsection
