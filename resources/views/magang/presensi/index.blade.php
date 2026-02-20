@extends('layouts.app')
@section('title','Data Presensi Magang')

@section('content')
<div class="page-body">
  <div class="container-xl">

    @php
        $magang = auth()->user()->siswaProfile; // pastikan relasi user->siswaProfile ada
        if(!$magang) {
            echo "<div class='alert alert-danger'>Profile magang tidak ditemukan.</div>";
        } else {
            $todayPresensi = \App\Models\Presensi::where('siswa_id', $magang->id)
                                ->where('tanggal', date('Y-m-d'))
                                ->first();
            $jamMasuk = $todayPresensi->jam_masuk ?? null;
            $jamPulang = $todayPresensi->jam_keluar ?? null;
            $absenMasukSudah = !is_null($jamMasuk);
            $absenPulangSudah = !is_null($jamPulang);
        }
    @endphp

    @if($magang)
      {{-- FORM ABSENSI --}}
      <div class="mb-4">
          @include('magang.presensi._form', [
              'magang' => $magang,
              'todayPresensi' => $todayPresensi,
              'jamMasuk' => $jamMasuk,
              'jamPulang' => $jamPulang,
              'absenMasukSudah' => $absenMasukSudah,
              'absenPulangSudah' => $absenPulangSudah
          ])
      </div>

      {{-- TABEL PRESENSI --}}
      <div class="row row-cards">
        <div class="col-12">
          <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Presensi Magang</h3>
            </div>

            <div class="card-body border-bottom py-3">
              <form method="GET" class="d-flex w-100 gap-2">
                <div class="d-flex align-items-center">
                  Show
                  <select name="per_page" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
                    @foreach([5,10,25,50] as $size)
                      <option value="{{ $size }}" {{ request('per_page',10) == $size ? 'selected':'' }}>
                        {{ $size }}
                      </option>
                    @endforeach
                  </select>
                  entries
                </div>

                <div class="ms-2">
                  <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control form-control-sm" onchange="this.form.submit()">
                </div>

                <div class="ms-2">
                  <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="hadir" {{ request('status')=='hadir'?'selected':'' }}>Hadir</option>
                    <option value="izin" {{ request('status')=='izin'?'selected':'' }}>Izin</option>
                    <option value="sakit" {{ request('status')=='sakit'?'selected':'' }}>Sakit</option>
                    <option value="absen" {{ request('status')=='absen'?'selected':'' }}>Absen</option>
                  </select>
                </div>

                <div class="ms-auto d-flex">
                  <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NISN / NIM..." class="form-control form-control-sm">
                  <button class="btn btn-sm btn-primary ms-2">Search</button>
                </div>
              </form>
            </div>

            <div class="table-responsive">
              <table class="table card-table table-vcenter text-nowrap table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Magang</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                    <th>Foto Masuk</th>
                    <th>Foto Pulang</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($presensi as $i => $p)
                    <tr>
                      <td>{{ $presensi->firstItem() + $i }}</td>
                      <td>{{ $p->siswa->nama ?? '-' }}</td>
                      <td>{{ $p->tanggal }}</td>
                      <td>{{ $p->jam_masuk ?? '-' }}</td>
                      <td>{{ $p->jam_keluar ?? '-' }}</td>
                      <td>{{ ucfirst($p->status) ?? '-' }}</td>
                      <td>
                        @if($p->foto_masuk)
                          <img src="{{ asset('uploads/presensi/'.$p->foto_masuk) }}" width="50">
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if($p->foto_pulang)
                          <img src="{{ asset('uploads/presensi/'.$p->foto_pulang) }}" width="50">
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" class="text-center">Data presensi belum tersedia</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
              <p class="m-0 text-secondary">Showing {{ $presensi->firstItem() }} to {{ $presensi->lastItem() }} of {{ $presensi->total() }}</p>
              {{ $presensi->links() }}
            </div>

          </div>
        </div>
      </div>
    @endif

  </div>
</div>
@endsection
