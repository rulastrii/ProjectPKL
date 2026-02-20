@extends('layouts.app')
@section('title','Daftar Penilaian Akhir')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Card Header --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Penilaian Akhir</h3>
     </div>

     {{-- Card Body: Search & Show entries --}}
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
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search siswa..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>
      </form>
     </div>

     {{-- Table --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap table-bordered">
       <thead>
        <tr>
         <th>No.</th>
         <th>Nama Siswa</th>
         <th>Nilai Tugas</th>
         <th>Nilai Laporan</th>
         <th>Nilai Keaktifan</th>
         <th>Nilai Sikap</th>
         <th>Nilai Akhir</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>

       <tbody>
        @forelse($penilaian as $index => $item)
        <tr>
         <td>{{ $index + 1 }}</td>
         <td>{{ $item->siswa->nama ?? '-' }}</td>
         <td>{{ number_format($item->nilai_tugas,2) }}</td>
         <td>{{ number_format($item->nilai_laporan,2) }}</td>
         <td>{{ number_format($item->nilai_keaktifan,2) }}</td>
         <td>{{ number_format($item->nilai_sikap,2) }}</td>
         <td>{{ number_format($item->nilai_akhir,2) }}</td>
         <td class="text-end">
    {{-- Detail --}}
    <a href="{{ route('pembimbing.penilaian-akhir.show', $item->id) }}"
       class="btn btn-info btn-sm me-1" title="Detail">
        <i class="ti ti-eye"></i>
    </a>

    {{-- Edit hanya jika BELUM ada sertifikat --}}
    @if(!$item->siswa->sertifikat)
        <button class="btn btn-warning btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#modal-edit-penilaian-{{ $item->id }}"
                title="Edit Nilai">
            <i class="ti ti-pencil"></i>
        </button>
    @else
        <span class="badge bg-secondary-subtle text-secondary"
              title="Nilai terkunci karena sertifikat sudah diterbitkan">
            <i class="ti ti-lock"></i> Terkunci
        </span>
    @endif
</td>

        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Belum ada penilaian</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- Card Footer: Pagination --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $penilaian->firstItem() ?? 0 }}</strong> to <strong>{{ $penilaian->lastItem() ?? 0 }}</strong> of <strong>{{ $penilaian->total() ?? 0 }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $penilaian->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $penilaian->previousPageUrl() ?? '#' }}">
                    <i class="ti ti-chevron-left"></i> Prev
                </a>
            </li>

            @foreach ($penilaian->getUrlRange(1, $penilaian->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $penilaian->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $penilaian->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $penilaian->nextPageUrl() ?? '#' }}">
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
@include('pembimbing.penilaian-akhir.edit')
@endsection
