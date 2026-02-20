@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">Detail & Submission Tugas</h3>

    <div class="row g-4">

        {{-- Card Detail Tugas --}}
        <div class="col-12 col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    {{ $tugas->judul }}
                </div>
                <div class="card-body">
                    <p><strong>Deskripsi:</strong></p>
                    <p>{!! $tugas->deskripsi !!}</p>

                    <p><strong>Tenggat:</strong> {{ \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y H:i') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge {{ $tugas->submits->first()?->status == 'pending' ? 'badge-outline-warning text-warning' : 'badge-outline-success text-success' }}">
                            {{ ucfirst($tugas->submits->first()?->status ?? 'Belum submit') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Card Submission --}}
        <div class="col-12 col-lg-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Submission Saya
                </div>
                <div class="card-body">
                    @php
                        $submit = $tugas->submits->first();
                    @endphp

                    @if($submit)
                        <p><strong>Catatan:</strong> {{ $submit->catatan ?? '-' }}</p>
                        <p><strong>File:</strong> 
                            @if($submit->file)
                                <a href="{{ asset($submit->file) }}" target="_blank">Download</a>
                            @else
                                -
                            @endif
                        </p>
                        <p><strong>Link Lampiran:</strong> 
                            @if($submit->link_lampiran)
                                <a href="{{ $submit->link_lampiran }}" target="_blank">{{ $submit->link_lampiran }}</a>
                            @else
                                -
                            @endif
                        </p>
                        <p><strong>Submitted at:</strong> {{ $submit->submitted_at }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($submit->status) }}</p>
                        <p><strong>Skor:</strong> {{ $submit->skor ?? '-' }}</p>
                        <p><strong>Feedback:</strong> {{ $submit->feedback ?? '-' }}</p>
                    @else
                        <p class="text-muted">Anda belum submit tugas ini.</p>
                        <a href="{{ route('siswa.tugas.submitForm', $tugas->id) }}" class="btn btn-primary mt-2">Submit Tugas</a>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Button Kembali --}}
    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('siswa.tugas.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Kembali ke Daftar Tugas
            </a>
        </div>
    </div>

</div>
@endsection
