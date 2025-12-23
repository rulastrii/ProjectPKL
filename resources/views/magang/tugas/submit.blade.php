@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Submit Tugas: {{ $tugas->judul }}</h1>
    <form action="{{ route('magang.tugas.submit', $tugas->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>File</label>
            <input type="file" name="file" class="form-control">
        </div>
        <div class="form-group">
            <label>Link Lampiran</label>
            <input type="url" name="link_lampiran" class="form-control">
        </div>
        <button type="submit" class="btn btn-success mt-2">Submit</button>
    </form>
</div>
@endsection
