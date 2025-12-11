@extends('layouts.app')
@section('title','Roles Management')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Roles</h3>
      <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCreateRole">
      <i class="ti ti-plus me-1"></i>  Add Role
      </button>
      <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">
      <i class="ti ti-user me-1"></i> View Users</a>
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

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search role..."
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
         <th>Name</th>
         <th>Description</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($roles as $index => $role)
        <tr>
         <td>{{ $index + 1 }}</td>
         <td>{{ $role->name }}</td>
         <td>{{ $role->description ?? '-' }}</td>
         <td class="text-end">
            <!-- Edit Button Outline (Trigger Modal) -->
            <button type="button" class="btn btn-outline-warning btn-sm me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditRole-{{ $role->id }}"
                    title="Edit Role">
                <i class="ti ti-pencil"></i>
            </button>

            <!-- Delete Button Outline -->
            <form action="{{ route('admin.roles.destroy',$role->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete role?')" class="btn btn-outline-danger btn-sm" title="Delete Role">
                    <i class="ti ti-trash"></i>
                </button>
            </form>
         </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No roles found</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- Card Footer: Pagination --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $roles->firstItem() }}</strong> to <strong>{{ $roles->lastItem() }}</strong> of <strong>{{ $roles->total() }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $roles->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $roles->previousPageUrl() ?? '#' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 6l-6 6l6 6"/>
                    </svg>
                    prev
                </a>
            </li>

            @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $roles->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $roles->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $roles->nextPageUrl() ?? '#' }}">
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

@include('admin.roles.modal-create') {{-- Modal Create --}}
@include('admin.roles.modal-edit')   {{-- Modal Edit per role --}}
@endsection
