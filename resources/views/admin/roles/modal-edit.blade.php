@foreach($roles as $role)
<!-- Modal Edit Role -->
<div class="modal fade" id="modalEditRole-{{ $role->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Role: {{ $role->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Name -->
          <div class="col-12 col-md-6">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
          </div>

          <!-- Description -->
          <div class="col-12 col-md-6">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" value="{{ $role->description }}">
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Update Role</button>
      </div>

    </form>
  </div>
</div>
@endforeach
