@extends('layouts.app')
@section('title','Verifikasi Presensi')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- HEADER --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Verifikasi Presensi Peserta</h3>
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

          <input type="date"
                 name="tanggal"
                 value="{{ request('tanggal', $tanggal ?? date('Y-m-d')) }}"
                 class="form-control form-control-sm ms-2"
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
         <th>Kelas / Universitas</th>
         <th>Jam Masuk</th>
         <th>Jam Pulang</th>
         <th>Status</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($presensi as $index => $p)
        <tr>
         <td>{{ ($presensi->firstItem() ?? 0) + $index }}</td>
         <td class="fw-semibold">{{ $p->siswa->nama ?? '-' }}</td>
         <td>{{ $p->siswa->nisn ?? $p->siswa->nim ?? '-' }}</td>
         <td>{{ $p->siswa->kelas ?? $p->siswa->universitas ?? '-' }}</td>
         <td>{{ $p->jam_masuk ?? '-' }}</td>
         <td>{{ $p->jam_keluar ?? '-' }}</td>
         <td>
            @php
                $badge = match($p->status) {
                    'hadir' => 'bg-success-soft text-success',
                    'izin'  => 'bg-warning-soft text-warning',
                    'sakit' => 'bg-info-soft text-info',
                    default => 'bg-danger-soft text-danger'
                };
            @endphp
            <span class="badge {{ $badge }}">
                {{ strtoupper($p->status) }}
            </span>
         </td>
         <td class="text-end">
            @if($p->tanggal == date('Y-m-d'))
            <button class="btn btn-outline-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#verifikasiModal{{ $p->id }}"
                    title="Verifikasi presensi hari ini">
                <i class="ti ti-check"></i>
            </button>
            @else
            <span class="text-muted">Locked</span>
            @endif
         </td>
        </tr>

        {{-- MODAL VERIFIKASI --}}
        <div class="modal fade" id="verifikasiModal{{ $p->id }}" tabindex="-1">
         <div class="modal-dialog">
          <form method="POST"
                action="{{ route('pembimbing.verifikasi-presensi.update', $p->id) }}">
           @csrf
           @method('PUT')

           <div class="modal-content">
            <div class="modal-header">
             <h5 class="modal-title">Verifikasi Presensi</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
             <p class="mb-2">
                <strong>{{ $p->siswa->nama }}</strong><br>
                Tanggal: {{ $p->tanggal }}
             </p>

             <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select" required>
               <option value="hadir" {{ $p->status=='hadir'?'selected':'' }}>Hadir</option>
               <option value="izin" {{ $p->status=='izin'?'selected':'' }}>Izin</option>
               <option value="sakit" {{ $p->status=='sakit'?'selected':'' }}>Sakit</option>
               <option value="absen" {{ $p->status=='absen'?'selected':'' }}>Absen</option>
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

        @empty
        <tr>
         <td colspan="8" class="text-center text-muted">
            Tidak ada data presensi
         </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- PAGINATION --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $presensi->firstItem() ?? 0 }}</strong>
            to <strong>{{ $presensi->lastItem() ?? 0 }}</strong>
            of <strong>{{ $presensi->total() ?? 0 }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $presensi->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $presensi->previousPageUrl() ?? '#' }}">prev</a>
            </li>

            @foreach ($presensi->getUrlRange(1, $presensi->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $presensi->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $presensi->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $presensi->nextPageUrl() ?? '#' }}">next</a>
            </li>
        </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
@endsection
