@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-xl mt-4">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">

                    {{-- Card Header --}}
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title fw-bold">Nilai Akhir PKL</h3>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body">

                        @if(!$penilaian)
                            <div class="alert alert-warning text-center">
                                Nilai akhir belum tersedia
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 table-vcenter">
                                    <tbody>
                                        <tr>
                                            <th>Nilai Tugas</th>
                                            <td>{{ $penilaian->nilai_tugas !== null ? number_format($penilaian->nilai_tugas, 2) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Laporan</th>
                                            <td>{{ $penilaian->nilai_laporan !== null ? number_format($penilaian->nilai_laporan, 2) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Keaktifan</th>
                                            <td>{{ $penilaian->nilai_keaktifan !== null ? number_format($penilaian->nilai_keaktifan, 2) : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Sikap</th>
                                            <td>{{ $penilaian->nilai_sikap !== null ? number_format($penilaian->nilai_sikap, 2) : '-' }}</td>
                                        </tr>
                                        {{-- Nilai Akhir muncul hanya jika Tugas dan Laporan sudah ada --}}
                                        @if($penilaian->nilai_tugas !== null && $penilaian->nilai_laporan !== null)
                                        <tr class="table-success fw-bold">
                                            <th>Nilai Akhir</th>
                                            <td>{{ number_format($penilaian->nilai_akhir, 2) }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            {{-- Tombol Lihat Sertifikat --}}
                            @if($penilaian->nilai_tugas !== null && $penilaian->nilai_laporan !== null)
                            <div class="text-end mt-3">
                                <a href="{{ route('siswa.sertifikat.index') }}" class="btn btn-primary d-flex align-items-center justify-content-center gap-2">
                                    <i class="ti ti-certificate"></i> Lihat Sertifikat
                                </a>
                            </div>
                            @endif

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
