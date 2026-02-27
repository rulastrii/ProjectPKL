@extends('layouts.app')
@section('title','Sekolah Management')
@section('content')

@php
    // Ambil profil guru login
    $guru = Auth::user()->guruProfile;
    $guruSekolahNama = $guru->sekolah ?? '';
    $sekolahAda = $sekolahs->firstWhere('nama', $guruSekolahNama);
@endphp

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Sekolah</h3>

      {{-- Tombol Add Sekolah muncul jika guru belum punya sekolah terkait atau sekolah tidak cocok --}}
      @if(!$guruSekolahNama || !$sekolahAda)
      <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCreateSekolah">
        <i class="ti ti-plus me-1"></i> Add Sekolah
      </button>
      @endif
     </div>

     <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Sekolah</th>
                    <th>NPSN</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Active</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sekolahs as $sekolah)
                <tr>
                    <td>{{ $sekolah->id }}</td>
                    <td>{{ $sekolah->nama }}</td>
                    <td>{{ $sekolah->npsn }}</td>
                    <td>{{ $sekolah->alamat }}</td>
                    <td>{{ $sekolah->kontak }}</td>
                    <td>
                        {!! $sekolah->is_active 
                            ? '<span class="badge text-success">Active</span>' 
                            : '<span class="badge text-danger">Inactive</span>' !!}
                    </td>
                    <td>
                        {{-- Tombol Detail --}}
                        <a href="{{ route('guru.sekolah.show', $sekolah->id) }}" class="btn btn-outline-info btn-sm"
                        title="Lihat Detail sekolah">
                            <i class="ti ti-eye"></i>
                        </a>

                        {{-- Tombol Edit --}}
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditSekolah-{{ $sekolah->id }}"
                        title="Edit Sekolah">
                            <i class="ti ti-pencil"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Sekolah terkait belum ada atau belum diinput admin.</td>
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

@include('guru.sekolah.modal-create') {{-- Modal Create --}}
@include('guru.sekolah.modal-edit') {{-- Modal Edit --}}
@endsection
