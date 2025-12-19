@extends('layouts.app')
@section('title','Daftar Peserta Bimbingan')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- HEADER --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Daftar Peserta Bimbingan</h3>
     </div>

     {{-- FILTER --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">
        <div class="d-flex align-items-center">
          Show
          <select name="per_page" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
            @foreach([5,10,25,50,100] as $size)
              <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected':'' }}>{{ $size }}</option>
            @endforeach
          </select>
          entries

          <select name="tahun" class="form-select form-select-sm w-auto mx-2" onchange="this.form.submit()">
            <option value="">Semua Tahun</option>
            @foreach($tahunList as $t)
              <option value="{{ $t->tahun }}" {{ request('tahun') == $t->tahun ? 'selected' : '' }}>
                {{ $t->tahun }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>
      </form>
     </div>

     {{-- TABLE --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No.</th>
         <th>Jenis</th>
         <th>Pengajuan</th>
         <th>Pembimbing</th>
         <th>Tahun</th>
         <th>Status</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($pembimbing as $index => $b)
        <tr>
         <td>{{ ($pembimbing->firstItem() ?? 0) + $index }}</td>
         <td>
            @if($b->pengajuan_type === \App\Models\PengajuanPklmagang::class)
                <span class="badge bg-info-soft text-info">PKL</span>
            @elseif($b->pengajuan_type === \App\Models\PengajuanMagangMahasiswa::class)
                <span class="badge bg-warning-soft text-warning">Mahasiswa</span>
            @else
                <span class="badge bg-secondary-soft text-secondary">-</span>
            @endif
         </td>
         <td>
            <div class="fw-semibold">{{ $b->pengajuan->no_surat ?? '-' }}</div>
            @if($b->pengajuan)
                @if($b->pengajuan_type === \App\Models\PengajuanPklmagang::class)
                    <small class="text-muted">{{ $b->pengajuan->sekolah->nama ?? '-' }}</small>
                @elseif($b->pengajuan_type === \App\Models\PengajuanMagangMahasiswa::class)
                    <small class="text-muted">{{ $b->pengajuan->nama_mahasiswa ?? '-' }} - {{ $b->pengajuan->universitas ?? '-' }}</small>
                @endif
            @endif
         </td>
         <td>{{ $b->pegawai->nama ?? '-' }}</td>
         <td>{{ $b->tahun ?? '-' }}</td>
         <td>
            {!! $b->is_active
                ? '<span class="badge bg-success-soft text-success">Active</span>'
                : '<span class="badge bg-danger-soft text-danger">Inactive</span>'
            !!}
         </td>
         <td class="text-end">
            <a href="{{ route('pembimbing.bimbingan-peserta.show', $b->id) }}" class="btn btn-outline-info btn-sm" title="Detail">
                <i class="ti ti-eye"></i>
            </a>
         </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center text-muted">No pembimbing found</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- PAGINATION --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $pembimbing->firstItem() ?? 0 }}</strong>
            to <strong>{{ $pembimbing->lastItem() ?? 0 }}</strong>
            of <strong>{{ $pembimbing->total() ?? 0 }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $pembimbing->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pembimbing->previousPageUrl() ?? '#' }}">prev</a>
            </li>

            @foreach ($pembimbing->getUrlRange(1, $pembimbing->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $pembimbing->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $pembimbing->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pembimbing->nextPageUrl() ?? '#' }}">next</a>
            </li>
        </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
@endsection
