@extends('layouts.app')

@section('title', 'Detail Presensi')

@section('content')
<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Detail Presensi</h2>
                <div class="text-muted mt-1">
                    Riwayat kehadiran siswa
                </div>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.presensi.index') }}"
                   class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- FILTER TANGGAL --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal"
                               class="form-control"
                               value="{{ request('tanggal_awal') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir"
                               class="form-control"
                               value="{{ request('tanggal_akhir') }}">
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary">
                            <i class="ti ti-search me-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table table-vcenter table-hover">
                <thead class="bg-muted text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Status</th>
                        <th>Foto Masuk</th>
                        <th>Foto Pulang</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($presensi as $item)
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td>{{ $item->jam_masuk ?? '-' }}</td>
                        <td>{{ $item->jam_keluar ?? '-' }}</td>

                        {{-- STATUS --}}
                        <td>
                            @php
                                $statusClass = [
                                    'hadir' => 'text-success',
                                    'izin'  => 'text-warning',
                                    'sakit' => 'text-info',
                                    'absen' => 'text-danger',
                                ];
                            @endphp
                            <span class="badge {{ $statusClass[$item->status] ?? 'bg-secondary' }}">
                                {{ strtoupper($item->status) }}
                            </span>
                        </td>

                        {{-- FOTO MASUK --}}
                        <td>
                            @if($item->foto_masuk)
                                <img src="{{ asset('uploads/presensi/'.$item->foto_masuk) }}"
                                     class="rounded shadow-sm"
                                     width="55"
                                     data-bs-toggle="modal"
                                     data-bs-target="#fotoModal"
                                     onclick="showFoto('{{ asset('uploads/presensi/'.$item->foto_masuk) }}')"
                                     style="cursor:pointer">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- FOTO PULANG --}}
                        <td>
                            @if($item->foto_pulang)
                                <img src="{{ asset('uploads/presensi/'.$item->foto_pulang) }}"
                                     class="rounded shadow-sm"
                                     width="55"
                                     data-bs-toggle="modal"
                                     data-bs-target="#fotoModal"
                                     onclick="showFoto('{{ asset('uploads/presensi/'.$item->foto_pulang) }}')"
                                     style="cursor:pointer">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="ti ti-alert-circle me-1"></i>
                            Data presensi kosong
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL FOTO --}}
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Presensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalFoto" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
    function showFoto(src) {
        document.getElementById('modalFoto').src = src;
    }
</script>

@endsection
