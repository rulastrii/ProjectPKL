@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex align-items-center mb-3">
        <h3 class="fw-bold me-auto">
            Penilaian Akhir - {{ $siswa->nama }}
        </h3>
        <a href="{{ route('pembimbing.penilaian-akhir.index') }}"
           class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <form method="POST"
          action="{{ route('pembimbing.penilaian-akhir.store', $siswa->id) }}">
        @csrf

        <div class="card shadow-sm rounded-0">

            <div class="card-body">

                {{-- Nilai otomatis --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Nilai Tugas (50%)</label>
                        <input type="text" class="form-control"
                               value="{{ $penilaian->nilai_tugas ?? '-' }}"
                               readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Nilai Laporan (30%)</label>
                        <input type="text" class="form-control"
                               value="{{ $penilaian->nilai_laporan ?? '-' }}"
                               readonly>
                    </div>
                </div>

                {{-- Input manual --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Nilai Keaktifan (10%)</label>
                        <input type="number" name="nilai_keaktifan"
                               class="form-control"
                               value="{{ old('nilai_keaktifan', $penilaian->nilai_keaktifan) }}"
                               min="0" max="100" required>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold">Nilai Sikap (10%)</label>
                        <input type="number" name="nilai_sikap"
                               class="form-control"
                               value="{{ old('nilai_sikap', $penilaian->nilai_sikap) }}"
                               min="0" max="100" required>
                    </div>
                </div>

                {{-- Periode --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Periode Mulai</label>
                        <input type="date" name="periode_mulai"
                               class="form-control"
                               value="{{ $penilaian->periode_mulai }}">
                    </div>
                    <div class="col-md-6">
                        <label>Periode Selesai</label>
                        <input type="date" name="periode_selesai"
                               class="form-control"
                               value="{{ $penilaian->periode_selesai }}">
                    </div>
                </div>

                {{-- Nilai akhir --}}
                @if($penilaian->nilai_akhir)
                    <div class="alert alert-success">
                        <strong>Nilai Akhir:</strong>
                        {{ $penilaian->nilai_akhir }}
                    </div>
                @endif

            </div>

            <div class="card-footer text-end">
                <button class="btn btn-success">
                    <i class="ti ti-device-floppy"></i>
                    Simpan Nilai Akhir
                </button>
            </div>

        </div>
    </form>
</div>
@endsection
