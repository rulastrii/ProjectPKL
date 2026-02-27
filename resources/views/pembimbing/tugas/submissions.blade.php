@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul & Tombol Kembali --}}
    <div class="d-flex align-items-center mb-3">
        <h3 class="fw-bold me-auto">
            Daftar Submit Peserta - {{ $tugas->judul }}
        </h3>
        <a href="{{ route('pembimbing.tugas.index') }}"
           class="btn btn-outline-primary">
            <i class="ti ti-arrow-left"></i> Kembali ke Tugas
        </a>
    </div>

    {{-- Card --}}
    <div class="card border rounded-0 shadow-sm">

        {{-- Header --}}
        <div class="card-header">
            <h5 class="m-0">Daftar Submission</h5>
        </div>

        {{-- Filter / Search --}}
        <div class="card-body border-bottom py-2">
            <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">

                <div class="d-flex align-items-center">
                    Show
                    <select name="per_page"
                            class="form-select form-select-sm mx-2"
                            onchange="this.form.submit()">
                        @foreach([5,10,25,50,100] as $size)
                            <option value="{{ $size }}"
                                {{ request('per_page') == $size ? 'selected' : '' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                    entries
                </div>

                <div class="ms-auto d-flex">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           class="form-control form-control-sm"
                           placeholder="Search peserta...">
                    <button class="btn btn-sm btn-primary ms-2">Search</button>
                </div>

            </form>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>Status Submit</th>
                        <th>Keterlambatan</th>
                        <th>Skor</th>
                        <th>Feedback</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submits as $i => $submit)
                        <tr class="{{ $submit->is_late ? 'table-danger' : '' }}">
                            <td>{{ $submits->firstItem() + $i }}</td>
                            <td>{{ $submit->siswa->nama }}</td>

                            <td>
                                @if($submit->status === 'pending')
                                    <span class="badge text-warning">Pending</span>
                                @else
                                    <span class="badge text-success">Sudah Dinilai</span>
                                @endif
                            </td>
@php
    $isLate = $submit->submitted_at
        && $submit->tugas->tenggat
        && $submit->submitted_at->gt($submit->tugas->tenggat);

    $lateDays = $isLate
        ? max(1, $submit->tugas->tenggat->diffInDays($submit->submitted_at))
        : 0;
@endphp


<td>
@if($isLate)
    <span class="badge text-warning">
        ⚠ Terlambat {{ $lateDays }} hari
    </span>

    <div class="small text-muted">
        @if($submit->late_penalty > 0)
            Penalti nilai {{ $submit->late_penalty }}%
        @else
            Menunggu penilaian
        @endif
    </div>
@else
    <span class="badge text-success">Tepat Waktu</span>
@endif
</td>



                            <td>
                                {{ $submit->status === 'pending' ? '-' : $submit->skor }}
                            </td>

                            <td>
                                {{ $submit->status === 'pending' ? '-' : $submit->feedback }}
                            </td>

                            <td class="text-end">
                                @if($submit->status === 'pending')
                                    <button class="btn btn-outline-success btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#gradeModal-{{ $submit->id }}">
                                        <i class="ti ti-file-text"></i> Nilai
                                    </button>
                                @else
                                    <span class="text-success">Sudah Dinilai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Belum ada submission
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($submits instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-secondary">
                    Showing
                    <strong>{{ $submits->firstItem() }}</strong> –
                    <strong>{{ $submits->lastItem() }}</strong>
                    of <strong>{{ $submits->total() }}</strong>
                </p>

                <div class="ms-auto">
                    {{ $submits->withQueryString()->links() }}
                </div>
            </div>
        @endif

    </div>
</div>

@include('pembimbing.tugas.grade')
@endsection
