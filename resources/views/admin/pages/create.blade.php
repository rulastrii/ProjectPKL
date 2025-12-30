@extends('layouts.app')

@section('title', 'Buat Page Baru')

@section('content')
<div class="container">
    <h1>Buat Page Baru</h1>
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Content (JSON)</label>
            <textarea name="content" class="form-control" rows="10">{{ old('content') }}</textarea>
            @error('content') <small class="text-danger">{{ $message }}</small> @enderror
            <small class="form-text text-muted">
                Masukkan JSON array. Contoh:
<pre>[
  {
    "icon": "fas fa-envelope-open-text",
    "title": "Surat Pengantar Kampus",
    "desc": "Deskripsi di sini",
    "link": "#"
  }
]</pre>
            </small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
