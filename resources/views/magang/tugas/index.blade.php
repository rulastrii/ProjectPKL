@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tugas Saya</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tenggat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tugas as $t)
            <tr>
                <td>{{ $t->judul }}</td>
                <td>{{ $t->tenggat_formatted }}</td>
                <td>{{ $t->status }}</td>
                <td>
                    <a href="{{ route('magang.tugas.submitForm', $t->id) }}" class="btn btn-sm btn-primary">Submit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
