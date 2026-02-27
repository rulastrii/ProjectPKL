@extends('layouts.app')
@section('title','Rekap Peserta Bimbingan')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- HEADER --}}
     <div class="card-header">
      <h3 class="card-title">Rekap Peserta Bimbingan</h3>
     </div>

     {{-- FILTER --}}
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
                {{ request('per_page',5) == $size ? 'selected' : '' }}>
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
                 placeholder="Cari nama peserta..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">
            Search
          </button>
        </div>
      </form>
     </div>

     {{-- TABLE --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>#</th>
         <th>Nama Peserta</th>
         <th class="text-center">Hadir</th>
         <th class="text-center">Izin</th>
         <th class="text-center">Sakit</th>
         <th class="text-center">Absen</th>
         <th class="text-center">Laporan</th>
         <th class="text-center">Tugas</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>

       <tbody>
        @forelse ($siswaList as $index => $siswa)
        <tr>
         <td>{{ $siswaList->firstItem() + $index }}</td>

         <td class="fw-semibold">{{ $siswa->nama }}</td>

         <td class="text-center">{{ $siswa->total_hadir }}</td>
         <td class="text-center">{{ $siswa->total_izin }}</td>
         <td class="text-center">{{ $siswa->total_sakit }}</td>
         <td class="text-center">{{ $siswa->total_absen }}</td>

         <td class="text-center">
            <span class="badge bg-blue-lt">
                {{ $siswa->laporan_count }}
            </span>
         </td>

         <td class="text-center">
            <span class="badge bg-green-lt">
                {{ $siswa->tugas_submit_count }}
            </span>
         </td>

         <td class="text-end">
            <a href="{{ route('pembimbing.rekap.show',$siswa->id) }}"
               class="btn btn-outline-primary btn-sm"
               title="Lihat Detail">
               <i class="ti ti-eye"></i>
            </a>
         </td>
        </tr>
        @empty
        <tr>
         <td colspan="9" class="text-center text-muted">
            Data tidak ditemukan
         </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- PAGINATION --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $siswaList->firstItem() }}</strong>
            to <strong>{{ $siswaList->lastItem() }}</strong>
            of <strong>{{ $siswaList->total() }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $siswaList->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $siswaList->previousPageUrl() ?? '#' }}">
                    ‹
                </a>
            </li>

            @foreach ($siswaList->getUrlRange(1, $siswaList->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $siswaList->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $siswaList->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $siswaList->nextPageUrl() ?? '#' }}">
                    ›
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
