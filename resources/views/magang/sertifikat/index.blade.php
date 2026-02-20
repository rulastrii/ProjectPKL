@extends('layouts.app')

@section('title', 'Sertifikat Saya')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Sertifikat Saya</h1>

    @if($sertifikat->count() > 0)
    <div class="row justify-content-center g-3">
        @foreach($sertifikat as $item)
        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-center">{{ $item->judul ?? 'Sertifikat Magang' }}</h5>
                    <p class="card-text mb-1 text-center"><strong>Nomor:</strong> {{ $item->nomor_sertifikat }}</p>
                    <p class="card-text mb-3 text-center">
                        <strong>Periode:</strong> 
                        {{ \Carbon\Carbon::parse($item->periode_mulai)->format('d M Y') }} - 
                        {{ \Carbon\Carbon::parse($item->periode_selesai)->format('d M Y') }}
                    </p>

                    <div class="mt-auto">
                        @if($item->file_path)
                        <a href="{{ asset($item->file_path) }}" target="_blank" class="btn btn-primary w-100">
                            <i class="ti ti-download"></i> Download PDF
                        </a>
                        @else
                        <span class="text-muted small d-block text-center">Belum ada file</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $sertifikat->links() }}
    </div>
    @else
    <div class="alert alert-warning text-center">
        Belum ada sertifikat tersedia.
    </div>
    @endif
</div>
@endsection
