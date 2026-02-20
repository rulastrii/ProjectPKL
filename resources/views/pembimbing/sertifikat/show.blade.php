@extends('layouts.app')
@section('title','Detail Sertifikat')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">

    <div class="card shadow-sm">

     {{-- Card Header --}}
     <div class="card-header">
      <h3 class="card-title mb-0">Detail Sertifikat</h3>
     </div>

     {{-- Card Body --}}
     <div class="card-body p-0">
      <div class="table-responsive">

       <table class="table table-hover table-bordered mb-0">
        <tbody>

         <tr>
          <th class="bg-light text-muted" width="30%">Nama Peserta</th>
          <td class="fw-semibold">{{ $sertifikat->siswa->nama ?? '-' }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Nomor Sertifikat</th>
          <td>{{ $sertifikat->nomor_sertifikat }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Nomor Surat</th>
          <td>{{ $sertifikat->nomor_surat }}</td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Periode</th>
          <td>
           {{ \Carbon\Carbon::parse($sertifikat->periode_mulai)->format('d F Y') }}
           –
           {{ \Carbon\Carbon::parse($sertifikat->periode_selesai)->format('d F Y') }}
          </td>
         </tr>

         <tr>
          <th class="bg-light text-muted">Tanggal Terbit</th>
          <td>
           {{ \Carbon\Carbon::parse($sertifikat->tanggal_terbit)->format('d F Y') }}
          </td>
         </tr>

         <tr>
          <th class="bg-light text-muted">File Sertifikat</th>
          <td>
           @if($sertifikat->file_path)
            <a href="{{ asset($sertifikat->file_path) }}"
               target="_blank"
               class="btn btn-success btn-sm">
             <i class="ti ti-download"></i> Download PDF
            </a>
           @else
            <span class="badge bg-secondary">Belum tersedia</span>
           @endif
          </td>
         </tr>

        </tbody>
       </table>

      </div>
     </div>

     {{-- Card Footer --}}
     <div class="card-footer d-flex justify-content-end">
      <a href="{{ route('pembimbing.sertifikat.index') }}"
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
