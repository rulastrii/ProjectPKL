@extends('layouts.app')
@section('title','Detail Rekap Peserta')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">

   {{-- HEADER --}}
   <div class="col-12">
    <div class="card">
     <div class="card-header">
      <h3 class="card-title">Detail Rekap Peserta</h3>
     </div>

     @php
        $pembimbing = $siswa->pembimbingMahasiswa ?? $siswa->pembimbingPkl;
     @endphp

     {{-- INFO SISWA --}}
     <div class="card-body">
      <div class="row">
       <div class="col-md-6">
        <table class="table table-sm table-borderless">
         <tr>
          <th width="150">Nama</th>
          <td class="fw-semibold">{{ $siswa->nama }}</td>
         </tr>
         <tr>
          <th>Pembimbing</th>
          <td>{{ $pembimbing?->user?->name ?? '-' }}</td>
         </tr>
         <tr>
          <th>Total Presensi</th>
          <td>{{ $siswa->presensi->count() }}</td>
         </tr>
        </table>
       </div>

       {{-- REKAP PRESENSI --}}
       <div class="col-md-6">
        <div class="row text-center">
         <div class="col-3">
          <span class="badge bg-green-lt d-block mb-1">Hadir</span>
          <strong>{{ $rekapPresensi['hadir'] }}</strong>
         </div>
         <div class="col-3">
          <span class="badge bg-blue-lt d-block mb-1">Izin</span>
          <strong>{{ $rekapPresensi['izin'] }}</strong>
         </div>
         <div class="col-3">
          <span class="badge bg-yellow-lt d-block mb-1">Sakit</span>
          <strong>{{ $rekapPresensi['sakit'] }}</strong>
         </div>
         <div class="col-3">
          <span class="badge bg-red-lt d-block mb-1">Absen</span>
          <strong>{{ $rekapPresensi['absen'] }}</strong>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>

   {{-- LAPORAN --}}
   <div class="col-12">
    <div class="card">
     <div class="card-header">
      <h3 class="card-title">Laporan Harian</h3>
     </div>

     <div class="table-responsive">
      <table class="table card-table table-vcenter">
       <thead>
        <tr>
         <th width="150">Tanggal</th>
         <th>Ringkasan</th>
         <th width="180">Status</th>
        </tr>
       </thead>
       <tbody>
        @forelse ($siswa->laporan as $laporan)
        <tr>
         <td>{{ $laporan->tanggal_formatted ?? $laporan->tanggal }}</td>
         <td>{{ $laporan->ringkasan ?? '-' }}</td>
         <td>
          <span class="badge
            {{ $laporan->status_verifikasi === 'terverifikasi' ? 'bg-green-lt' :
               ($laporan->status_verifikasi === 'ditolak' ? 'bg-red-lt' : 'bg-secondary-lt') }}">
            {{ ucfirst($laporan->status_verifikasi ?? 'belum diverifikasi') }}
          </span>
         </td>
        </tr>
        @empty
        <tr>
         <td colspan="3" class="text-center text-muted">
          Tidak ada laporan
         </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>
    </div>
   </div>

   {{-- TUGAS --}}
   <div class="col-12">
    <div class="card">
     <div class="card-header">
      <h3 class="card-title">Tugas</h3>
     </div>

     <div class="table-responsive">
      <table class="table card-table table-vcenter">
       <thead>
        <tr>
         <th>Nama Tugas</th>
         <th width="120">Nilai</th>
         <th width="180">Status</th>
        </tr>
       </thead>
       <tbody>
        @forelse ($siswa->tugasSubmit as $submit)
        <tr>
         <td>{{ $submit->tugas->judul ?? '-' }}</td>
         <td>{{ $submit->skor ?? '-' }}</td>
         <td>
          <span class="badge
            {{ $submit->status === 'selesai' ? 'bg-green-lt' : 'bg-yellow-lt' }}">
            {{ ucfirst($submit->status) }}
          </span>
         </td>
        </tr>
        @empty
        <tr>
         <td colspan="3" class="text-center text-muted">
          Tidak ada tugas
         </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- FOOTER --}}
     <div class="card-footer text-end">
        <a href="{{ route('pembimbing.rekap.index') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('pembimbing.rekap.pdf', $siswa->id) }}" class="btn btn-danger ms-2">
            <i class="ti ti-file-text"></i> Cetak PDF
        </a>
     </div>

    </div>
   </div>

  </div>
 </div>
</div>
@endsection
