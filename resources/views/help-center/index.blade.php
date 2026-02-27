@extends('layouts.auth')

@section('title', 'Pusat Bantuan')

@section('content')
<div class="card card-md">
    <div class="card-body">

        <h2 class="h2 text-center mb-4">Pusat Bantuan</h2>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('help-center.request') }}" autocomplete="off" novalidate>
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Alasan</label>
                <textarea name="reason" rows="4" class="form-control" placeholder="Tuliskan alasan bantuan" required>{{ old('reason') }}</textarea>
            </div>

            <div class="form-footer">
                <button class="btn btn-primary w-100">
                    <!-- Chat / Help icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M3 20l1 -4a9 9 0 1 1 4 4l-4 1" />
                        <path d="M12 12v.01" />
                        <path d="M12 16v.01" />
                    </svg>
                    Kirim Permintaan
                </button>
            </div>
        </form>

        <div class="text-center text-secondary mt-3">
            Kembali ke <a href="{{ route('welcome') }}">halaman beranda</a>
        </div>


    </div>
</div>
@endsection
