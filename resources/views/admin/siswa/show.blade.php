@extends('layouts.app')
@section('title','Detail Siswa')

@section('content')
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">

      {{-- PROFILE --}}
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">

            <span class="avatar avatar-xl mb-3"
              style="background-image: url('{{ $siswa->foto
                ? asset('uploads/foto_siswa/'.$siswa->foto)
                : asset('assets/img/default-avatar.png') }}')">
            </span>

            <h3 class="mb-1">{{ $siswa->nama }}</h3>
            <div class="text-muted">{{ $siswa->kelas }} - {{ $siswa->jurusan }}</div>

            <div class="mt-3">
              @if($siswa->isLengkap())
                <span class="text-success fw-semibold">Profil Lengkap</span>
              @else
                <span class="text-danger fw-semibold">Belum Lengkap</span>
              @endif
            </div>

          </div>
        </div>
      </div>

      {{-- DETAIL DATA --}}
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Informasi Siswa</h3>
          </div>

          <div class="card-body">
            <table class="table table-bordered">
              <tr>
                <th width="30%">Nama</th>
                <td>{{ $siswa->nama }}</td>
              </tr>
              <tr>
                <th>NISN</th>
                <td>{{ $siswa->nisn ?? '-' }}</td>
              </tr>
              <tr>
                <th>Kelas</th>
                <td>{{ $siswa->kelas ?? '-' }}</td>
              </tr>
              <tr>
                <th>Jurusan</th>
                <td>{{ $siswa->jurusan ?? '-' }}</td>
              </tr>
              <tr>
                <th>User Login</th>
                <td>{{ $siswa->user->email ?? '-' }}</td>
              </tr>
            </table>
          </div>

          <div class="card-footer text-end">
            <a href="{{ route('admin.siswa.index') }}"
               class="btn btn-secondary">
              <i class="ti ti-arrow-left"></i> Kembali
            </a>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
@endsection
