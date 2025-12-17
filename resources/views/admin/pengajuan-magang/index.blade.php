@extends('layouts.app')
@section('title','Pengajuan Magang Mahasiswa')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Pengajuan Magang Mahasiswa</h3>

      <button type="button" class="btn btn-primary ms-auto" 
              data-bs-toggle="modal" 
              data-bs-target="#modalCreatePengajuan">
        <i class="ti ti-plus me-1"></i> Tambah Pengajuan
      </button>
     </div>

     {{-- FILTER BAR --}}
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

        {{-- Filter Status --}}
        <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          @foreach(['draft','diproses','diterima','ditolak','selesai'] as $status)
            <option value="{{ $status }}" {{ request('status') == $status ? 'selected':'' }}>
              {{ ucfirst($status) }}
            </option>
          @endforeach
        </select>
        {{-- Universitas --}}
    <select name="universitas"
            class="form-select form-select-sm w-auto"
            onchange="this.form.submit()">
        <option value="">Semua Universitas</option>
        @foreach($listUniversitas as $u)
            <option value="{{ $u }}"
                {{ request('universitas') == $u ? 'selected' : '' }}>
                {{ $u }}
            </option>
        @endforeach
    </select>


        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>

      </form>
     </div>

     {{-- TABEL DATA --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>#</th>
         <th>Nama Mahasiswa</th>
         <th>Email</th>
         <th>Universitas</th>
         <th>Periode</th>
         <th>Status</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($pengajuan as $i=>$p)
        <tr>
         <td>{{ $pengajuan->firstItem() + $i }}</td>
         <td>{{ $p->nama_mahasiswa }}</td>
         <td>{{ $p->email_mahasiswa }}</td>
         <td>{{ $p->universitas }}</td>
         <td>{{ \Carbon\Carbon::parse($p->periode_mulai)->format('d M Y') }} -
             {{ \Carbon\Carbon::parse($p->periode_selesai)->format('d M Y') }}</td>

         <td>
            <span class="badge 
              @if($p->status=='draft') bg-secondary 
              @elseif($p->status=='diproses') bg-warning 
              @elseif($p->status=='diterima') bg-success 
              @elseif($p->status=='ditolak') bg-danger 
              @elseif($p->status=='selesai') bg-primary 
              @endif text-white">
              {{ ucfirst($p->status) }}
            </span>
         </td>

         <td class="text-end">
            @if(in_array($p->status, ['draft','proses']))

    {{-- Approve --}}
    <form action="{{ route('admin.pengajuan-magang.approve', $p->id) }}"
          method="POST" class="d-inline">
      @csrf
      <button class="btn btn-outline-success btn-sm"
              title="Terima Pengajuan">
        <i class="ti ti-check"></i>
      </button>
    </form>

    {{-- Reject --}}
    <form action="{{ route('admin.pengajuan-magang.reject', $p->id) }}"
          method="POST" class="d-inline">
      @csrf
      <input type="text"
             name="reason"
             class="form-control form-control-sm d-inline w-auto"
             placeholder="Alasan ditolak"
             required>
      <button class="btn btn-outline-danger btn-sm"
              title="Tolak Pengajuan">
        <i class="ti ti-x"></i>
      </button>
    </form>

  @endif

          <a href="{{ route('admin.pengajuan-magang.show', $p->id) }}" 
             class="btn btn-outline-info btn-sm" title="Lihat Detail Pengajuan">
            <i class="ti ti-eye"></i>
          </a>

          <button class="btn btn-outline-warning btn-sm" 
                  data-bs-toggle="modal"
                  data-bs-target="#modalEditPengajuan-{{ $p->id }}">
              <i class="ti ti-pencil"></i>
          </button>

          <form action="{{ route('admin.pengajuan-magang.destroy',$p->id) }}" class="d-inline" method="POST">
            @csrf @method('DELETE')
            <button onclick="return confirm('Hapus data ini?')" 
                    class="btn btn-outline-danger btn-sm"><i class="ti ti-trash"></i>
            </button>
          </form>
         </td>
        </tr>

        @empty
          <tr><td colspan="8" class="text-center">Belum ada data</td></tr>
        @endforelse
       </tbody>

      </table>
     </div>

     {{-- PAGINATION --}}
     <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-secondary">
        Showing <strong>{{ $pengajuan->firstItem() }}</strong> to 
        <strong>{{ $pengajuan->lastItem() }}</strong> of 
        <strong>{{ $pengajuan->total() }}</strong> entries
      </p>

      <ul class="pagination m-0 ms-auto">
        {!! $pengajuan->appends(request()->query())->links('pagination::bootstrap-5') !!}
      </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>

{{-- include modal --}}
@include('admin.pengajuan-magang.modal-create')
@include('admin.pengajuan-magang.modal-edit')

@endsection
