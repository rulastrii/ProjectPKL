@foreach($users as $user)
<div class="modal modal-blur fade" id="modalShowUser-{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">

                            <!-- Left Side -->
                            <div class="col-md-6">
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <div class="text-body">Email: <strong>{{ $user->email }}</strong></div>
                                <div class="mt-2">Role: <strong>{{ $user->role->name ?? '-' }}</strong></div>
                                <div class="mt-3">
                                    @if($user->is_active)
                                        <span class="badge bg-success-soft text-success">Active</span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger">Inactive</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Right Side -->
                            <div class="col-md-6 text-md-end">
                                <div><strong>Dibuat:</strong></div>
                                <div>{{ $user->created_date ? $user->created_date->format('d M Y H:i') : '-' }}</div>

                                <div class="mt-2"><strong>Terakhir Update:</strong></div>
                                <div>{{ $user->updated_date ? $user->updated_date->format('d M Y H:i') : '-' }}</div>

                                <div class="mt-2"><strong>Dihapus:</strong></div>
                                <div>{{ $user->deleted_date ? $user->deleted_date->format('d M Y H:i') : '-' }}</div>
                            </div>

                            <div class="col-12">
                                <div class="hr-text">Informasi Pengguna Lainnya</div>
                            </div>

                            <!-- User Pembuat -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">User Pembuat</label>
                                <div class="text-body">
                                    @if($user->creator)
                                        <strong>{{ $user->creator->name }}</strong> –
                                        Sebagai <strong>{{ strtoupper($user->creator->role->name ?? '-') }}</strong><br>
                                        <span class="text-muted">{{ $user->creator->email }}</span>
                                    @else
                                        <span class="badge text-secondary">
                                            Daftar Mandiri (Guru)
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <!-- User Pengubah -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">User Pengubah</label>
                                <div class="text-body">
                                    @if($user->updater)
                                        <strong>{{ $user->updater->name }}</strong> – 
                                        Sebagai <strong>{{ strtoupper($user->updater->role->name ?? '-') }}</strong><br>
                                        <span class="text-body">{{ $user->updater->email }}</span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                            <!-- User Penghapus -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">User Penghapus</label>
                                <div class="text-body">
                                    @if($user->deleter)
                                        <strong>{{ $user->deleter->name }}</strong> – 
                                        Sebagai <strong>{{ strtoupper($user->deleter->role->name ?? '-') }}</strong><br>
                                        <span class="text-body">{{ $user->deleter->email }}</span>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endforeach
