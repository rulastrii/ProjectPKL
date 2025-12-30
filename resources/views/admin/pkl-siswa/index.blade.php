@extends('layouts.app')

@section('title', 'Daftar Siswa PKL')

@section('content')
<div class="container-xl mt-4">
    <div class="card shadow-sm">
        <div class="card-header d-flex align-items-center">
            <h3 class="card-title">Daftar Siswa PKL</h3>
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / email..."
                           class="form-control form-control-sm">
                    <button class="btn btn-sm btn-primary ms-2">Cari</button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Sekolah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $item)
                        <tr>
                            <td>{{ $siswa->firstItem() + $index }}</td>
                            <td>{{ $item->nama_siswa }}</td>
                            <td>{{ $item->email_siswa }}</td>
                            <td>{{ $item->pengajuan->sekolah->nama ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.pkl-siswa.show', $item->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="ti ti-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data siswa PKL</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-secondary">
                Showing <strong>{{ $siswa->firstItem() }}</strong> to <strong>{{ $siswa->lastItem() }}</strong> of <strong>{{ $siswa->total() }}</strong> entries
            </p>

            <ul class="pagination m-0 ms-auto">
                {{ $siswa->links() }}
            </ul>
        </div>
    </div>
</div>
@endsection
