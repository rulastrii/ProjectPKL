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
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($pegawais as $index=>$pegawai)
        <tr>
         <td>{{ $pegawais->firstItem() + $index }}</td>
         <td>{{ $pegawai->nip }}</td>
         <td>
  <div class="d-flex align-items-center gap-1">

    <span>{{ $pegawai->nama }}</span>

    @if($pegawai->user_id)
      <span
        title="Akun sudah dibuat"
        style="
          width:11px;
          height:11px;
          border:1px solid #2fb344;
          border-radius:50%;
          position:relative;
          display:inline-block;
        ">

        <svg xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 24 24"
             style="
               position:absolute;
               top:50%;
               left:50%;
               width:6px;
               height:6px;
               transform:translate(-50%, -50%);
               stroke:#2fb344;
               stroke-width:3;
               fill:none;
               stroke-linecap:round;
               stroke-linejoin:round;
             ">
          <path d="M5 12l5 5l10 -10"/>
        </svg>

      </span>
    @endif

  </div>
</td>


         <td>{{ $pegawai->jabatan }}</td>
         <td>{{ $pegawai->bidang->nama ?? '-' }}</td>
         <td>
    {!! $pegawai->is_active 
        ? '<span class="badge bg-success-soft text-success">Active</span>' 
        : '<span class="badge bg-danger-soft text-danger">Inactive</span>' 
    !!}
</td>
         <td class="text-end">

 <!-- View Button -->
                                <a href="{{ route('admin.pegawai.show', $pegawai->id) }}" 
                                   class="btn btn-outline-info btn-sm me-1" 
                                   title="Lihat Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
{{-- BUAT AKUN --}}
@if(!$pegawai->user_id)
  <button type="button"
          class="btn btn-outline-success btn-sm me-1"
          data-bs-toggle="modal"
          data-bs-target="#modalCreateUser-{{ $pegawai->id }}"
          title="Buat Akun">
      <i class="ti ti-user-plus"></i>
  </button>
@endif


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
 @foreach($pegawais as $pegawai)
  ...
  @include('admin.pegawai.modal-create-users', ['pegawai' => $pegawai])
@endforeach
@endsection
