@extends('layouts.app') <!-- layout admin -->

@section('content')
<div class="container">
    <h1>Daftar Halaman</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
<a href="{{ route('admin.pages.create') }}" class="btn btn-success mb-3">+ Buat Halaman Baru</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Slug</th>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
            <tr>
                <td>{{ $page->slug }}</td>
                <td>{{ $page->title }}</td>
                <td>
                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
