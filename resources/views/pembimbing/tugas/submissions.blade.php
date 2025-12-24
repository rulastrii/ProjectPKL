@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul & Tombol Kembali --}}
    <div class="d-flex align-items-center mb-3">
        <h3 class="fw-bold me-auto">Daftar Submit Peserta - {{ $tugas->judul }}</h3>
        <a href="{{ route('pembimbing.tugas.index') }}" class="btn btn-outline-primary" title="Kembali ke Tugas">
            <i class="ti ti-arrow-left"></i> Kembali ke Tugas
        </a>
    </div>

    {{-- Card Table --}}
    <div class="card border rounded-0 shadow-sm">

        {{-- Header --}}
        <div class="card-header d-flex align-items-center">
            <h5 class="m-0">Daftar Submission</h5>
        </div>

        {{-- Filter / Search --}}
        <div class="card-body border-bottom py-2">
            <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">

                {{-- Show entries --}}
                <div class="d-flex align-items-center">
                    Show
                    <select name="per_page" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
                        @foreach([5,10,25,50,100] as $size)
                            <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    entries
                </div>

                {{-- Search --}}
                <div class="ms-auto d-flex flex-grow-1 flex-md-grow-0">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search peserta...">
                    <button class="btn btn-sm btn-primary ms-2">Search</button>
                </div>

            </form>
        </div>

        {{-- Table Responsive --}}
        <div class="table-responsive">
            <table class="table card-table table-vcenter table-hover text-nowrap mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>Status Submit</th>
                        <th>Skor</th>
                        <th>Feedback</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submits as $i => $submit)
                        <tr>
                            <td>{{ $submits->firstItem() + $i }}</td>
                            <td>{{ $submit->siswa->nama }}</td>
                            <td>
                                @if($submit->status == 'pending')
                                    <span class="badge text-warning">Pending</span>
                                @else
                                    <span class="badge text-success">Sudah Dinilai</span>
                                @endif
                            </td>
                            <td>
                                @if($submit->status == 'pending')
                                    <span class="text-muted">-</span>
                                @else
                                    {{ $submit->skor }}
                                @endif
                            </td>
                            <td>
                                @if($submit->status == 'pending')
                                    <span class="text-muted">-</span>
                                @else
                                    {{ $submit->feedback }}
                                @endif
                            </td>
                            <td class="text-end">
                                @if($submit->status == 'pending')
                                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#gradeModal-{{ $submit->id }}" title="Nilai Submit">
                                        <i class="ti ti-file-text"></i> Nilai
                                    </button>
                                @else
                                    <span class="text-success">Sudah dinilai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada submission</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($submits instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer d-flex flex-wrap align-items-center">
                <p class="m-0 text-secondary">
                    Showing <strong>{{ $submits->firstItem() }}</strong> to <strong>{{ $submits->lastItem() }}</strong> of <strong>{{ $submits->total() }}</strong> entries
                </p>

                <ul class="pagination m-0 ms-auto">
                    <li class="page-item {{ $submits->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $submits->previousPageUrl() ?? '#' }}">Prev</a>
                    </li>

                    @foreach ($submits->getUrlRange(1, $submits->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $submits->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $submits->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $submits->nextPageUrl() ?? '#' }}">Next</a>
                    </li>
                </ul>
            </div>
        @endif

    </div>
</div>

@include('pembimbing.tugas.grade')  
@endsection
