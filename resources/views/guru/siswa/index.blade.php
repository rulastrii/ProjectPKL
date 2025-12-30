@extends('layouts.app')

@section('title','Siswa PKL')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Header --}}
     <div class="card-header">
      <h3 class="card-title">Daftar Siswa PKL Saya</h3>
     </div>

     {{-- Filter --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">

        {{-- Show entries --}}
        <div class="d-flex align-items-center">
            Show
            <select name="per_page"
                    class="form-select form-select-sm mx-2"
                    onchange="this.form.submit()">
                @foreach([5,10,25,50] as $size)
                    <option value="{{ $size }}"
                        {{ request('per_page',10) == $size ? 'selected' : '' }}>
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
                   placeholder="Cari nama / email..."
                   class="form-control form-control-sm">
            <button class="btn btn-sm btn-primary ms-2">
                Search
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
         <th>Sekolah</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>
       <tbody>

        @forelse ($siswa as $index => $item)
        <tr>
         <td>{{ $siswa->firstItem() + $index }}</td>
         <td>{{ $item->nama_siswa }}</td>
         <td>{{ $item->email_siswa ?? '-' }}</td>
         <td>{{ $item->pengajuan->sekolah->nama ?? '-' }}</td>
         <td class="text-end">
            <a href="{{ route('guru.siswa.show', $item->id) }}"
               class="btn btn-outline-primary btn-sm" title="Lihat Detail Siswa">
                <i class="ti ti-eye"></i>
            </a>
         </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">
                Belum ada siswa PKL
            </td>
        </tr>
        @endforelse

       </tbody>
      </table>
     </div>

     {{-- Footer Pagination --}}
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
