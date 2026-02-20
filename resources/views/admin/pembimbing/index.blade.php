@extends('layouts.app')
@section('title','Pembimbing Management')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- HEADER --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Pembimbing</h3>
      <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCreatePembimbing">
        <i class="ti ti-plus me-1"></i> Add Pembimbing
      </button>
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
         <td>{{ $pembimbing->firstItem() + $index }}</td>

         {{-- JENIS --}}
         <td>
            @if($b->pengajuan_type === \App\Models\PengajuanPklmagang::class)
                <span class="badge bg-info-soft text-info">PKL</span>
            @else
                <span class="badge bg-warning-soft text-warning">Magang</span>
            @endif
         </td>

         {{-- PENGAJUAN --}}
         <td>
            <div class="fw-semibold">{{ $b->pengajuan->no_surat ?? '-' }}</div>

            @if($b->pengajuan_type === \App\Models\PengajuanPklmagang::class)
                <small class="text-muted">
                    {{ $b->pengajuan->sekolah->nama ?? '-' }}
                </small>
            @else
                <small class="text-muted">
                    {{ $b->pengajuan->nama_mahasiswa ?? '-' }} -
                    {{ $b->pengajuan->universitas ?? '-' }}
                </small>
            @endif
         </td>

         {{-- PEMBIMBING --}}
         <td>{{ $b->pegawai->nama ?? '-' }}</td>

         <td>{{ $b->tahun ?? '-' }}</td>

         {{-- STATUS --}}
         <td>
            {!! $b->is_active
                ? '<span class="badge bg-success-soft text-success">Active</span>'
                : '<span class="badge bg-danger-soft text-danger">Inactive</span>'
            !!}
         </td>

         {{-- ACTION --}}
         <td class="text-end">

            <a href="{{ route('admin.pembimbing.show', $b->id) }}"
               class="btn btn-outline-info btn-sm me-1"
               title="Detail">
                <i class="ti ti-eye"></i>
            </a>

            <button type="button"
                    class="btn btn-outline-warning btn-sm me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditPembimbing-{{ $b->id }}">
                <i class="ti ti-pencil"></i>
            </button>

            <form action="{{ route('admin.pembimbing.destroy',$b->id) }}"
                  method="POST"
                  class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Delete pembimbing?')"
                        class="btn btn-outline-danger btn-sm">
                    <i class="ti ti-trash"></i>
                </button>
            </form>

         </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                No pembimbing found
            </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- PAGINATION --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $pembimbing->firstItem() }}</strong>
            to <strong>{{ $pembimbing->lastItem() }}</strong>
            of <strong>{{ $pembimbing->total() }}</strong> entries
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

@include('admin.pembimbing.modal-create')
@include('admin.pembimbing.modal-edit')
@endsection
