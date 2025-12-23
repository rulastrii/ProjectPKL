@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">Detail Tugas</h3>

    <div class="card shadow-sm border-primary">
        {{-- Judul Tugas --}}
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

            {{-- Metadata / Informasi Tugas --}}
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
    @if($tugas->deleted_id)
    <div class="col-md-6 mb-2">
        <strong>Dihapus oleh:</strong> {{ optional($tugas->deleter)->name ?? '-' }}<br>
        <small class="text-muted">Tanggal: {{ $tugas->deleted_date ?? '-' }}</small>
    </div>
    @endif
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
