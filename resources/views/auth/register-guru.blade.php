@extends('layouts.auth')

@section('title', 'Register Guru')

@section('content')

<div class="card card-md">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Registrasi Guru</h2>

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}"
              method="POST"
              enctype="multipart/form-data"
              autocomplete="off"
              novalidate>
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Nama lengkap"
                       required
                       value="{{ old('name') }}">
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="email@example.com"
                       required
                       value="{{ old('email') }}">
            </div>

            {{-- NIP --}}
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text"
                       name="nip"
                       class="form-control"
                       placeholder="Nomor Induk Pegawai"
                       value="{{ old('nip') }}">
            </div>

            {{-- Sekolah Mengajar --}}
            <div class="mb-3">
                <label class="form-label">Sekolah Mengajar</label>
                <input type="text"
                    name="sekolah"
                    class="form-control"
                    placeholder="Nama sekolah tempat mengajar"
                    required
                    value="{{ old('sekolah') }}">
                    <small class="text-muted">
                        Contoh: SMA Negeri 1 Bandung
                    </small>
            </div>


            {{-- Password --}}
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Password"
                       required>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password"
                       name="password_confirmation"
                       class="form-control"
                       placeholder="Ulangi password"
                       required>
            </div>

            

            {{-- Upload Dokumen --}}
            <div class="mb-3">
                <label class="form-label">Dokumen Pendukung</label>
                <input type="file"
                    name="dokumen"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png"
                    required>

                <small class="text-muted">
                    Dokumen pendukung berupa <strong>SK Mengajar, Surat Tugas, Kartu Pegawai</strong>,
                    atau dokumen resmi lain yang membuktikan status sebagai guru.
                    <br>
                    Format file: PDF / JPG / PNG (Maks. 2MB)
                </small>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">
                    Daftar sebagai Guru
                </button>
            </div>
        </form>
    </div>
</div>

<div class="text-center text-secondary mt-3">
    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
</div>

@endsection
