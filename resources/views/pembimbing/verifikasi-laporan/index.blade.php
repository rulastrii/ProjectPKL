@extends('layouts.app')
@section('title','Verifikasi Laporan Harian')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- HEADER --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Verifikasi Laporan Harian Peserta</h3>
     </div>

     {{-- FILTER --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">

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

        <div class="ms-2">
          <input type="date"
                 name="tanggal"
                 value="{{ request('tanggal') }}"
                 class="form-control form-control-sm"
                 onchange="this.form.submit()">
        </div>

        <div class="ms-auto d-flex">
          <input type="text"
                 name="search"
                 value="{{ request('search') }}"
                 placeholder="Search nama / NISN / NIM"
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
         <th>No.</th>
         <th>Nama</th>
         <th>NISN / NIM</th>
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
         <td class="fw-semibold">{{ $r->siswa->nama ?? '-' }}</td>
         <td>{{ $r->siswa->nisn ?? $r->siswa->nim ?? '-' }}</td>
         <td>{{ $r->tanggal_formatted ?? $r->tanggal }}</td>

         <td class="text-wrap" style="max-width:200px">
            {{ \Illuminate\Support\Str::limit($r->ringkasan, 60) }}
         </td>

         <td class="text-wrap" style="max-width:200px">
            {{ \Illuminate\Support\Str::limit($r->kendala, 60) ?? '-' }}
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
            @can('verify', $r)
                <button class="btn btn-outline-primary btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#verifikasiModal{{ $r->id }}">
                    <i class="ti ti-check"></i>
                </button>
            @else
                <span class="text-muted">Locked</span>
            @endcan
         </td>
        </tr>

        {{-- MODAL VERIFIKASI --}}
        @can('verify', $r)
        <div class="modal fade" id="verifikasiModal{{ $r->id }}" tabindex="-1">
         <div class="modal-dialog modal-lg">
          <form method="POST"
                action="{{ route('pembimbing.verifikasi-laporan.update', $r->id) }}">
           @csrf
           @method('PUT')

           <div class="modal-content">
            <div class="modal-header">
             <h5 class="modal-title">Verifikasi Laporan Harian</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
             <p class="mb-2">
                <strong>
  {{ $r->siswa?->nama ?? '-' }}
  ({{ $r->siswa?->nisn ?? $r->siswa?->nim ?? '-' }})
</strong><br>
                Tanggal: {{ $r->tanggal }}
             </p>

             <div class="mb-3">
                <label class="form-label">Ringkasan</label>
                <div class="form-control bg-light">
                    {{ $r->ringkasan }}
                </div>
             </div>

             <div class="mb-3">
                <label class="form-label">Kendala</label>
                <div class="form-control bg-light">
                    {{ $r->kendala ?? '-' }}
                </div>
             </div>

             <div class="mb-3">
              <label class="form-label">Status Verifikasi</label>
              <select name="status_verifikasi" class="form-select" required>
               <option value="">-- Pilih --</option>
               <option value="terverifikasi">Terverifikasi</option>
               <option value="ditolak">Ditolak</option>
              </select>
             </div>
            </div>

            <div class="modal-footer">
             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Batal
             </button>
             <button type="submit" class="btn btn-primary">
                Simpan
             </button>
            </div>
           </div>
          </form>
         </div>
        </div>
        @endcan

        @empty
        <tr>
         <td colspan="9" class="text-center text-muted">
            Tidak ada data laporan harian
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
                <a class="page-link" href="{{ $reports->previousPageUrl() ?? '#' }}">prev</a>
            </li>

            @foreach ($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $reports->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $reports->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $reports->nextPageUrl() ?? '#' }}">next</a>
            </li>
        </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
@endsection
