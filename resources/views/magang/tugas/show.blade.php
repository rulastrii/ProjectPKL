@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">Detail & Submission Tugas</h3>

    <div class="row g-4">

        {{-- ================== DETAIL TUGAS ================== --}}
        <div class="col-12 col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    {{ $tugas->judul }}
                </div>
                <div class="card-body">
                    <p><strong>Deskripsi:</strong></p>
                    <p>{!! $tugas->deskripsi !!}</p>

                    <p>
                        <strong>Tenggat:</strong>
                        {{ \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y H:i') }}
                    </p>

                    @php
                        $submit = $tugas->submits->first();
                    @endphp

                    <p>
                        <strong>Status Tugas:</strong>
                        @if(!$submit)
                            <span class="badge text-secondary">Belum submit</span>
                        @elseif($submit->status === 'pending')
                            <span class="badge text-warning">Sudah submit</span>
                        @else
                            <span class="badge text-success">Sudah dinilai</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- ================== SUBMISSION ================== --}}
        <div class="col-12 col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Submission Saya
                </div>
                <div class="card-body">


    @if($submit)
    <div class="mb-3">
        <strong>Keterlambatan:</strong><br>

      @if($submit->is_late)
    <div class="alert alert-warning">
        <strong>⚠ Pengumpulan Terlambat</strong><br>

        Kamu mengumpulkan tugas
        <b>{{ $submit->late_days }} hari</b>
        setelah tenggat waktu.

        @if($submit->late_penalty > 0)
            <br>
            <span class="text-danger">
                Skor akhir sudah dipotong
                <b>{{ $submit->late_penalty }}%</b>
                sesuai aturan keterlambatan.
            </span>
        @else
            <br>
            <span class="text-muted">
                Tidak ada penalti nilai.
            </span>
        @endif
    </div>
@else
    <span class="badge text-success">Tepat waktu</span>
@endif




                        <p><strong>Catatan:</strong><br> {{ $submit->catatan ?? '-' }}</p>

                        <p>
                            <strong>File:</strong>
                            @if($submit->file)
                                <a href="{{ asset($submit->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-download"></i> Download
                                </a>
                            @else
                                -
                            @endif
                        </p>

                        <p>
                            <strong>Link Lampiran:</strong><br>
                            @if($submit->link_lampiran)
                                <a href="{{ $submit->link_lampiran }}" target="_blank">
                                    {{ $submit->link_lampiran }}
                                </a>
                            @else
                                -
                            @endif
                        </p>

                        <p>
                            <strong>Waktu Submit:</strong><br>
                            {{ \Carbon\Carbon::parse($submit->submitted_at)->format('d M Y H:i') }}
                        </p>

                        <hr>

                        <p>
                            <strong>Status Penilaian:</strong><br>
                            @if($submit->status === 'pending')
                                <span class="badge text-warning">Belum dinilai</span>
                            @else
                                <span class="badge text-success">Sudah dinilai</span>
                            @endif
                        </p>

                        <p>
                            <strong>Skor Akhir:</strong><br>
                            {{ $submit->skor ?? '-' }}
                        </p>

                        <p>
                            <strong>Feedback Pembimbing:</strong><br>
                            {{ $submit->feedback ?? '-' }}
                        </p>

                    @else
                        <p class="text-muted">Anda belum submit tugas ini.</p>
                        <a href="{{ route('magang.tugas.submitForm', $tugas->id) }}"
                           class="btn btn-primary mt-2">
                            <i class="ti ti-send me-1"></i> Submit Tugas
                        </a>
                    @endif

                </div>
            </div>
        </div>

    </div>

    {{-- BUTTON KEMBALI --}}
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('magang.tugas.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Kembali ke Daftar Tugas
            </a>
        </div>
    </div>

</div>
@endsection
