@extends('layouts.app')
@section('title', 'Detail Pembimbing')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0"><i class="ti ti-user-check me-2"></i>Detail Pembimbing</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr><th>ID</th><td>{{ $pembimbing->id }}</td></tr>
                        <tr><th>Pembimbing</th><td>{{ $pembimbing->pegawai->nama ?? '-' }}</td></tr>
                        <tr>
                            <th>Jenis Pengajuan</th>
                            <td>
                                @if($pembimbing->pengajuan_type === \App\Models\PengajuanPklmagang::class)
                                    <span class="badge bg-info-soft text-info">Peserta PKL</span>
                                @elseif($pembimbing->pengajuan_type === \App\Models\PengajuanMagangMahasiswa::class)
                                    <span class="badge bg-warning-soft text-warning">Peserta Magang</span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Pengajuan</th>
                            <td>
                                @if($pembimbing->pengajuan)
                                    <strong>No Surat:</strong> {{ $pembimbing->pengajuan->no_surat ?? '-' }} <br>
                                    @if($pembimbing->pengajuan_type === \App\Models\PengajuanPklmagang::class)
    <strong>Siswa:</strong>
    <ul class="mb-1">
        @forelse($pembimbing->pengajuan->siswa as $ps)
            <li>{{ $ps->siswaProfile->nama ?? $ps->nama_siswa ?? '-' }}</li>
        @empty
            <li>-</li>
        @endforelse
    </ul>
    <small>Sekolah: {{ $pembimbing->pengajuan->sekolah->nama ?? '-' }}</small>

                                    @elseif($pembimbing->pengajuan_type === \App\Models\PengajuanMagangMahasiswa::class)
                                        <small>Mahasiswa: {{ $pembimbing->pengajuan->nama_mahasiswa ?? '-' }} <br>
                                        Universitas: {{ $pembimbing->pengajuan->universitas ?? '-' }}</small>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr><th>Tahun</th><td>{{ $pembimbing->tahun ?? '-' }}</td></tr>
                        <tr>
                            <th>Status</th>
                            <td>{!! $pembimbing->is_active ? '<span class="badge bg-success-soft text-success">Aktif</span>' : '<span class="badge bg-danger-soft text-danger">Tidak Aktif</span>' !!}</td>
                        </tr>
                        <tr><th>Dibuat</th><td>{{ optional($pembimbing->created_date)->format('d M Y H:i') ?? '-' }}</td></tr>
                        <tr><th>Diperbarui</th><td>{{ optional($pembimbing->updated_date)->format('d M Y H:i') ?? '-' }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('pembimbing.bimbingan-peserta.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
