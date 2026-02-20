<!-- Modal Create Role -->
<div class="modal fade" id="modalCreateRole" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.roles.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Role Name -->
          <div class="col-12 col-md-6">
            <label class="form-label">Role Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter role name" required>
          </div>

          <!-- Description -->
          <div class="col-12 col-md-6">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control" placeholder="Optional description">
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Create Role</button>
      </div>

    </form>
  </div>
</div>
