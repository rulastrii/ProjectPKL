@extends('layouts.app')
@section('title','Status Pengajuan PKL/Magang')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Card Header --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Status Pengajuan PKL/Magang</h3>
      <a href="{{ route('siswa.pengajuan.create') }}" class="btn btn-primary ms-auto">
        <i class="ti ti-plus me-1"></i> Ajukan PKL
      </a>
     </div>

     {{-- Card Body: Search & Show Entries --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">
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
         <th>#</th>
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
         <td>{{ $index + $pengajuan->firstItem() }}</td>
         <td>{{ $p->no_surat ?? '-' }}</td>
         <td>{{ $p->sekolah->nama ?? '-' }}</td>
         <td>{{ $p->periode_mulai }} s/d {{ $p->periode_selesai }}</td>
         <td>{{ ucfirst($p->status) }}</td>
         <td class="text-end">
            @if($p->status == 'draft')
                <a href="{{ route('siswa.pengajuan.edit',$p->id) }}" class="btn btn-outline-warning btn-sm me-1" title="Edit Pengajuan">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            @endif
            @if($p->file_surat_path)
    <a href="{{ asset($p->file_surat_path) }}" target="_blank" class="btn btn-info btn-sm">🧾 Lihat Berkas</a>
@endif

         </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada pengajuan</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- Card Footer: Pagination --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $pengajuan->firstItem() ?? 0 }}</strong> to 
            <strong>{{ $pengajuan->lastItem() ?? 0 }}</strong> of 
            <strong>{{ $pengajuan->total() ?? 0 }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $pengajuan->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pengajuan->previousPageUrl() ?? '#' }}">
                    prev
                </a>
            </li>

            @foreach ($pengajuan->getUrlRange(1, $pengajuan->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $pengajuan->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $pengajuan->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pengajuan->nextPageUrl() ?? '#' }}">
                    next
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
