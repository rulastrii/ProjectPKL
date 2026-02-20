@extends('layouts.app')
@section('title','Edit Pengajuan PKL')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">

   {{-- Card Daftar Siswa --}}
   <div class="col-12">
    <div class="card">
     <div class="card-header">
      <h3 class="card-title">Daftar Siswa - Pengajuan: {{ $pengajuan->no_surat }}</h3>
      @php
    $statusClass = 'text-secondary';
    $statusText = ucfirst($pengajuan->status);

    // cek status siswa
    if($pengajuan->siswa->where('status','ditolak')->count() > 0) {
        $statusClass = 'text-danger';
        $statusText = 'Ditolak';
    } elseif($pengajuan->siswa->where('status','diterima')->count() > 0) {
        $statusClass = 'text-success';
        $statusText = 'Diterima';
    } elseif($pengajuan->siswa->where('status','diproses')->count() > 0) {
        $statusClass = 'text-warning';
        $statusText = 'Diproses';
    }
@endphp

<span class="ms-auto badge {{ $statusClass }}">
    {{ strtoupper($statusText) }}
</span>

     </div>

     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>Nama Siswa</th>
         <th>Email Siswa</th>
        </tr>
       </thead>
       <tbody>
        @forelse($pengajuan->siswa as $s)
        <tr>
         <td>{{ $s->nama_siswa }}</td>
         <td>{{ $s->email_siswa }}</td>
        </tr>
        @empty
        <tr>
         <td colspan="2" class="text-center text-muted">Belum ada siswa ditambahkan</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>
    </div>
   </div>

   {{-- Card Tambah Siswa --}}
   <div class="col-12">
    <div class="card">
     <div class="card-header">
      <h3 class="card-title">Tambah Siswa</h3>
     </div>
     <div class="card-body">
      <form action="{{ route('guru.pengajuan.addSiswa', $pengajuan->id) }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label">Nama Siswa</label>
          <input type="text" name="nama_siswa" class="form-control" placeholder="Contoh: Budi Santoso" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email Siswa</label>
          <input type="email" name="email_siswa" class="form-control" placeholder="contoh@example.com" required>
        </div>

        <button type="submit" class="btn btn-primary">
          <i class="ti ti-user-plus me-1"></i> Tambah Siswa
        </button>
      </form>
     </div>
    </div>
   </div>

   {{-- Card Submit Pengajuan --}}
   @if($pengajuan->status == 'draft')
   <div class="col-12">
    <div class="card">
     <div class="card-body">
      <form action="{{ route('guru.pengajuan.submit', $pengajuan->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">
          <i class="ti ti-send me-1"></i> Submit Pengajuan
        </button>
      </form>
     </div>
    </div>
   </div>
   @endif

  </div>
 </div>
</div>

@endsection
