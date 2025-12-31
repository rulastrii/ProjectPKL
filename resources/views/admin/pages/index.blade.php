@extends('layouts.app')
@section('title','Pages Management')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <!-- Card Header -->
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Pages</h3>
      <a href="{{ route('admin.pages.create') }}" class="btn btn-primary ms-auto">
        <i class="ti ti-plus me-1"></i> Add Page
      </a>
     </div>

     <!-- Search & Show Entries -->
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
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search page..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>
      </form>
     </div>

     <!-- Table Pages -->
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>#</th>
         <th>Slug</th>
         <th>Title</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($pages as $index => $page)
        <tr>
         <td>{{ $index + 1 }}</td>
         <td>{{ $page->slug }}</td>
         <td>{{ $page->title }}</td>
         <td class="text-end">
            <!-- Edit Button Outline -->
            <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-outline-warning btn-sm me-1" title="Edit Page">
                <i class="ti ti-pencil"></i>
            </a>

            <!-- Delete Button Outline -->
            <form action="{{ route('admin.pages.destroy',$page->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Delete page?')" class="btn btn-outline-danger btn-sm" title="Delete Page">
                    <i class="ti ti-trash"></i>
                </button>
            </form>
         </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No pages found</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     <!-- Card Footer: Pagination -->
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $pages->firstItem() }}</strong> to <strong>{{ $pages->lastItem() }}</strong> of <strong>{{ $pages->total() }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $pages->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $pages->previousPageUrl() ?? '#' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M15 6l-6 6l6 6"/>
                    </svg>
                    prev
                </a>
            </li>

            @foreach ($pages->getUrlRange(1, $pages->lastPage()) as $pageNum => $url)
                <li class="page-item {{ $pageNum == $pages->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $pageNum }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $pages->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $pages->nextPageUrl() ?? '#' }}">
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

@endsection
