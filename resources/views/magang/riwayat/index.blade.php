@extends('layouts.app')
@section('title','Riwayat Magang')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Riwayat Magang</h3>
     </div>

     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap table-hover">
       <thead>
        <tr>
         <th>No.</th>
         <th>Perusahaan / Instansi</th>
         <th>Periode</th>
         <th>Posisi</th>
         <th>Nilai Akhir</th>
         <th>Sertifikat</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>
       <tbody>
        @forelse($riwayat as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="white-space: normal; max-width: 200px;">
                {{ $item->instansi }}
            </td>
            <td>{{ $item->periode_mulai ? \Carbon\Carbon::parse($item->periode_mulai)->format('d M Y') : '-' }}
                - {{ $item->periode_selesai ? \Carbon\Carbon::parse($item->periode_selesai)->format('d M Y') : '-' }}</td>
            <td>{{ $item->posisi }}</td>
            <td>{{ $item->nilai_akhir ?? '-' }}</td>
            <td>
                @if($item->sertifikat)
                    <a href="{{ asset($item->sertifikat->file_path) }}" target="_blank" class="btn btn-sm btn-success" title="Silahkan Unduh Sertifikat">
                        <i class="ti ti-download"></i>
                    </a>
                @else
                    -
                @endif
            </td>
            <td class="text-end">
                <a href="{{ route('magang.riwayat.show', $item->id) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                    <i class="ti ti-eye"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Belum ada riwayat magang</td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
@endsection
