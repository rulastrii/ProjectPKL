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

    <form method="POST" action="{{ route('register.store') }}" autocomplete="off" novalidate>
        @csrf

        {{-- NIP --}}
        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" id="nip" name="nip" class="form-control" placeholder="Masukkan NIP" required>
            <small id="nip-status" class="d-block mt-1"></small>
        </div>

        {{-- TANGGAL LAHIR --}}
        <div class="mb-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control" required>
        </div>

        {{-- HASIL DATA GURU --}}
        <div id="guru-result"></div>

        {{-- EMAIL --}}
<div class="mb-3">
    <label class="form-label">Email Aktif</label>
    <input type="email" name="email" class="form-control" placeholder="email@gmail.com" required>
</div>


        {{-- PASSWORD --}}
        <div class="mb-2">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
                <input type="password" name="password" id="password" class="form-control" placeholder="Buat password" required>
                <span class="input-group-text">
                    <a href="javascript:void(0)" id="togglePassword" class="link-secondary" title="Show password">
                        <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                        </svg>
                    </a>
                </span>
            </div>
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-group input-group-flat">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                <span class="input-group-text">
                    <a href="javascript:void(0)" id="toggleConfirmPassword" class="link-secondary" title="Show password">
                        <svg id="confirm-eye" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                        </svg>
                    </a>
                </span>
            </div>
        </div>

        <div class="form-footer">
            <button id="btn-submit" type="submit" class="btn btn-primary w-100" disabled>
                Daftar sebagai Guru
            </button>
        </div>
    </form>
</div>

</div>

<div class="text-center text-secondary mt-3">
    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
</div>

<script>
let timer = null;

function cekDataGuruAuto() {
    const nip = document.getElementById('nip').value;
    const tgl = document.getElementById('tanggal_lahir').value;

    if (nip.length < 10 || !tgl) {
        document.getElementById('nip-status').innerHTML = '';
        document.getElementById('guru-result').innerHTML = '';
        document.getElementById('btn-submit').disabled = true;
        return;
    }

    fetch("{{ route('cek-guru') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ nip: nip, tanggal_lahir: tgl })
    })
    .then(res => res.json())
    .then(res => {
        const nipStatus = document.getElementById('nip-status');
        const result = document.getElementById('guru-result');
        const submit = document.getElementById('btn-submit');

        if (res.status) {
            nipStatus.className = 'd-block mt-1 text-success';
            nipStatus.innerHTML = '✔ Data Valid';

            result.innerHTML = `
                <div class="alert alert-success small mt-2">
                    <strong>${res.data.nama}</strong><br>
                    ${res.data.unit_kerja}
                </div>`;

            submit.disabled = false;
        } else {
            nipStatus.className = 'd-block mt-1 text-danger';
            nipStatus.innerHTML = '✖ Tidak Valid';
            result.innerHTML = '';
            submit.disabled = true;
        }
    })
    .catch(() => {
        const nipStatus = document.getElementById('nip-status');
        nipStatus.className = 'd-block mt-1 text-danger';
        nipStatus.innerHTML = '✖ Gagal koneksi sistem';
        document.getElementById('btn-submit').disabled = true;
    });
}

['nip','tanggal_lahir'].forEach(id => {
    document.getElementById(id).addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(cekDataGuruAuto, 600);
    });
});
</script>

@endsection
