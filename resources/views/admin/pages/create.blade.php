@extends('layouts.app')

@section('title', 'Buat Page Baru')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header">
        <h3 class="card-title">Buat Page Baru</h3>
     </div>

     <div class="card-body">
        <form action="{{ route('admin.pages.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title') }}"
                       placeholder="Masukkan judul halaman, misal: Syarat Magang">
                @error('title')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug" class="form-control"
                       value="{{ old('slug') }}"
                       placeholder="Masukkan slug URL, misal: syarat-magang">
                @error('slug')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Konten</label>
                <textarea name="content" class="form-control" rows="10"
                          placeholder="Tulis judul dan deskripsi tiap item, 2 baris per item. Baris 1 = judul, baris 2 = deskripsi.">{{ old('content') }}</textarea>
                @error('content')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <small class="text-muted d-block mt-1">
                    Contoh:  
                    <br>Judul Item 1  
                    <br>Deskripsi Item 1  
                    <br>Judul Item 2  
                    <br>Deskripsi Item 2  
                </small>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="ti ti-check me-1"></i> Simpan
            </button>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary ms-2">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </form>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
@endsection
