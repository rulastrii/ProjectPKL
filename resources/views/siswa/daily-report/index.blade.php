@extends('layouts.app')
@section('title','Laporan Harian Pkl')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- HEADER --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Laporan Harian</h3>
<button type="button"
        class="btn btn-primary ms-auto"
        data-bs-toggle="modal"
        data-bs-target="#modalCreateDailyReport">
    <i class="ti ti-plus me-1"></i> Tambah Laporan
</button>

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
              <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected':'' }}>
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
                 placeholder="Cari ringkasan / tanggal"
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>
      </form>
     </div>

     {{-- TABLE --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>#</th>
         <th>Tanggal</th>
         <th>Ringkasan</th>
         <th>Kendala</th>
         <th>Screenshot</th>
         <th>Status</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($reports as $index => $r)
        <tr>
         <td>{{ ($reports->firstItem() ?? 0) + $index }}</td>

         <td>{{ $r->tanggal_formatted ?? $r->tanggal }}</td>

         <td class="text-wrap" style="max-width:250px">
            {{ \Illuminate\Support\Str::limit($r->ringkasan, 60) }}
         </td>

         <td class="text-wrap" style="max-width:200px">
            {{ \Illuminate\Support\Str::limit($r->kendala, 50) ?? '-' }}
         </td>

         <td>
            @if($r->screenshot)
                <a href="{{ asset('uploads/daily-report/'.$r->screenshot) }}"
   target="_blank"
   class="btn btn-outline-secondary btn-sm">
    Lihat
</a>

            @else
                <span class="text-muted">-</span>
            @endif
         </td>

         <td>
            @php
                $badge = match($r->status_verifikasi) {
                    'terverifikasi' => 'bg-success-soft text-success',
                    'ditolak'       => 'bg-danger-soft text-danger',
                    default         => 'bg-warning-soft text-warning'
                };
            @endphp

            <span class="badge {{ $badge }}">
                {{ $r->status_verifikasi_label ?? 'Belum Diverifikasi' }}
            </span>
         </td>

         <td class="text-end">
            {{-- Detail --}}
            <a href="{{ route('siswa.daily-report.show', $r->id) }}"
               class="btn btn-outline-info btn-sm me-1"
               title="Detail">
                <i class="ti ti-eye"></i>
            </a>

            {{-- Edit (hanya jika belum diverifikasi) --}}
            @if(!$r->status_verifikasi)
                <button type="button"
        class="btn btn-outline-warning btn-sm"
        data-bs-toggle="modal"
        data-bs-target="#modalEditDailyReport-{{ $r->id }}">
  <i class="ti ti-pencil"></i>
</button>
            @endif
         </td>
        </tr>

        @empty
        <tr>
            <td colspan="7" class="text-center text-muted">
                Belum ada laporan harian
            </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- PAGINATION --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $reports->firstItem() ?? 0 }}</strong>
            to <strong>{{ $reports->lastItem() ?? 0 }}</strong>
            of <strong>{{ $reports->total() ?? 0 }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $reports->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $reports->previousPageUrl() ?? '#' }}">
                    prev
                </a>
            </li>

            @foreach ($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $reports->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $reports->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $reports->nextPageUrl() ?? '#' }}">
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

@include('siswa.daily-report.modal-create')
@include('siswa.daily-report.modal-edit')
@endsection
