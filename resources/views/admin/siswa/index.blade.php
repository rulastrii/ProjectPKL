@extends('layouts.app')
@section('title','Data Siswa')

@section('content')
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-12">
        <div class="card">

          {{-- HEADER --}}
          <div class="card-header d-flex align-items-center">
            <h3 class="card-title">Data Siswa</h3>
          </div>

          <div class="card-body border-bottom py-3">
  <form method="GET" class="row g-2 align-items-center">

    {{-- Show entries --}}
    <div class="col-auto">
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
    </div>

    {{-- Filter Kelas --}}
    <div class="col-auto">
      <select name="kelas" class="form-select form-select-sm"
              onchange="this.form.submit()">
        <option value="">Semua Kelas</option>
        @foreach($kelasList as $kelas)
          <option value="{{ $kelas }}"
            {{ request('kelas') == $kelas ? 'selected':'' }}>
            {{ $kelas }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Filter Jurusan --}}
    <div class="col-auto">
      <select name="jurusan" class="form-select form-select-sm"
              onchange="this.form.submit()">
        <option value="">Semua Jurusan</option>
        @foreach($jurusanList as $jurusan)
          <option value="{{ $jurusan }}"
            {{ request('jurusan') == $jurusan ? 'selected':'' }}>
            {{ $jurusan }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Search --}}
<div class="col-auto ms-auto d-flex align-items-center">
  <input type="text"
         name="search"
         value="{{ request('search') }}"
         placeholder="Cari nama / NISN..."
         class="form-control form-control-sm me-2"
         style="width: 180px;">
  <button class="btn btn-sm btn-primary">
    Search
  </button>
</div>


  </form>
</div>


          {{-- TABLE --}}
          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NISN</th>
                  <th>Kelas</th>
                  <th>Jurusan</th>
                  <th>Status Profil</th>
                  <th class="text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>

                @forelse ($siswa as $index => $item)
                <tr>
                  <td>{{ $siswa->firstItem() + $index }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->nisn ?? '-' }}</td>
                  <td>{{ $item->kelas ?? '-' }}</td>
                  <td>{{ $item->jurusan ?? '-' }}</td>
                  <td>
                    @if ($item->isLengkap())
                      <span class="text-success fw-semibold">Lengkap</span>
                    @else
                      <span class="text-danger fw-semibold">Belum Lengkap</span>
                    @endif
                  </td>
                  <td class="text-end">
                    <a href="{{ route('admin.siswa.show',$item->id) }}"
                       class="btn btn-outline-primary btn-sm">
                      <i class="ti ti-eye"></i>
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center text-muted">
                    Data siswa belum tersedia
                  </td>
                </tr>
                @endforelse

              </tbody>
            </table>
          </div>

          {{-- FOOTER / PAGINATION --}}
          <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-secondary">
              Showing <strong>{{ $siswa->firstItem() }}</strong>
              to <strong>{{ $siswa->lastItem() }}</strong>
              of <strong>{{ $siswa->total() }}</strong> entries
            </p>

            <ul class="pagination m-0 ms-auto">
              <li class="page-item {{ $siswa->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $siswa->previousPageUrl() ?? '#' }}">
                  <i class="ti ti-chevron-left"></i> prev
                </a>
              </li>

              @foreach ($siswa->getUrlRange(1, $siswa->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $siswa->currentPage() ? 'active' : '' }}">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endforeach

              <li class="page-item {{ $siswa->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $siswa->nextPageUrl() ?? '#' }}">
                  next <i class="ti ti-chevron-right"></i>
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
