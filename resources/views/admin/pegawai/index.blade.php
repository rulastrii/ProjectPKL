@extends('layouts.app')
@section('title','Pegawai Management')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Pegawai</h3>
      <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCreatePegawai">
      <i class="ti ti-plus me-1"></i> Add Pegawai
      </button>
     </div>

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

        {{-- Filter Bidang --}}
        <select name="bidang_id" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
          <option value="">All Bidang</option>
          @foreach($bidangs as $b)
            <option value="{{ $b->id }}" {{ request('bidang_id') == $b->id ? 'selected':'' }}>
              {{ $b->nama }}
            </option>
          @endforeach
        </select>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search pegawai..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>

      </form>
     </div>

     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>#</th>
         <th>NIP</th>
         <th>Nama</th>
         <th>Jabatan</th>
         <th>Bidang</th>
         <th>Active</th>
         <th>Created</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($pegawais as $index=>$pegawai)
        <tr>
         <td>{{ $pegawais->firstItem() + $index }}</td>
         <td>{{ $pegawai->nip }}</td>
         <td>{{ $pegawai->nama }}</td>
         <td>{{ $pegawai->jabatan }}</td>
         <td>{{ $pegawai->bidang->nama ?? '-' }}</td>
         <td>
    {!! $pegawai->is_active 
        ? '<span class="badge bg-success-soft text-success">Active</span>' 
        : '<span class="badge bg-danger-soft text-danger">Inactive</span>' 
    !!}
</td>
<td>{{ $pegawai->created_date? \Carbon\Carbon::parse($pegawai->created_date)->format('d M Y'):'-' }}</td>
         <td class="text-end">

         <!-- Show Button -->
<button type="button" 
        class="btn btn-outline-info btn-sm me-1"
        data-bs-toggle="modal"
        data-bs-target="#modalShowPegawai-{{ $pegawai->id }}"
        title="Detail Pegawai">
    <i class="ti ti-eye"></i>
</button>
    <!-- Edit Button Outline (Trigger Modal) -->
    <button type="button" class="btn btn-outline-warning btn-sm me-1" 
            data-bs-toggle="modal" 
            data-bs-target="#modalEditPegawai-{{ $pegawai->id }}" 
            title="Edit Pegawai">
        <i class="ti ti-pencil"></i>
    </button>

    <!-- Delete Button Outline -->
    <form action="{{ route('admin.pegawai.destroy',$pegawai->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Delete pegawai?')" class="btn btn-outline-danger btn-sm" title="Delete Pegawai">
            <i class="ti ti-trash"></i>
        </button>
    </form>
</td>

        </tr>
        @empty
        <tr><td colspan="8" class="text-center">No pegawai found</td></tr>
        @endforelse
       </tbody>

      </table>
     </div>

     <div class="card-footer d-flex align-items-center">
    {{-- Info entries --}}
    <p class="m-0 text-secondary">
        Showing <strong>{{ $pegawais->firstItem() }}</strong> to <strong>{{ $pegawais->lastItem() }}</strong> of <strong>{{ $pegawais->total() }}</strong> entries
    </p>

    {{-- Pagination manual --}}
    <ul class="pagination m-0 ms-auto">
        {{-- Prev --}}
        <li class="page-item {{ $pegawais->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $pegawais->previousPageUrl() ?? '#' }}">
                prev
            </a>
        </li>

        {{-- Page numbers --}}
        @foreach ($pegawais->getUrlRange(1, $pegawais->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $pegawais->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- Next --}}
        <li class="page-item {{ $pegawais->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $pegawais->nextPageUrl() ?? '#' }}">
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

@include('admin.pegawai.modal-create') {{-- Modal Create --}}
@include('admin.pegawai.modal-edit')   {{-- Modal Edit --}}
@endsection
