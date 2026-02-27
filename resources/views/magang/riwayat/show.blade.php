@extends('layouts.app')
@section('title','Detail Riwayat Magang')
@section('content')

<div class="page-body">
  <div class="container-xl">
    <h3 class="mb-4">Detail Riwayat Magang</h3>

    <div class="row row-cards">
      <div class="col-12 col-md-8">
        <div class="card shadow-sm">
          <div class="card-body">

            {{-- Perusahaan / Instansi --}}
            <div class="mb-3">
              <h6 class="text-muted mb-1"><i class="ti ti-building text-primary me-1"></i> Perusahaan / Instansi</h6>
              <div style="white-space: normal; max-width: 300px;">{{ $riwayat->instansi ?? '-' }}</div>
            </div>

            {{-- Periode --}}
            <div class="mb-3">
              <h6 class="text-muted mb-1"><i class="ti ti-calendar text-info me-1"></i> Periode</h6>
              <p class="mb-0">
                {{ $riwayat->periode_mulai ? \Carbon\Carbon::parse($riwayat->periode_mulai)->format('d M Y') : '-' }}
                -
                {{ $riwayat->periode_selesai ? \Carbon\Carbon::parse($riwayat->periode_selesai)->format('d M Y') : '-' }}
              </p>
            </div>

            {{-- Posisi --}}
            <div class="mb-3">
              <h6 class="text-muted mb-1"><i class="ti ti-user text-warning me-1"></i> Posisi</h6>
              <p class="mb-0">{{ $riwayat->posisi ?? '-' }}</p>
            </div>

            {{-- Status --}}
            <div class="mb-3">
              <h6 class="text-muted mb-1"><i class="ti ti-info-circle text-secondary me-1"></i> Status</h6>
              @if($riwayat->status == 'aktif')
                <span class="badge bg-success"><i class="ti ti-check me-1"></i>Aktif</span>
              @elseif($riwayat->status == 'non-aktif')
                <span class="badge bg-secondary"><i class="ti ti-x me-1"></i>Non-Aktif</span>
              @else
                <span class="badge bg-light text-dark">{{ $riwayat->status }}</span>
              @endif
            </div>

            {{-- Nilai Akhir --}}
            <div class="mb-3">
              <h6 class="text-muted mb-1"><i class="ti ti-star text-warning me-1"></i> Nilai Akhir</h6>
              <p class="mb-0">{{ $riwayat->nilai_akhir ?? '-' }}</p>
            </div>

            {{-- Sertifikat --}}
            <div class="mb-3">
              <h6 class="text-muted mb-1"><i class="ti ti-certificate text-success me-1"></i> Sertifikat</h6>
              @if($riwayat->sertifikat)
                <a href="{{ asset($riwayat->sertifikat->file_path) }}" target="_blank" class="btn btn-sm btn-success">
                  <i class="ti ti-download me-1"></i> Download
                </a>
              @else
                <span class="text-muted">Belum tersedia</span>
              @endif
            </div>

          </div>

          <div class="card-footer text-end">
            <a href="{{ route('magang.riwayat.index') }}" class="btn btn-secondary">
              <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
