@foreach($users as $user)
<!-- Modal Edit User -->
<div class="modal fade" id="modalEditUser-{{ $user->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit User: {{ $user->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Name -->
          <div class="col-12 col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
          </div>

          <!-- Email -->
          <div class="col-12 col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
          </div>

          <!-- Password -->
          <div class="col-12 col-md-6">
            <label class="form-label">Password <small class="text-muted">(leave blank if not change)</small></label>
            <div class="input-group input-group-flat">
              <input type="password" name="password" class="form-control" id="password-{{ $user->id }}" placeholder="New password">
              <span class="input-group-text">
                <a href="javascript:void(0)" class="link-secondary" id="togglePassword-{{ $user->id }}">
                  <i class="ti ti-eye" id="icon-eye-{{ $user->id }}"></i>
                  <i class="ti ti-eye-off" id="icon-eye-off-{{ $user->id }}" style="display:none;"></i>
                </a>
              </span>
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="col-12 col-md-6">
            <label class="form-label">Confirm Password</label>
            <div class="input-group input-group-flat">
              <input type="password" name="password_confirmation" class="form-control" id="password_confirmation-{{ $user->id }}" placeholder="Repeat new password">
              <span class="input-group-text">
                <a href="javascript:void(0)" class="link-secondary" id="toggleConfirm-{{ $user->id }}">
                  <i class="ti ti-eye" id="confirm-eye-{{ $user->id }}"></i>
                  <i class="ti ti-eye-off" id="confirm-eye-off-{{ $user->id }}" style="display:none;"></i>
                </a>
              </span>
            </div>
          </div>

          <!-- Role -->
          <div class="col-12 col-md-6">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-select">
              <option value="">-- Select Role --</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                  {{ $role->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $user->is_active ? 'selected':'' }}>Active</option>
              <option value="0" {{ !$user->is_active ? 'selected':'' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Update User</button>
      </div>

    </form>
  </div>
</div>

<!-- Eye Toggle JS -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Password toggle
    const togglePass{{ $user->id }} = document.getElementById('togglePassword-{{ $user->id }}');
    const passInput{{ $user->id }} = document.getElementById('password-{{ $user->id }}');
    const eye{{ $user->id }} = document.getElementById('icon-eye-{{ $user->id }}');
    const eyeOff{{ $user->id }} = document.getElementById('icon-eye-off-{{ $user->id }}');

    togglePass{{ $user->id }}.addEventListener('click', function() {
        if(passInput{{ $user->id }}.type === 'password'){
            passInput{{ $user->id }}.type = 'text';
            eye{{ $user->id }}.style.display = 'none';
            eyeOff{{ $user->id }}.style.display = 'block';
        } else {
            passInput{{ $user->id }}.type = 'password';
            eye{{ $user->id }}.style.display = 'block';
            eyeOff{{ $user->id }}.style.display = 'none';
        }
    });

    // Confirm password toggle
    const toggleConfirm{{ $user->id }} = document.getElementById('toggleConfirm-{{ $user->id }}');
    const confirmInput{{ $user->id }} = document.getElementById('password_confirmation-{{ $user->id }}');
    const confirmEye{{ $user->id }} = document.getElementById('confirm-eye-{{ $user->id }}');
    const confirmEyeOff{{ $user->id }} = document.getElementById('confirm-eye-off-{{ $user->id }}');

    toggleConfirm{{ $user->id }}.addEventListener('click', function() {
        if(confirmInput{{ $user->id }}.type === 'password'){
            confirmInput{{ $user->id }}.type = 'text';
            confirmEye{{ $user->id }}.style.display = 'none';
            confirmEyeOff{{ $user->id }}.style.display = 'block';
        } else {
            confirmInput{{ $user->id }}.type = 'password';
            confirmEye{{ $user->id }}.style.display = 'block';
            confirmEyeOff{{ $user->id }}.style.display = 'none';
        }
    });
});
</script>
@endforeach
