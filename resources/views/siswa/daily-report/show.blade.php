@extends('layouts.app')
@section('title','Detail Laporan Harian PKL')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards justify-content-center">
   <div class="col-md-8">
    <div class="card">

     {{-- HEADER --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Detail Laporan Harian</h3>
      <a href="{{ route('siswa.daily-report.index') }}"
         class="btn btn-secondary ms-auto btn-sm">
        <i class="ti ti-arrow-left"></i> Kembali
      </a>
     </div>

     {{-- BODY --}}
     <div class="card-body">

      {{-- INFO SISWA --}}
      <div class="mb-4">
        <label class="form-label">Peserta</label>
        <div class="form-control bg-light">
          <strong>
            {{ $report->siswa?->nama ?? '-' }}
          </strong><br>
          NISN: {{ $report->siswa?->nisn ?? '-' }} |
          Kelas: {{ $report->siswa?->kelas ?? '-' }} |
          Jurusan: {{ $report->siswa?->jurusan ?? '-' }}
        </div>
      </div>

      <div class="row g-3">

        {{-- TANGGAL --}}
        <div class="col-md-6">
          <label class="form-label">Tanggal</label>
          <div class="form-control bg-light">
            {{ $report->tanggal_formatted ?? $report->tanggal }}
          </div>
        </div>

        {{-- STATUS --}}
        <div class="col-md-6">
          <label class="form-label">Status Verifikasi</label>
          @php
            $badge = match($report->status_verifikasi) {
                'terverifikasi' => 'bg-success-soft text-success',
                'ditolak'       => 'bg-danger-soft text-danger',
                default         => 'bg-warning-soft text-warning'
            };
          @endphp
          <div>
            <span class="badge {{ $badge }}">
              {{ $report->status_verifikasi_label ?? 'Belum Diverifikasi' }}
            </span>
          </div>
        </div>

        {{-- RINGKASAN --}}
        <div class="col-12">
          <label class="form-label">Ringkasan Kegiatan</label>
          <div class="form-control bg-light" style="min-height:120px">
            {{ $report->ringkasan }}
          </div>
        </div>

        {{-- KENDALA --}}
        <div class="col-12">
          <label class="form-label">Kendala</label>
          <div class="form-control bg-light" style="min-height:80px">
            {{ $report->kendala ?? '-' }}
          </div>
        </div>

        {{-- SCREENSHOT --}}
        <div class="col-12">
          <label class="form-label">Screenshot</label>
          @if($report->screenshot)
            <div>
              <a href="{{ asset('uploads/daily-report/'.$report->screenshot) }}"
                 target="_blank"
                 class="btn btn-outline-secondary btn-sm">
                <i class="ti ti-photo"></i> Lihat Screenshot
              </a>
            </div>
          @else
            <div class="text-muted">- Tidak ada screenshot -</div>
          @endif
        </div>

      </div>
     </div>


    </div>
   </div>
  </div>
 </div>
</div>
@endsection
