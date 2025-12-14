@extends('layouts.app')
@section('title','Status Pengajuan PKL/Magang')

@section('content')
@php
    $profile = \App\Models\SiswaProfile::where('user_id', auth()->id())->first();
    $profileLengkap = $profile && $profile->isLengkap();
@endphp

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    @if(!$profileLengkap)
<div class="alert alert-warning d-flex align-items-center mb-3">
    <i class="ti ti-alert-triangle me-2"></i>
    <div>
        <strong>Profile belum lengkap.</strong><br>
        Lengkapi profile terlebih dahulu sebelum mengajukan PKL.
        <a href="{{ route('siswa.profile.index') }}" class="fw-bold ms-1">
            Lengkapi sekarang →
        </a>
    </div>
</div>
@else
<div class="alert alert-success d-flex align-items-center mb-3">
    <i class="ti ti-circle-check me-2"></i>
    <strong>Profile sudah lengkap.</strong>
</div>
@endif

    <div class="card">

     {{-- Card Header --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Pengajuan PKL/Magang</h3>
      @php
    $hasPending = \App\Models\PengajuanPklmagang::where('created_id', auth()->id())
                    ->whereIn('status', ['draft','diproses'])
                    ->exists();
      @endphp

      <a 
    href="{{ (!$profileLengkap || $hasPending) ? '#' : route('siswa.pengajuan.create') }}" 
    class="btn btn-primary ms-auto {{ (!$profileLengkap || $hasPending) ? 'disabled' : '' }}"
    style="{{ (!$profileLengkap || $hasPending) ? 'pointer-events:none; opacity:0.6;' : '' }}"
    title="
        {{ !$profileLengkap 
            ? 'Lengkapi profile terlebih dahulu' 
            : ($hasPending ? 'Anda masih memiliki pengajuan yang belum selesai' : '') 
        }}"
>
    <i class="ti ti-plus me-1"></i> Ajukan PKL
</a>


     </div>

     {{-- Card Body: Filter & Search --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">

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

        {{-- Status filter --}}
        <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          @foreach(['draft','diproses','diterima','ditolak','selesai'] as $status)
            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
              {{ ucfirst($status) }}
            </option>
          @endforeach
        </select>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>

      </form>
     </div>

     {{-- Table --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No.</th>
         <th>No Surat</th>
         <th>Sekolah</th>
         <th>Periode</th>
         <th>Status</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>
       <tbody>
        @forelse($pengajuan as $index => $p)
        <tr>
         <td>{{ $pengajuan->firstItem() + $index }}</td>
         <td>{{ $p->no_surat ?? '-' }}</td>
         <td>{{ $p->sekolah->nama ?? '-' }}</td>
         <td>
            {{ \Carbon\Carbon::parse($p->periode_mulai)->format('d M Y') }} s/d 
            {{ \Carbon\Carbon::parse($p->periode_selesai)->format('d M Y') }}
         </td>
         <td>

            <span class="badge 
              @if($p->status=='draft') bg-secondary
              @elseif($p->status=='diproses') bg-warning
              @elseif($p->status=='diterima') bg-success
              @elseif($p->status=='ditolak') bg-danger
              @elseif($p->status=='selesai') bg-primary
              @endif text-white">
              {{ ucfirst($p->status) }}
            </span>
         </td>
         <td class="text-end">
          <a href="{{ route('siswa.pengajuan.detail', $p->id) }}" 
   class="btn btn-outline-info btn-sm me-1" 
   title="Lihat Detail Pengajuan">
    <i class="ti ti-eye"></i>
</a>

         </td>
        </tr>
        @empty
<tr>
    <td colspan="6" class="text-center">

        @if(request('status') == null)
            Belum ada pengajuan.

        @elseif(request('status') == 'draft')
            Belum ada pengajuan berstatus <strong>Draft</strong>.

        @elseif(request('status') == 'diproses')
            Tidak ada pengajuan yang sedang <strong>Diproses</strong>.

        @elseif(request('status') == 'diterima')
            Tidak ada pengajuan yang <strong>Diterima</strong>.

        @elseif(request('status') == 'ditolak')
            Tidak ada pengajuan yang <strong>Ditolak</strong>.

        @elseif(request('status') == 'selesai')
            Tidak ada pengajuan yang <strong>Selesai</strong>.

        @else
            Data tidak ditemukan.
        @endif

    </td>
</tr>
@endforelse

       </tbody>
      </table>
     </div>

     {{-- Card Footer: Pagination --}}
     <div class="card-footer d-flex align-items-center flex-wrap">
        <p class="m-0 text-secondary me-auto">
            Showing <strong>{{ $pengajuan->firstItem() ?? 0 }}</strong> to 
            <strong>{{ $pengajuan->lastItem() ?? 0 }}</strong> of 
            <strong>{{ $pengajuan->total() ?? 0 }}</strong> entries
        </p>

        <ul class="pagination m-0">
            <li class="page-item {{ $pengajuan->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pengajuan->previousPageUrl() ?? '#' }}">Prev</a>
            </li>

            @foreach ($pengajuan->getUrlRange(1, $pengajuan->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $pengajuan->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $pengajuan->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pengajuan->nextPageUrl() ?? '#' }}">Next</a>
            </li>
        </ul>
     </div>
    </div>
   </div>
  </div>
  
     @php
    $pending = \App\Models\PengajuanPklmagang::where('created_id', auth()->id())
                ->whereIn('status', ['draft', 'diproses'])
                ->first();
@endphp

@if($pending)
<div class="card border-warning my-3">
    <div class="card-header bg-warning text-dark fw-bold">
        <i class="ti ti-alert-triangle me-1"></i> Pemberitahuan
    </div>

    <div class="card-body">
        <p class="mb-1">
            Anda masih memiliki pengajuan PKL yang <strong>belum selesai</strong>.
        </p>

        <ul class="mb-2">
            <li><strong>Status:</strong> {{ ucfirst($pending->status) }}</li>
            <li><strong>Sekolah:</strong> {{ $pending->sekolah->nama }}</li>
            <li><strong>Dibuat:</strong> {{ $pending->created_date->format('d M Y') }}</li>
        </ul>
    </div>
</div>
@endif
 </div>
</div>
@endsection
