@extends('layouts.app')
@section('title','Data Magang Mahasiswa')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- CARD HEADER --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title"> Data Mahasiswa Magang
      </h3>
     </div>

     {{-- FILTER + SEARCH --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">

        {{-- Show entries --}}
        <div class="d-flex align-items-center">
          Show
          <select name="per_page"
                  class="form-select form-select-sm mx-2"
                  onchange="this.form.submit()">
            @foreach([5,10,25,50,100] as $size)
              <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected':'' }}>
                {{ $size }}
              </option>
            @endforeach
          </select>
          entries
        </div>

        {{-- Filter Status --}}
        <div>
          <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">-- Semua Status --</option>
            <option value="draft" {{ request('status')=='draft'?'selected':'' }}>Draft</option>
            <option value="diproses" {{ request('status')=='diproses'?'selected':'' }}>Diproses</option>
            <option value="diterima" {{ request('status')=='diterima'?'selected':'' }}>Diterima</option>
            <option value="ditolak" {{ request('status')=='ditolak'?'selected':'' }}>Ditolak</option>
          </select>
        </div>

        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text"
                 name="search"
                 value="{{ request('search') }}"
                 placeholder="Search nama / NIM..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">
            <i class="ti ti-search"></i>
          </button>
        </div>

      </form>
     </div>

     {{-- TABLE --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No.</th>
         <th>Nama</th>
         <th>NIM</th>
         <th>Universitas</th>
         <th>Jurusan</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>

       <tbody>
        @forelse($siswa as $index => $item)
        <tr>
         <td>{{ $siswa->firstItem() + $index }}</td>
         <td class="fw-semibold">{{ $item->nama }}</td>
         <td>{{ $item->nim }}</td>
         <td>{{ $item->pengajuan->universitas ?? '-' }}</td>
         <td>{{ $item->jurusan }}</td>
         
         <td class="text-end">
            <a href="{{ route('admin.magang-mahasiswa.show', $item->id) }}"
               class="btn btn-outline-primary btn-sm"
               title="Lihat Detail">
              <i class="ti ti-eye"></i>
            </a>
         </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" class="text-center text-muted">
            Data belum tersedia
          </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- FOOTER PAGINATION --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
          Showing
          <strong>{{ $siswa->firstItem() }}</strong>
          to
          <strong>{{ $siswa->lastItem() }}</strong>
          of
          <strong>{{ $siswa->total() }}</strong>
          entries
        </p>

        <ul class="pagination m-0 ms-auto">
          <li class="page-item {{ $siswa->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $siswa->previousPageUrl() ?? '#' }}">
              prev
            </a>
          </li>

          @foreach ($siswa->getUrlRange(1, $siswa->lastPage()) as $page => $url)
            <li class="page-item {{ $page == $siswa->currentPage() ? 'active' : '' }}">
              <a class="page-link" href="{{ $url }}">{{ $page }}</a>
            </li>
          @endforeach

          <li class="page-item {{ $siswa->hasMorePages() ? '' : 'disabled' }}">
            <a class="page-link" href="{{ $siswa->nextPageUrl() ?? '#' }}">
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
