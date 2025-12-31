@extends('layouts.app')

@section('title', 'Dashboard Pembimbing')

@section('content')

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
            <div class="col-12 col-lg-6">
              <div class="row row-cards">

                <!-- Card 1 -->
                <div class="col-12 col-sm-6">
                  <div class="card card-sm h-100">
                    <div class="card-body d-flex align-items-center">
                      <span class="avatar bg-primary text-white me-3">
                        <i class="ti ti-users fs-1"></i>
                      </span>
                      <div>
                          <div class="fw-bold fs-3">{{ $jumlahSiswa }}</div>
                          <div class="text-secondary">Jumlah Siswa Bimbingan</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Card 2 : Laporan Belum Diverifikasi -->
            <div class="col-12 col-sm-6">
              <div class="card card-sm h-100">
                <div class="card-body d-flex align-items-center">
                  <span class="avatar bg-danger text-white me-3">
                    <i class="ti ti-file-description fs-1"></i>
                  </span>
                  <div>
                    <div class="fw-bold fs-3">
                      {{ $jumlahLaporanBelumVerifikasi }}
                    </div>
                    <div class="text-secondary">
                      Laporan Belum Diverifikasi
                    </div>
                  </div>
                </div>
              </div>
            </div>


                <!-- Card 3 -->
                <div class="col-12 col-sm-6">
                  <div class="card card-sm h-100">
                    <div class="card-body d-flex align-items-center">
                      <span class="avatar bg-yellow text-white me-3">
                        <i class="ti ti-clock fs-1"></i>
                      </span>
                      <div>
                        <div class="fw-bold fs-3">{{ $jumlahPresensiHadir }}</div>
                        <div class="text-secondary">Presensi Hadir</div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Card 4 -->
                <div class="col-12 col-sm-6">
                  <div class="card card-sm h-100">
                    <div class="card-body d-flex align-items-center">
                      <span class="avatar bg-green text-white me-3">
                        <i class="ti ti-book-2 fs-1"></i>
                      </span>
                      <div>
                        <div class="fw-bold fs-3">{{ $jumlahTugasBaru }}</div>
                        <div class="text-secondary">Submit Tugas Baru</div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

              <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                <h3 class="card-title">Aktivitas Terbaru</h3>
                </div>

                <div class="table-responsive" style="max-height:260px;overflow-y:auto;">
                <table class="table card-table table-vcenter">
                  <tbody>

              @forelse($aktivitas as $i => $a)
              <tr>
                <td class="w-1 text-secondary">{{ $i + 1 }}.</td>
                <td>
                  <strong>{{ $a['nama'] }}</strong>
                  {{ $a['aksi'] }}
                </td>
                <td class="text-nowrap text-secondary">
                  {{ \Carbon\Carbon::parse($a['tanggal'])->format('d M Y H:i') }}
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="text-center text-muted">
                  Belum ada aktivitas
                </td>
              </tr>
              @endforelse


                  </tbody>
                </table>
                </div>
              </div>
              </div>


            {{-- DAFTAR SISWA BIMBINGAN --}}
                <div class="col-md-6">
                  <div class="card">

                    {{-- HEADER --}}
                    <div class="card-header">
                      <h3 class="card-title">Daftar Siswa Bimbingan</h3>
                    </div>

                    {{-- TABLE --}}
                    <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
                      <table class="table card-table table-vcenter table-hover">
                        <thead class="sticky-top bg-white">
                          <tr>
                            <th>Nama Siswa</th>
                            <th>Sekolah</th>
                            <th>Periode PKL</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($daftarSiswa as $s)
                            <tr style="cursor:pointer">
                              <td>{{ $s->pengajuan->nama_mahasiswa ?? '-' }}</td>
                              <td>{{ $s->pengajuan->sekolah->nama ?? $s->pengajuan->universitas ?? '-' }}</td>
                              <td>
                                  @if($s->pengajuan)
                                      {{ \Carbon\Carbon::parse($s->pengajuan->periode_mulai)->translatedFormat('d M Y') ?? '-' }}
                                      –
                                      {{ \Carbon\Carbon::parse($s->pengajuan->periode_selesai)->translatedFormat('d M Y') ?? '-' }}
                                  @else
                                      -
                                  @endif
                              </td>

                              <td class="text-center 
                                  @if(($s->pengajuan->progress ?? 0) < 60) text-danger
                                  @elseif(($s->pengajuan->progress ?? 0) < 80) text-warning
                                  @else text-success
                                  @endif
                                  fw-semibold">
                                {{ $s->pengajuan->progress ?? 0 }}%
                              </td>
                              <td class="text-center">
                <!-- Tombol Detail -->
                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $s->id }}">
                    Detail
                </button>

                <!-- Modal -->
                <div class="modal fade" id="detailModal{{ $s->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $s->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="detailModalLabel{{ $s->id }}">
                            <i class="ti ti-user-check me-2"></i>Detail Pembimbing
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <table class="table table-striped table-hover mb-0">
                            <tbody>
                                <tr><th>ID</th><td>{{ $s->id }}</td></tr>
                                <tr><th>Pembimbing</th><td>{{ $s->pegawai->nama ?? '-' }}</td></tr>
                                <tr>
                                    <th>Jenis Pengajuan</th>
                                    <td>
                                        @if($s->pengajuan_type === \App\Models\PengajuanPklmagang::class)
                                            <span class="badge bg-info-soft text-info">Siswa PKL</span>
                                        @elseif($s->pengajuan_type === \App\Models\PengajuanMagangMahasiswa::class)
                                            <span class="badge bg-warning-soft text-warning">Magang Mahasiswa</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Pengajuan</th>
                                    <td>
                                        @if($s->pengajuan)
                                            <strong>No Surat:</strong> {{ $s->pengajuan->no_surat ?? '-' }} <br>
                                            @if($s->pengajuan_type === \App\Models\PengajuanPklmagang::class)
                                                <small>Sekolah: {{ $s->pengajuan->sekolah->nama ?? '-' }}</small> <br>
                                                <small>Periode: 
                                                    {{ \Carbon\Carbon::parse($s->pengajuan->periode_mulai)->format('M') }}
                                                    –
                                                    {{ \Carbon\Carbon::parse($s->pengajuan->periode_selesai)->format('M Y') }}
                                                </small>
                                            @elseif($s->pengajuan_type === \App\Models\PengajuanMagangMahasiswa::class)
                                                <small>Mahasiswa: {{ $s->pengajuan->nama_mahasiswa ?? '-' }}</small> <br>
                                                <small>Universitas: {{ $s->pengajuan->universitas ?? '-' }}</small> <br>
                                                <small>Periode: 
                                                    {{ \Carbon\Carbon::parse($s->pengajuan->periode_mulai)->format('M') }}
                                                    –
                                                    {{ \Carbon\Carbon::parse($s->pengajuan->periode_selesai)->format('M Y') }}
                                                </small>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr><th>Status</th>
                                    <td>{!! $s->is_active ? '<span class="badge bg-success-soft text-success">Aktif</span>' : '<span class="badge bg-danger-soft text-danger">Tidak Aktif</span>' !!}</td>
                                </tr>
                                <tr><th>Dibuat</th><td>{{ optional($s->created_date)->format('d M Y H:i') ?? '-' }}</td></tr>
                                <tr><th>Diperbarui</th><td>{{ optional($s->updated_date)->format('d M Y H:i') ?? '-' }}</td></tr>
                            </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                      </div>
                    </div>
                  </div>
                </div>
            </td>

                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted">Belum ada siswa bimbingan</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </div>
    </div>

  <div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Aksi Cepat</h3>
    </div>

    <div class="card-body">

      <!-- 1. Buat Tugas Baru -->
<div class="mb-3">
    <div class="card text-white bg-success" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#buatTugasModal">
        <div class="card-body d-flex align-items-center">
            <i class="ti ti-plus me-3" style="font-size: 2rem;"></i>
            <h5 class="mb-0">Buat Tugas Baru</h5>
        </div>
    </div>
</div>
<!-- Modal Buat Tugas Baru -->
<div class="modal fade" id="buatTugasModal" tabindex="-1" aria-labelledby="buatTugasModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="buatTugasModalLabel">Buat Tugas Baru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('pembimbing.tugas.store') }}" method="POST" id="tugasFormModal">
            @csrf

            {{-- Judul --}}
            <div class="mb-3">
                <label class="form-label fw-semibold small">Judul</label>
                <input type="text" name="judul" class="form-control form-control-sm border-primary" placeholder="Judul tugas..." required>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label class="form-label fw-semibold small">Deskripsi</label>
                <div id="toolbarModal">
                    <span class="ql-formats">
                        <button class="ql-bold"></button>
                        <button class="ql-italic"></button>
                        <button class="ql-underline"></button>
                        <button class="ql-strike"></button>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-size"></select>
                        <select class="ql-color"></select>
                        <select class="ql-background"></select>
                    </span>
                    <span class="ql-formats">
                        <select class="ql-align"></select>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-list" value="ordered"></button>
                        <button class="ql-list" value="bullet"></button>
                        <button class="ql-indent" value="-1"></button>
                        <button class="ql-indent" value="+1"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-link"></button>
                        <button class="ql-image"></button>
                        <button class="ql-video"></button>
                    </span>
                    <span class="ql-formats">
                        <button class="ql-clean"></button>
                    </span>
                </div>
                <div id="editorModal" class="border border-primary rounded p-2" style="height:250px; background:#fff;"></div>
                <input type="hidden" name="deskripsi" id="hidden-deskripsi-modal">
            </div>

            {{-- Tenggat --}}
            <div class="mb-3">
                <label class="form-label fw-semibold small">Tenggat</label>
                <input type="datetime-local" name="tenggat" class="form-control form-control-sm border-primary" required>
            </div>

            <div class="text-end mt-2">
                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    function imageHandler(quill) {
        let input = document.createElement('input');
        input.setAttribute('type','file');
        input.setAttribute('accept','image/*');
        input.click();
        input.onchange = () => {
            let file = input.files[0];
            if(/^image\//.test(file.type)){
                let reader = new FileReader();
                reader.onload = e => {
                    let range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', e.target.result);
                    quill.setSelection(range.index + 1);
                }
                reader.readAsDataURL(file);
            } else { alert('Hanya file gambar yang didukung.'); }
        }
    }

    function videoHandler(quill) {
        let input = document.createElement('input');
        input.setAttribute('type','file');
        input.setAttribute('accept','video/*');
        input.click();
        input.onchange = () => {
            let file = input.files[0];
            if(/^video\//.test(file.type)){
                let reader = new FileReader();
                reader.onload = e => {
                    let range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'video', e.target.result);
                    quill.setSelection(range.index + 1);
                }
                reader.readAsDataURL(file);
            } else { alert('Hanya file video yang didukung.'); }
        }
    }

    var quillModal = new Quill('#editorModal', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi tugas di sini...',
        modules: {
            toolbar: {
                container: '#toolbarModal',
                handlers: {
                    'image': () => imageHandler(quillModal),
                    'video': () => videoHandler(quillModal)
                }
            }
        }
    });

    document.getElementById('tugasFormModal').addEventListener('submit', function(e){
        let content = quillModal.root.innerHTML.trim();
        if(content === '' || content === '<p><br></p>'){
            alert('Deskripsi tidak boleh kosong!');
            e.preventDefault();
            return false;
        }
        document.getElementById('hidden-deskripsi-modal').value = content;
    });
</script>


      <!-- 2. Verifikasi Presensi -->
<div class="mb-3">
  <div class="card text-white bg-yellow" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#verifikasiPresensiModal">
    <div class="card-body d-flex align-items-center">
      <i class="ti ti-clock me-3" style="font-size: 2rem;"></i>
      <h5 class="mb-0">Verifikasi Presensi</h5>
    </div>
  </div>
</div>

<!-- Modal Verifikasi Presensi -->
<div class="modal fade" id="verifikasiPresensiModal" tabindex="-1" aria-labelledby="verifikasiPresensiModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-yellow text-white">
        <h5 class="modal-title" id="verifikasiPresensiModalLabel">Verifikasi Presensi Peserta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div class="table-responsive">
          <table class="table table-striped table-hover mb-0">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>NISN / NIM</th>
                <th>Kelas / Universitas</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($presensi as $index => $p)
              <tr>
                <td>{{ ($presensi->firstItem() ?? 0) + $index }}</td>
                <td class="fw-semibold">{{ $p->siswa->nama ?? '-' }}</td>
                <td>{{ $p->siswa->nisn ?? $p->siswa->nim ?? '-' }}</td>
                <td>{{ $p->siswa->kelas ?? $p->siswa->universitas ?? '-' }}</td>
                <td>{{ $p->jam_masuk ?? '-' }}</td>
                <td>{{ $p->jam_keluar ?? '-' }}</td>
                <td>
                  @php
                    $badge = match($p->status) {
                        'hadir' => 'bg-success-soft text-success',
                        'izin'  => 'bg-warning-soft text-warning',
                        'sakit' => 'bg-info-soft text-info',
                        default => 'bg-danger-soft text-danger'
                    };
                    $tooltip = '';
                    if($p->status === 'absen') {
                        if(!$p->jam_masuk && !$p->jam_keluar) $tooltip = 'Tidak absen masuk & pulang';
                        elseif(!$p->jam_masuk) $tooltip = 'Lupa absen masuk';
                    }
                  @endphp
                  <span class="badge {{ $badge }}" title="{{ $tooltip }}">
                    {{ strtoupper($p->status) }}
                  </span>
                </td>
                <td class="text-end">
                  @if($p->tanggal == date('Y-m-d') && $p->jam_masuk)
                    <button class="btn btn-outline-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#verifikasiModal{{ $p->id }}">
                      <i class="ti ti-check"></i>
                    </button>
                  @else
                    <span class="text-muted">Locked</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center text-muted">Tidak ada data presensi</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <p class="m-0 text-secondary me-auto">
          Showing {{ $presensi->firstItem() ?? 0 }} to {{ $presensi->lastItem() ?? 0 }} of {{ $presensi->total() ?? 0 }} entries
        </p>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Verifikasi per peserta, taruh di luar table --}}
@foreach($presensi as $p)
<div class="modal fade" id="verifikasiModal{{ $p->id }}" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('pembimbing.verifikasi-presensi.update', $p->id) }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Verifikasi Presensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p class="mb-2">
            <strong>{{ $p->siswa->nama }}</strong><br>
            Tanggal: {{ $p->tanggal }}
          </p>
          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
              <option value="hadir" {{ $p->status=='hadir'?'selected':'' }}>Hadir</option>
              <option value="izin" {{ $p->status=='izin'?'selected':'' }}>Izin</option>
              <option value="sakit" {{ $p->status=='sakit'?'selected':'' }}>Sakit</option>
              <option value="absen" {{ $p->status=='absen'?'selected':'' }}>Absen</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endforeach

<!-- 3. Verifikasi Laporan Harian -->
<div class="mb-3">

  <!-- CARD (TRIGGER MODAL) -->
  <div class="card text-white"
       role="button"
       style="background-color:#6f42c1; cursor:pointer;"
       data-bs-toggle="modal"
       data-bs-target="#verifikasiLaporanModal">
    <div class="card-body d-flex align-items-center">
      <i class="ti ti-file-description me-3" style="font-size:2rem;"></i>
      <h5 class="mb-0">Verifikasi Laporan Harian</h5>
    </div>
  </div>

  <!-- MODAL LIST LAPORAN -->
  <div class="modal fade"
       id="verifikasiLaporanModal"
       tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header text-white" style="background-color:#6f42c1;">
          <h5 class="modal-title">Verifikasi Laporan Harian Peserta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body p-0">
          <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>NISN / NIM</th>
                  <th>Tanggal</th>
                  <th>Ringkasan</th>
                  <th>Screenshot</th>
                  <th>Status</th>
                  <th class="text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>

                @forelse($reports as $index => $r)
                <tr>
                  <td>{{ ($reports->firstItem() ?? 0) + $index }}</td>
                  <td class="fw-semibold">{{ $r->siswa->nama ?? '-' }}</td>
                  <td>{{ $r->siswa->nisn ?? $r->siswa->nim ?? '-' }}</td>
                  <td>{{ $r->tanggal_formatted ?? $r->tanggal }}</td>

                  <td style="max-width:220px">
                    {{ Str::limit($r->ringkasan, 60) }}
                  </td>

                  <td>
                    @if($r->screenshot)
                      <a href="{{ asset('uploads/daily-report/'.$r->screenshot) }}"
                         target="_blank"
                         class="btn btn-outline-secondary btn-sm">
                        Lihat
                      </a>
                    @else
                      <span class="text-muted">-</span>
                    @endif
                  </td>

                  <td>
                    @php
                      $badge = match($r->status_verifikasi) {
                        'terverifikasi' => 'bg-success-soft text-success',
                        'ditolak'       => 'bg-danger-soft text-danger',
                        default         => 'bg-warning-soft text-warning'
                      };
                    @endphp
                    <span class="badge {{ $badge }}">
                      {{ $r->status_verifikasi_label }}
                    </span>
                  </td>

                  <td class="text-end">
                    @can('verify', $r)
                      <button class="btn btn-outline-primary btn-sm"
                              data-bs-toggle="modal"
                              data-bs-target="#verifikasiItem{{ $r->id }}"
                              data-bs-dismiss="modal">
                        <i class="ti ti-check"></i>
                      </button>
                    @else
                      <span class="text-muted">Locked</span>
                    @endcan
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="text-center text-muted">
                    Tidak ada data laporan
                  </td>
                </tr>
                @endforelse

              </tbody>
            </table>
          </div>
        </div>

        <div class="modal-footer">
          <p class="text-secondary me-auto m-0">
            Showing {{ $reports->firstItem() ?? 0 }}
            to {{ $reports->lastItem() ?? 0 }}
            of {{ $reports->total() ?? 0 }} entries
          </p>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
        </div>

      </div>
    </div>
  </div>
</div>
@foreach($reports as $r)
@can('verify', $r)
<div class="modal fade"
     id="verifikasiItem{{ $r->id }}"
     tabindex="-1"
     data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <form method="POST"
          action="{{ route('pembimbing.verifikasi-laporan.update', $r->id) }}">
      @csrf
      @method('PUT')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Verifikasi Laporan Harian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <p>
            <strong>
              {{ $r->siswa->nama ?? '-' }}
              ({{ $r->siswa->nisn ?? $r->siswa->nim ?? '-' }})
            </strong><br>
            Tanggal: {{ $r->tanggal }}
          </p>

          <div class="mb-3">
            <label class="form-label">Ringkasan</label>
            <div class="form-control bg-light">
              {{ $r->ringkasan }}
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Kendala</label>
            <div class="form-control bg-light">
              {{ $r->kendala ?? '-' }}
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status_verifikasi" class="form-select" required>
              <option value="">-- Pilih --</option>
              <option value="terverifikasi">Terverifikasi</option>
              <option value="ditolak">Ditolak</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-primary">
            Simpan
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endcan
@endforeach


      <!-- 4. Lihat Rekap Peserta -->
      <div>
        <div class="card text-white bg-primary">
          <div class="card-body d-flex align-items-center">
            <i class="ti ti-chart-bar me-3" style="font-size: 2rem;"></i>
            <h5 class="mb-0">Lihat Rekap Peserta</h5>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


            </div>
          </div>
        </div>
@endsection
