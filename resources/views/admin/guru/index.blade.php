@extends('layouts.app')

@section('title', 'Daftar Guru')

@section('content')
<div class="container-xl mt-4">
    <div class="card shadow-sm">

        <!-- Header Filter/Search -->
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title mb-0">Daftar Guru</h3>
        </div>

        <div class="card-body border-bottom py-3">
            <form method="GET" class="d-flex w-100 gap-2">
                {{-- Show entries --}}
                <div class="d-flex align-items-center">
                    Show
                    <select name="per_page" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
                        @foreach([5,10,25,50,100] as $size)
                            <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected':'' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    entries
                </div>

                {{-- Search --}}
                <div class="ms-auto d-flex">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email / NIP"
                           class="form-control form-control-sm">
                    <button class="btn btn-sm btn-primary ms-2">Cari</button>
                </div>
            </form>
        </div>

        <!-- Tabel Guru -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>NIP</th>
                        <th>Email</th>
                        <th>Jabatan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $index => $guru)
                        <tr>
                            <td>{{ $gurus->firstItem() + $index }}</td>
                            <td>{{ $guru->nama_lengkap }}</td>
                            <td>{{ $guru->nip }}</td>
                            <td>{{ $guru->email_resmi }}</td>
                            <td>{{ $guru->jabatan }}</td>
                            <td>
                                <span class="badge {{ $guru->is_active ? 'text-success' : 'text-secondary' }}">
                                    {{ $guru->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.guru.show', $guru->id_guru) }}"
                                   class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data guru</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination -->
        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-secondary">
                Showing <strong>{{ $gurus->firstItem() }}</strong> to <strong>{{ $gurus->lastItem() }}</strong> of <strong>{{ $gurus->total() }}</strong> entries
            </p>

            <ul class="pagination m-0 ms-auto">
                {{ $gurus->links() }}
            </ul>
        </div>
    </div>
</div>
@endsection
