@extends('layouts.app')

@section('title', 'Edit Page')

@section('content')
<div class="container">
    <h1>Edit Page</h1>
    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label>Content (JSON)</label>
            <textarea name="content" class="form-control" rows="10">{{ old('content', $page->content) }}</textarea>
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
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
