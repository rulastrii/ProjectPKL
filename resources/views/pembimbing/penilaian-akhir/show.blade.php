@extends('layouts.app')
@section('title','Detail Penilaian Akhir')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">

    <div class="card shadow-sm">

     {{-- Card Header --}}
     <div class="card-header">
      <h3 class="card-title mb-0">
        Detail Penilaian Akhir
      </h3>
     </div>

     {{-- Card Body --}}
     <div class="card-body p-0">
      <div class="table-responsive">

       <table class="table table-hover table-bordered mb-0">
        <tbody>

         <tr>
          <th class="bg-light text-muted" width="30%">Nama Siswa</th>
          <td class="fw-semibold">{{ $penilaian->siswa->nama ?? '-' }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Nilai Tugas</th>
          <td>{{ number_format($penilaian->nilai_tugas, 2) }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Nilai Laporan</th>
          <td>{{ number_format($penilaian->nilai_laporan, 2) }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Nilai Keaktifan</th>
          <td>{{ number_format($penilaian->nilai_keaktifan, 2) }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Nilai Sikap</th>
          <td>{{ number_format($penilaian->nilai_sikap, 2) }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Nilai Akhir</th>
          <td>
            {{ number_format($penilaian->nilai_akhir, 2) }}
          </td>
         </tr>

        </tbody>
       </table>

      </div>
     </div>

     {{-- Card Footer --}}
     <div class="card-footer d-flex justify-content-end">
      <a href="{{ route('pembimbing.penilaian-akhir.index') }}"
         class="btn btn-outline-secondary btn-sm">
       <i class="ti ti-arrow-left"></i> Kembali
      </a>
     </div>

    </div>

   </div>
  </div>
 </div>
</div>

@endsection
