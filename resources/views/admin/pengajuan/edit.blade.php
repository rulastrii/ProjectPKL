@extends('layouts.app')
@section('title','Proses Pengajuan PKL')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Header --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Proses Pengajuan PKL: {{ $pengajuan->no_surat }}</h3>
      <span class="ms-auto text-muted">Status: <strong>{{ ucfirst($pengajuan->status) }}</strong></span>
     </div>

     {{-- Form update --}}
     <div class="card-body">
      <form action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" method="POST">
        @csrf

        <div class="table-responsive">
         <table class="table card-table table-vcenter text-nowrap">
          <thead>
            <tr>
                <th>Nama Siswa / Email</th>
                <th>Status Saat Ini</th>
                <th>Update Status</th>
                <th>Catatan Admin</th>
            </tr>
          </thead>
          <tbody>
            @forelse($pengajuan->siswa as $siswa)
            <tr>
                <td>
                  {{ $siswa->nama_siswa ?? '-' }}  <br>
                  <small class="text-muted">{{ $siswa->email_siswa }}</small>
                </td>
                <td>{{ ucfirst($siswa->status) }}</td>
                <td>
                  <select name="siswa_status[{{ $siswa->id }}]" class="form-select form-select-sm">
                      <option value="diterima" {{ $siswa->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                      <option value="ditolak" {{ $siswa->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                  </select>
                </td>
                <td>
                  <input type="text" name="catatan_admin[{{ $siswa->id }}]" class="form-control form-control-sm" value="{{ $siswa->catatan_admin }}">
                </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center">Belum ada siswa untuk pengajuan ini</td>
            </tr>
            @endforelse
          </tbody>
         </table>
        </div>

        {{-- Submit Button --}}
        <div class="mt-3">
          <button type="submit" class="btn btn-success">
            <i class="ti ti-send me-1"></i> Simpan & Kirim Notifikasi
          </button>
          <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-secondary ms-2">Kembali</a>
        </div>
      </form>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>

@endsection
