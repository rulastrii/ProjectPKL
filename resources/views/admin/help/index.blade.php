@extends('layouts.app')
@section('title','Pusat Bantuan')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Card Header --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title"> Permintaan Pusat Bantuan</h3>
     </div>

     {{-- Filter & Search --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">

        {{-- Show entries --}}
        <div class="d-flex align-items-center">
          Show
          <select name="per_page" class="form-select form-select-sm mx-2"
                  onchange="this.form.submit()">
            @foreach([5,10,25,50] as $size)
              <option value="{{ $size }}"
                {{ request('per_page',10) == $size ? 'selected':'' }}>
                {{ $size }}
              </option>
            @endforeach
          </select>
          entries
        </div>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search"
                 value="{{ request('search') }}"
                 placeholder="Cari nama / email..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">
            <i class="ti ti-search"></i>
          </button>
        </div>

      </form>
     </div>

     {{-- Table --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No.</th>
         <th>Nama</th>
         <th>Email</th>
         <th>Status</th>
         <th>Dikirim</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>

       <tbody>
        @forelse ($requests as $index => $item)
        <tr>
         <td>{{ $requests->firstItem() + $index }}</td>
         <td>{{ $item->name }}</td>
         <td>{{ $item->email }}</td>
         <td>
            <span class="badge text-{{
    $item->status == 'pending' ? 'warning' :
    ($item->status == 'approved' ? 'success' : 'danger')
}}">
    {{ strtoupper($item->status) }}
</span>

         </td>
         <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
         <td class="text-end">
            <a href="{{ route('admin.help.show', $item->id) }}"
               class="btn btn-outline-primary btn-sm" title="Lihat detail">
                <i class="ti ti-eye"></i>
            </a>
         </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">
                Belum ada permintaan bantuan
            </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- Pagination --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $requests->firstItem() }}</strong>
            to <strong>{{ $requests->lastItem() }}</strong>
            of <strong>{{ $requests->total() }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $requests->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $requests->previousPageUrl() ?? '#' }}">
                    ‹ prev
                </a>
            </li>

            @foreach ($requests->getUrlRange(1, $requests->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $requests->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $requests->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $requests->nextPageUrl() ?? '#' }}">
                    next ›
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
