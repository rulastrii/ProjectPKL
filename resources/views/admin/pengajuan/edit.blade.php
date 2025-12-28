@extends('layouts.app')

@section('content')
<h1>Proses Pengajuan PKL: {{ $pengajuan->no_surat }}</h1>

<form action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" method="POST">
    @csrf
    <table class="table">
        <thead>
            <tr>
                <th>Nama Siswa / Email</th>
                <th>Status Saat Ini</th>
                <th>Update Status</th>
                <th>Catatan Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuan->siswa as $siswa)
            <tr>
                <td>{{ $siswa->siswaProfile->nama ?? '-' }} <br> {{ $siswa->email_siswa }}</td>
                <td>{{ ucfirst($siswa->status) }}</td>
                <td>
                    <select name="siswa_status[{{ $siswa->id }}]" class="form-control">
                        <option value="diterima" {{ $siswa->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $siswa->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </td>
                <td>
                    <input type="text" name="catatan_admin[{{ $siswa->id }}]" class="form-control" value="{{ $siswa->catatan_admin }}">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-success">Simpan & Kirim Notifikasi</button>
</form>

@endsection
