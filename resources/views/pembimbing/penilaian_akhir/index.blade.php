@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="d-flex align-items-center mb-3">
        <h3 class="fw-bold me-auto">Penilaian Akhir Peserta</h3>
        <a href="{{ route('pembimbing.penilaian-akhir.form', $item->id) }}"
   class="btn btn-outline-success btn-sm">Penilaian Akhir</a>

        <a href="{{ route('pembimbing.tugas.index') }}" class="btn btn-outline-primary">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm rounded-0">
        <div class="card-header">
            <h5 class="m-0">Daftar Peserta Bimbingan</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Nilai Akhir</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                {{ $item->penilaianAkhir->nilai_akhir ?? '-' }}
                            </td>
                            <td>
                                @if($item->penilaianAkhir)
                                    <span class="badge text-success">Sudah Dinilai</span>
                                @else
                                    <span class="badge text-warning">Belum Dinilai</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('pembimbing.penilaian-akhir.form', $item->id) }}"
                                   class="btn btn-outline-success btn-sm">
                                    <i class="ti ti-edit"></i>
                                    {{ $item->penilaianAkhir ? 'Edit Nilai' : 'Input Nilai' }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada peserta
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
