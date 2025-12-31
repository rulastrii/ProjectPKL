@extends('layouts.app')

@section('title', 'Rekap Presensi')

@section('content')
<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Rekap Presensi
                </h2>
                <div class="text-muted mt-1">
                    Ringkasan kehadiran siswa PKL & Magang
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="ti ti-filter me-2"></i> Filter Data
            </h3>
        </div>
        <div class="card-body border-bottom py-3">
            <form method="GET" class="d-flex w-100 gap-2">

                {{-- Show entries --}}
                <div class="d-flex align-items-center">
                    Show
                    <select name="per_page"
                            class="form-select form-select-sm mx-2"
                            onchange="this.form.submit()">
                        @foreach([5,10,25,50] as $size)
                            <option value="{{ $size }}" {{ request('per_page')==$size?'selected':'' }}>
                                {{ $size }}
                            </option>
                        @endforeach
                    </select>
                    entries
                </div>

                {{-- keep filter --}}
                <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                <input type="hidden" name="nama" value="{{ request('nama') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
                
                <input type="hidden" name="jenis" value="{{ request('jenis') }}">
            </form>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.presensi.index') }}">
                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control"
                               value="{{ $tanggalAwal }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control"
                               value="{{ $tanggalAkhir }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama" class="form-control"
                               placeholder="Cari nama..."
                               value="{{ request('nama') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="hadir" {{ request('status')=='hadir'?'selected':'' }}>Hadir</option>
                            <option value="izin" {{ request('status')=='izin'?'selected':'' }}>Izin</option>
                            <option value="sakit" {{ request('status')=='sakit'?'selected':'' }}>Sakit</option>
                            <option value="absen" {{ request('status')=='absen'?'selected':'' }}>Absen</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Jenis</label>
                        <select name="jenis" class="form-select">
                            <option value="">Semua</option>
                            <option value="PKL" {{ request('jenis')=='PKL'?'selected':'' }}>PKL</option>
                            <option value="Magang" {{ request('jenis')=='Magang'?'selected':'' }}>Magang</option>
                        </select>
                    </div>


                    <div class="col-md-2 d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="ti ti-search me-1"></i> Filter
                        </button>

                        <a href="{{ route('admin.presensi.index') }}"
                        class="btn btn-outline-secondary">
                            <i class="ti ti-refresh me-1"></i> Refresh
                        </a>
                    </div>


                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="card-header">
    <div class="d-flex align-items-center justify-content-between w-100">
        <h3 class="card-title mb-0">
            <i class="ti ti-table me-2"></i> Rekap Presensi
        </h3>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.presensi.pdf', request()->query()) }}"
               class="btn btn-sm btn-danger">
                <i class="ti ti-file me-1"></i>
                PDF
            </a>

            <a href="{{ route('admin.presensi.excel', request()->query()) }}"
               class="btn btn-sm btn-success">
                <i class="ti ti-file-spreadsheet me-1"></i>
                Excel
            </a>
        </div>
    </div>
</div>
        <div class="table-responsive">
            
            <table class="table table-vcenter table-hover">
                <thead class="bg-muted">
                    <tr class="text-center">
                        <th>No</th>
                        <th class="text-start">Nama</th>
                        <th>Jenis</th>
                        <th>Bidang</th>
                        <th>Pembimbing</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Absen</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($rekap as $item)
                    <tr class="text-center">
                        <td>
                            {{ ($rekap->currentPage() - 1) * $rekap->perPage() + $loop->iteration }}
                        </td>


                        <td class="text-start fw-semibold">
                            {{ $item['nama'] }}
                        </td>

                        <td>
                            @if ($item['jenis'] === 'Magang')
                                <span class="text-success fw-semibold">
                                    {{ $item['jenis'] }}
                                </span>
                            @else
                                <span class="text-primary fw-semibold">
                                    {{ $item['jenis'] }}
                                </span>
                            @endif
                        </td>

                        <td>{{ $item['bidang'] ?? '-' }}</td>
                        <td>{{ $item['pembimbing'] ?? '-' }}</td>

                        <td>
                            <span class="text-success fw-bold">
                                {{ $item['hadir'] }}
                            </span>
                        </td>

                        <td>
                            <span class="text-warning fw-bold">
                                {{ $item['izin'] }}
                            </span>
                        </td>

                        <td>
                            <span class="text-info fw-bold">
                                {{ $item['sakit'] }}
                            </span>
                        </td>

                        <td>
                            <span class="text-danger fw-bold">
                                {{ $item['absen'] }}
                            </span>
                        </td>

                        <td class="fw-bold">
                            {{ $item['total_hari'] }}
                        </td>

                        <td>
                            <a href="{{ route('admin.presensi.detail', $item['siswa_id']) }}"
                               class="btn btn-sm btn-outline-primary" title="Lihat Detail Presensi">
                                <i class="ti ti-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-4">
                            <i class="ti ti-alert-circle me-1"></i>
                            Data presensi tidak ditemukan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="card-footer d-flex align-items-center">
    <p class="m-0 text-secondary">
        Showing
        <strong>{{ $rekap->firstItem() }}</strong>
        to
        <strong>{{ $rekap->lastItem() }}</strong>
        of
        <strong>{{ $rekap->total() }}</strong>
        entries
    </p>

    <ul class="pagination m-0 ms-auto">
        <li class="page-item {{ $rekap->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $rekap->previousPageUrl() }}">
                <i class="ti ti-chevron-left"></i>
                prev
            </a>
        </li>

        @foreach ($rekap->getUrlRange(1, $rekap->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $rekap->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        <li class="page-item {{ $rekap->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $rekap->nextPageUrl() }}">
                next
                <i class="ti ti-chevron-right"></i>
            </a>
        </li>
    </ul>
</div>

        </div>
    </div>

</div>
@endsection
