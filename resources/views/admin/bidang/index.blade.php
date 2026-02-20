@extends('layouts.app')
@section('title','Bidang Management')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Bidang</h3>
      <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCreateBidang">
        <i class="ti ti-plus me-1"></i> Add Bidang
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

        {{-- Filter Status --}}
        <select name="is_active" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
          <option value="">All Status</option>
          <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
          <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search bidang..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>

      </form>
     </div>

     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No.</th>
         <th>Nama Bidang</th>
         <th>Kode</th>
         <th>Status</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($bidangs as $index=>$bidang)
        <tr>
         <td>{{ $bidangs->firstItem() + $index }}</td>
         <td>{{ $bidang->nama }}</td>
         <td>{{ $bidang->kode ?? '-' }}</td>
         <td>
            {!! $bidang->is_active 
              ? '<span class="badge bg-success-soft text-success">Active</span>' 
              : '<span class="badge bg-danger-soft text-danger">Inactive</span>' 
            !!}
         </td>
         <td class="text-end">
<!-- View Button -->
                                <a href="{{ route('admin.bidang.show', $bidang->id) }}" 
                                   class="btn btn-outline-info btn-sm me-1" 
                                   title="Lihat Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
           <!-- Edit Button -->
           <button type="button" class="btn btn-outline-warning btn-sm me-1"
                   data-bs-toggle="modal"
                   data-bs-target="#modalEditBidang-{{ $bidang->id }}"
                   title="Edit Bidang">
             <i class="ti ti-pencil"></i>
           </button>

           <!-- Delete Button -->
           <form action="{{ route('admin.bidang.destroy',$bidang->id) }}" method="POST" class="d-inline">
               @csrf
               @method('DELETE')
               <button type="submit" onclick="return confirm('Delete bidang?')" class="btn btn-outline-danger btn-sm" title="Delete Bidang">
                   <i class="ti ti-trash"></i>
               </button>
           </form>
         </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center">No bidang found</td></tr>
        @endforelse
       </tbody>

      </table>
     </div>

     <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-secondary">
          Showing <strong>{{ $bidangs->firstItem() }}</strong> to <strong>{{ $bidangs->lastItem() }}</strong> of <strong>{{ $bidangs->total() }}</strong> entries
      </p>

      <ul class="pagination m-0 ms-auto">
          <li class="page-item {{ $bidangs->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $bidangs->previousPageUrl() ?? '#' }}">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                       viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <path d="M15 6l-6 6l6 6"/>
                  </svg>
                  prev
              </a>
          </li>

          @foreach ($bidangs->getUrlRange(1, $bidangs->lastPage()) as $page => $url)
              <li class="page-item {{ $page == $bidangs->currentPage() ? 'active' : '' }}">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
          @endforeach

          <li class="page-item {{ $bidangs->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $bidangs->nextPageUrl() ?? '#' }}">
                  next
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                       viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                       stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                      <path d="M9 6l6 6l-6 6"/>
                  </svg>
              </a>
          </li>
      </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>

@include('admin.bidang.modal-create') {{-- Modal Create --}}
@include('admin.bidang.modal-edit') {{-- Modal Edit --}}
@endsection
