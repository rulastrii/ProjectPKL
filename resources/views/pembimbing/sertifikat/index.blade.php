@extends('layouts.app')
@section('title','Data Sertifikat')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Card Header --}}
     <div class="card-header d-flex align-items-center justify-content-between">
      <h3 class="card-title">Data Sertifikat</h3>
<button type="button"
        class="btn btn-primary btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#modal-terbitkan-sertifikat">
 <i class="ti ti-certificate me-1"></i> Terbitkan Sertifikat
</button>

     </div>

     {{-- Card Body: Show entries & Search --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">

        {{-- Show entries --}}
        <div class="d-flex align-items-center">
          Show
          <select name="per_page"
                  class="form-select form-select-sm mx-2"
                  onchange="this.form.submit()">
            @foreach([5,10,25,50,100] as $size)
              <option value="{{ $size }}"
                {{ request('per_page') == $size ? 'selected':'' }}>
                {{ $size }}
              </option>
            @endforeach
          </select>
          entries
        </div>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text"
                 name="search"
                 value="{{ request('search') }}"
                 placeholder="Search peserta..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">
            Search
          </button>
        </div>
      </form>
     </div>

     {{-- Table --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap table-bordered">
       <thead>
        <tr>
         <th>No.</th>
         <th>Nama Peserta</th>
         <th>Nomor Sertifikat</th>
         <th>Periode</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>

       <tbody>
        @forelse($sertifikat as $index => $item)
        <tr>
         <td>{{ $sertifikat->firstItem() + $index }}</td>
         <td>{{ $item->siswa->nama ?? '-' }}</td>
         <td>{{ $item->nomor_sertifikat }}</td>
         <td>
            {{ \Carbon\Carbon::parse($item->periode_mulai)->format('d/m/Y') }}
            -
            {{ \Carbon\Carbon::parse($item->periode_selesai)->format('d/m/Y') }}
         </td>
         <td class="text-end">
            <a href="{{ route('pembimbing.sertifikat.show', $item->id) }}"
               class="btn btn-info btn-sm me-1"
               title="Detail">
                <i class="ti ti-eye"></i>
            </a>

            @if($item->file_path)
            <a href="{{ asset($item->file_path) }}"
               target="_blank"
               class="btn btn-success btn-sm"
               title="Download PDF">
                <i class="ti ti-download"></i>
            </a>
            @endif
         </td>
        </tr>
        @empty
        <tr>
         <td colspan="5" class="text-center">
            Belum ada sertifikat
         </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- Card Footer: Pagination --}}
     <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-secondary">
        Showing
        <strong>{{ $sertifikat->firstItem() ?? 0 }}</strong>
        to
        <strong>{{ $sertifikat->lastItem() ?? 0 }}</strong>
        of
        <strong>{{ $sertifikat->total() ?? 0 }}</strong>
        entries
      </p>

      <ul class="pagination m-0 ms-auto">
        <li class="page-item {{ $sertifikat->onFirstPage() ? 'disabled' : '' }}">
          <a class="page-link"
             href="{{ $sertifikat->previousPageUrl() ?? '#' }}">
            <i class="ti ti-chevron-left"></i> Prev
          </a>
        </li>

        @foreach ($sertifikat->getUrlRange(1, $sertifikat->lastPage()) as $page => $url)
          <li class="page-item {{ $page == $sertifikat->currentPage() ? 'active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
          </li>
        @endforeach

        <li class="page-item {{ $sertifikat->hasMorePages() ? '' : 'disabled' }}">
          <a class="page-link"
             href="{{ $sertifikat->nextPageUrl() ?? '#' }}">
            Next <i class="ti ti-chevron-right"></i>
          </a>
        </li>
      </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>

@include('pembimbing.sertifikat.create')
@endsection
