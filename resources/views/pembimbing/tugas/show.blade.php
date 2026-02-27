@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">Detail Tugas</h3>

    {{-- Card Detail Tugas --}}
    <div class="card shadow-sm border-primary mb-4">
        <div class="card-header bg-primary text-white fw-bold d-flex align-items-center justify-content-between">
            <span><i class="ti ti-clipboard-list me-2"></i>{{ $tugas->judul }}</span>
            <span class="badge {{ $tugas->status == 'pending' ? 'bg-warning-soft text-warning' : 'bg-success-soft text-success' }} px-3 py-2">
                {{ ucfirst($tugas->status) }}
            </span>
        </div>

        <div class="card-body">
            {{-- Info Utama --}}
            <div class="row mb-4">
                <div class="col-md-6 mb-2">
                    <i class="ti ti-user me-1"></i>
                    <strong>Pembimbing:</strong> {{ $tugas->pembimbing->user->name ?? '-' }}
                </div>
                <div class="col-md-6 mb-2">
                    <i class="ti ti-calendar me-1"></i>
                    <strong>Tenggat:</strong> {{ \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y H:i') }}
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <h5 class="fw-bold"><i class="ti ti-file-text me-1"></i> Deskripsi</h5>
                <div class="border rounded p-3 bg-light">
                    {!! $tugas->deskripsi !!}
                </div>
            </div>

            {{-- Metadata --}}
            <h5 class="fw-bold mb-2"><i class="ti ti-info-circle me-1"></i> Informasi Tugas</h5>
            <div class="row bg-light p-3 rounded mb-4">
                <div class="col-md-6 mb-2">
                    <strong>Dibuat oleh:</strong> {{ $tugas->creator->name ?? '-' }}<br>
                    <small class="text-muted">Tanggal: {{ $tugas->created_date ?? '-' }}</small>
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Diupdate oleh:</strong> {{ $tugas->updater->name ?? '-' }}<br>
                    <small class="text-muted">Tanggal: {{ $tugas->updated_date ?? '-' }}</small>
                </div>
            </div>

            {{-- Hasil Penilaian --}}
            <h5 class="fw-bold mb-3"><i class="ti ti-clipboard-check me-1"></i> Hasil Submission</h5>

<div class="row bg-light p-3 rounded mb-4">
    @forelse($tugas->submits as $submit)
        @php
            if($submit->skor >= 80) {
                $badgeClass = 'bg-success-soft text-success';
            } elseif($submit->skor >= 50) {
                $badgeClass = 'bg-warning-soft text-warning';
            } else {
                $badgeClass = 'bg-danger-soft text-danger';
            }
        @endphp

        {{-- Nama & Status --}}
        <div class="col-md-6 mb-2">
            <strong>Nama Siswa:</strong> {{ $submit->siswa->nama ?? '-' }}
        </div>
        <div class="col-md-6 mb-2">
            <strong>Status:</strong> {{ ucfirst($submit->status) }}
        </div>

        {{-- Catatan & Skor --}}
        <div class="col-md-6 mb-2">
            <strong>Catatan:</strong> {{ $submit->catatan ?? '-' }}
        </div>
        <div class="col-md-6 mb-2">
            <strong>Skor:</strong>
            @if($submit->status == 'pending')
                <span class="text-muted">Belum dinilai</span>
            @else
                <span class="badge {{ $badgeClass }} px-2 py-1">{{ $submit->skor ?? '-' }}</span>
            @endif
        </div>

        {{-- INFO KETERLAMBATAN & POTONGAN --}}
@if($submit->is_late)
    <div class="alert alert-warning mt-2">
        <strong>⚠ Dikumpulkan Terlambat</strong><br>

        Terlambat
        <b>{{ $submit->late_days }} hari</b>
        dari tenggat.

        @if($submit->late_penalty > 0)
            <br>
            <span class="text-danger">
                Nilai telah dipotong
                <b>{{ $submit->late_penalty }}%</b>
                karena keterlambatan.
            </span>
        @else
            <br>
            <span class="text-muted">
                Tidak ada penalti nilai.
            </span>
        @endif
    </div>
@endif


        {{-- File & Link Lampiran --}}
        <div class="col-md-6 mb-2">
            <strong>File:</strong>
            @if($submit->file)
                <a href="{{ asset($submit->file) }}" target="_blank">Download</a>
            @else
                -
            @endif
        </div>
        <div class="col-md-6 mb-2">
            <strong>Link Lampiran:</strong>
            @if($submit->link_lampiran)
                <a href="{{ $submit->link_lampiran }}" target="_blank">{{ $submit->link_lampiran }}</a>
            @else
                -
            @endif
        </div>

        {{-- Feedback --}}
        <div class="col-12 mb-2">
            <strong>Feedback:</strong>
            @if($submit->status == 'pending')
                <span class="text-muted">Belum ada feedback</span>
            @else
                {{ $submit->feedback ?? '-' }}
            @endif
        </div>

        <div class="col-12"><hr class="my-2"></div>

    @empty
        {{-- Jika belum ada submission --}}
        <div class="col-12 mb-2 text-muted">
            Belum ada peserta yang mengirimkan tugas.
        </div>
    @endforelse
</div>


        </div>

        {{-- Footer --}}
        <div class="card-footer text-end">
            <a href="{{ route('pembimbing.tugas.index') }}" class="btn btn-secondary me-2">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
