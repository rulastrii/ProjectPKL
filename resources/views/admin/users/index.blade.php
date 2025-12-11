@extends('layouts.app')
@section('title','Users Management')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Users</h3>
      <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCreateUser">
      <i class="ti ti-plus me-1"></i> Add User
      </button>
      <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary ms-2">
      <i class="ti ti-shield me-1"></i> View Roles</a>
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

        {{-- Filter Role --}}
        <select name="role" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
          <option value="">All Roles</option>
          @foreach($roles as $r)
            <option value="{{ $r->id }}" {{ request('role') == $r->id ? 'selected':'' }}>
              {{ $r->name }}
            </option>
          @endforeach
        </select>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search user..."
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
         <th>Email</th>
         <th>Role</th>
         <th>Active</th>
         <th>Created</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($users as $index=>$user)
        <tr>
         <td>{{ $users->firstItem() + $index }}</td>
         <td>{{ $user->name }}</td>
         <td>{{ $user->email }}</td>
         <td>{{ $user->role->name ?? '-' }}</td>
        <td>
    {!! $user->is_active 
        ? '<span class="badge bg-success-soft text-success">Active</span>' 
        : '<span class="badge bg-danger-soft text-danger">Inactive</span>' 
    !!}
</td>
<td>{{ $user->created_date? \Carbon\Carbon::parse($user->created_date)->format('d M Y'):'-' }}</td>
         <td class="text-end">
    <!-- Edit Button Outline (Trigger Modal) -->
    <button type="button" class="btn btn-outline-warning btn-sm me-1" 
            data-bs-toggle="modal" 
            data-bs-target="#modalEditUser-{{ $user->id }}" 
            title="Edit User">
        <i class="ti ti-pencil"></i>
    </button>

    <!-- Delete Button Outline -->
    <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Delete user?')" class="btn btn-outline-danger btn-sm" title="Delete User">
            <i class="ti ti-trash"></i>
        </button>
    </form>
</td>

        </tr>
        @empty
        <tr><td colspan="7" class="text-center">No users found</td></tr>
        @endforelse
       </tbody>

      </table>
     </div>

     <div class="card-footer d-flex align-items-center">
    {{-- Info entries --}}
    <p class="m-0 text-secondary">
        Showing <strong>{{ $users->firstItem() }}</strong> to <strong>{{ $users->lastItem() }}</strong> of <strong>{{ $users->total() }}</strong> entries
    </p>

    {{-- Pagination manual --}}
    <ul class="pagination m-0 ms-auto">
        {{-- Prev --}}
        <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $users->previousPageUrl() ?? '#' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15 6l-6 6l6 6"/>
                </svg>
                prev
            </a>
        </li>

        {{-- Page numbers --}}
        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $users->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
        @endforeach

        {{-- Next --}}
        <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $users->nextPageUrl() ?? '#' }}">
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

@include('admin.users.modal-create') {{-- Modal Create --}}
@include('admin.users.modal-edit') {{-- Modal Create --}}
@endsection

