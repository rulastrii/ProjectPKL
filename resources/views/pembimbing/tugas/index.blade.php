@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Judul Dashboard --}}
    <h3 class="fw-bold mb-4">Dashboard Tugas</h3>

    {{-- ROW UTAMA: Form Input & Tabel Sejajar --}}
    <div class="row g-4">

        {{-- Form Input Tugas --}}
        <div class="col-12 col-lg-4">
            <div class="card border-primary shadow-sm h-100">
                <div class="card-header bg-primary text-white py-2 fw-bold">
                    Input Tugas
                </div>
                <div class="card-body p-3">
                    {{-- Include form dengan ID unik supaya Quill tidak conflict --}}
                    @include('pembimbing.tugas.create', [
                        'editorId' => 'editor-sidebar',
                        'toolbarId' => 'toolbar-sidebar'
                    ])
                </div>
            </div>
        </div>

        {{-- Tabel Daftar Tugas --}}
        <div class="col-12 col-lg-8">
            <div class="card border rounded-0 shadow-sm">

                {{-- Header Tabel --}}
                <div class="card-header d-flex align-items-center">
                    <h5 class="m-0">Daftar Tugas</h5>
                </div>

                {{-- Filter/Search & Show entries --}}
                <div class="card-body border-bottom py-2">
                    <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">

                        {{-- Show entries & Filter Tenggat --}}
                        <div class="d-flex align-items-center">
                            Show
                            <select name="per_page" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
                                @foreach([5,10,25,50,100] as $size)
                                    <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected' : '' }}>
                                        {{ $size }}
                                    </option>
                                @endforeach
                            </select>
                            entries

                            <select name="tenggat_filter" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
                                <option value="" {{ request('tenggat_filter') == '' ? 'selected' : '' }}>Semua</option>
                                <option value="today" {{ request('tenggat_filter') == 'today' ? 'selected' : '' }}>Hari ini</option>
                                <option value="3days" {{ request('tenggat_filter') == '3days' ? 'selected' : '' }}>3 Hari ke depan</option>
                                <option value="7days" {{ request('tenggat_filter') == '7days' ? 'selected' : '' }}>7 Hari ke depan</option>
                            </select>
                        </div>

                        {{-- Search --}}
                        <div class="ms-auto d-flex flex-grow-1 flex-md-grow-0">
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Search tugas...">
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
                                <th>Judul</th>
                                <th>Tenggat</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tugas as $i => $t)
                                <tr>
                                    <td>{{ $tugas->firstItem() + $i }}</td>
                                    <td>{{ $t->judul }}</td>
                                    <td>{{ \Carbon\Carbon::parse($t->tenggat)->format('d M Y H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $t->status == 'pending' ? 'badge-outline-warning text-warning' : 'badge-outline-success text-success' }}">
                                            {{ ucfirst($t->status) }}
                                        </span>

                                    </td>
                                    <td class="text-end">
                                        <button type="button"
                                                class="btn btn-outline-primary btn-sm me-1"
                                                onclick="window.location='{{ route('pembimbing.tugas.show', $t->id) }}'"
                                                title="Detail Tugas">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        {{-- Edit Button --}}
                                        <button type="button"
                                                class="btn btn-outline-warning btn-sm me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditTugas-{{ $t->id }}"
                                                title="Edit Tugas">
                                            <i class="ti ti-pencil"></i>
                                        </button>

                                        {{-- Assign Button --}}
                                        <button type="button"
                                                class="btn btn-outline-info btn-sm me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalAssignTugas-{{ $t->id }}"
                                                title="Assign Tugas">
                                            <i class="ti ti-user"></i>
                                        </button>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('pembimbing.tugas.destroy', $t->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Yakin hapus tugas?')"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Hapus Tugas">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada tugas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($tugas instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="card-footer d-flex flex-wrap align-items-center">
                        <p class="m-0 text-secondary">
                            Showing <strong>{{ $tugas->firstItem() }}</strong> to <strong>{{ $tugas->lastItem() }}</strong> of <strong>{{ $tugas->total() }}</strong> entries
                        </p>

                        <ul class="pagination m-0 ms-auto">
                            <li class="page-item {{ $tugas->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $tugas->previousPageUrl() ?? '#' }}">Prev</a>
                            </li>

                            @foreach ($tugas->getUrlRange(1, $tugas->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $tugas->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ $tugas->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $tugas->nextPageUrl() ?? '#' }}">Next</a>
                            </li>
                        </ul>
                    </div>
                @endif

            </div>
        </div>

    </div>
</div>

{{-- Modal --}}
@include('pembimbing.tugas.edit')    {{-- Modal Edit --}}
@include('pembimbing.tugas.assign')  {{-- Modal Assign --}}

@endsection
