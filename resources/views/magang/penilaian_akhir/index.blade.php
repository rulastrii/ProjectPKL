@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">Nilai Akhir Magang / PKL</h3>

    <div class="card shadow-sm rounded-0">
        <div class="card-body">

            @if(!$penilaian)
                <div class="alert alert-warning text-center">
                    Nilai akhir belum tersedia
                </div>
            @else
                <table class="table table-bordered mb-0">
                    <tr>
                        <th>Nilai Tugas</th>
                        <td>{{ $penilaian->nilai_tugas }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Laporan</th>
                        <td>{{ $penilaian->nilai_laporan }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Keaktifan</th>
                        <td>{{ $penilaian->nilai_keaktifan }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Sikap</th>
                        <td>{{ $penilaian->nilai_sikap }}</td>
                    </tr>
                    <tr class="table-success fw-bold">
                        <th>Nilai Akhir</th>
                        <td>{{ $penilaian->nilai_akhir }}</td>
                    </tr>
                </table>

                <div class="text-end mt-3">
                    <a href="{{ route('magang.sertifikat.download') }}"
                       class="btn btn-primary">
                        <i class="ti ti-download"></i> Download Sertifikat
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
