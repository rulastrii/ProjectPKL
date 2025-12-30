@extends('layouts.app')
@section('title','Daftar Pengajuan PKL')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Header --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Daftar Pengajuan PKL</h3>
     </div>

     {{-- Filter & Search --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2 align-items-center">
        {{-- Show entries --}}
        <div class="d-flex align-items-center">
          Show
          <select name="per_page" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
            @foreach([5,10,25,50,100] as $size)
              <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected':'' }}>{{ $size }}</option>
            @endforeach
          </select>
          entries
        </div>

        {{-- Filter Status --}}
        <div class="ms-3">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                @foreach(['all'=>'Semua','draft'=>'Draft','diproses'=>'Diproses','diterima'=>'Diterima','selesai'=>'Selesai','ditolak'=>'Ditolak'] as $key => $label)
                    <option value="{{ $key }}" {{ $statusFilter == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pengajuan..." class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>
      </form>
     </div>

     {{-- Table --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No Surat</th>
         <th>Sekolah/Universitas</th>
         <th>Periode</th>
         <th>Jumlah Siswa</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>
       <tbody>
        @forelse($pengajuans as $p)
        <tr>
         <td>{{ $p->no_surat }}</td>
         <td>{{ $p->sekolah?->nama ?? $p->universitas ?? '-' }}</td>
         <td>{{ \Carbon\Carbon::parse($p->periode_mulai)->format('d-m-Y') ?? '-' }} s/d {{ \Carbon\Carbon::parse($p->periode_selesai)->format('d-m-Y') ?? '-' }}</td>
         <td>{{ $p->siswa->count() }}</td>

         <td class="text-end">
    @php
        // cek apakah semua siswa sudah diterima atau ditolak
        $allProcessed = $p->siswa->count() > 0 && $p->siswa->every(fn($s) => in_array($s->status, ['diterima','ditolak']));
    @endphp

    @if(!$allProcessed)
        <a href="{{ route('admin.pengajuan.edit', $p->id) }}" class="btn btn-outline-warning btn-sm me-1" title="Approve / Reject Siswa">
            <i class="ti ti-pencil"></i>
        </a>
    @endif

    <a href="{{ route('admin.pengajuan.show', $p->id) }}" class="btn btn-outline-primary btn-sm" title="Lihat Detail">
        <i class="ti ti-eye"></i>
    </a>
</td>

        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada pengajuan ditemukan</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- Pagination --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $pengajuans->firstItem() ?? 0 }}</strong> to <strong>{{ $pengajuans->lastItem() ?? 0 }}</strong> of <strong>{{ $pengajuans->total() ?? 0 }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $pengajuans->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pengajuans->previousPageUrl() ?? '#' }}">
                    <i class="ti ti-arrow-left"></i> prev
                </a>
            </li>

            @foreach ($pengajuans->getUrlRange(1, $pengajuans->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $pengajuans->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $pengajuans->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pengajuans->nextPageUrl() ?? '#' }}">
                    next <i class="ti ti-arrow-right"></i>
                </a>
            </li>
        </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>

@endsection
