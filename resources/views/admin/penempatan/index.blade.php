@extends('layouts.app')
@section('title','Penempatan Management')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Header --}}
     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Penempatan</h3>
      <button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#modalCreatePenempatan">
        <i class="ti ti-plus me-1"></i> Add Penempatan
      </button>
     </div>

     {{-- Filter & Search --}}
     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">

        <div class="d-flex align-items-center">
          Show
          <select name="per_page" class="form-select form-select-sm mx-2" onchange="this.form.submit()">
            @foreach([5,10,25,50,100] as $size)
              <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected':'' }}>
                {{ $size }}
              </option>
            @endforeach
          </select>
          entries
        </div>

        <select name="is_active" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
          <option value="">All Status</option>
          <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
          <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
        </select>

        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}"
                 placeholder="Search siswa / bidang..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>

      </form>
     </div>

     {{-- Table --}}
     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No.</th>
         <th>Nama Siswa</th>
         <th>Kelas / Email</th>
         <th>Bidang</th>
         <th>Status</th>
         <th>Created</th>
         <th class="text-end">Actions</th>
        </tr>
       </thead>

       <tbody>
        @forelse($penempatan as $index => $row)
        <tr>
         <td>{{ $penempatan->firstItem() + $index }}</td>

         {{-- Nama Siswa --}}
         <td>
  @if($row->pengajuan_type === 'App\\Models\\PengajuanPklmagang')
    {{ optional($row->pengajuan->siswaProfile)->nama ?? '-' }}
  @else
    {{ $row->pengajuan->nama_mahasiswa ?? '-' }}
  @endif
</td>


         {{-- Kelas --}}
         <td>
  @if($row->pengajuan_type === 'App\\Models\\PengajuanPklmagang')
    {{ optional($row->pengajuan->siswaProfile)->kelas ?? '-' }}
  @else
    {{ $row->pengajuan->email_mahasiswa ?? '-' }}
  @endif
</td>


         {{-- Bidang --}}
         <td>
            {{ $row->bidang->nama ?? '-' }}
         </td>

         {{-- Status --}}
         <td>
            @if($row->is_active)
              <span class="badge bg-success-soft text-success">Active</span>
            @else
              <span class="badge bg-danger-soft text-danger">Inactive</span>
            @endif
         </td>

         {{-- Created --}}
         <td>
            {{ $row->created_date 
                ? \Carbon\Carbon::parse($row->created_date)->format('d M Y') 
                : '-' 
            }}
         </td>

         {{-- Actions --}}
         <td class="text-end">
           <button type="button"
                   class="btn btn-outline-warning btn-sm me-1"
                   data-bs-toggle="modal"
                   data-bs-target="#modalEditPenempatan-{{ $row->id }}"
                   title="Edit">
             <i class="ti ti-pencil"></i>
           </button>

           <form action="{{ route('admin.penempatan.destroy',$row->id) }}"
                 method="POST" class="d-inline">
               @csrf
               @method('DELETE')
               <button type="submit"
                       onclick="return confirm('Delete penempatan?')"
                       class="btn btn-outline-danger btn-sm">
                   <i class="ti ti-trash"></i>
               </button>
           </form>
         </td>
        </tr>

        @empty
        <tr>
          <td colspan="7" class="text-center text-muted">
            No penempatan found
          </td>
        </tr>
        @endforelse
       </tbody>
      </table>
     </div>

     {{-- Pagination --}}
     <div class="card-footer d-flex align-items-center">
      <p class="m-0 text-secondary">
          Showing
          <strong>{{ $penempatan->firstItem() }}</strong>
          to
          <strong>{{ $penempatan->lastItem() }}</strong>
          of
          <strong>{{ $penempatan->total() }}</strong>
          entries
      </p>

      <ul class="pagination m-0 ms-auto">
        @foreach ($penempatan->getUrlRange(1, $penempatan->lastPage()) as $page => $url)
          <li class="page-item {{ $page == $penempatan->currentPage() ? 'active' : '' }}">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
          </li>
        @endforeach
      </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>

@include('admin.penempatan.modal-create')
@include('admin.penempatan.modal-edit')

@endsection
