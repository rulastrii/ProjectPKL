<!-- Modal Create User -->
<div class="modal modal-blur fade" id="modalCreateUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form action="{{ route('admin.users.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <!-- Name -->
          <div class="col-12 col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter full name" value="{{ old('name') }}" required>
          </div>

          <!-- Email -->
          <div class="col-12 col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="your@email.com" value="{{ old('email') }}" required>
          </div>

          <!-- Password -->
          <div class="col-12 col-md-6">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
              <input type="password" name="password" id="password" class="form-control" placeholder="Create password" required>
              <span class="input-group-text">
                <a href="javascript:void(0)" id="togglePassword" class="link-secondary" title="Show password">
                  <!-- Eye -->
                  <svg id="icon-eye" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                  </svg>
                  <svg id="icon-eye-off" style="display:none;" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 3l18 18"/>
                    <path d="M10.584 10.587a2 2 0 0 0 2.829 2.828"/>
                    <path d="M9.88 4.12c.66 -.075 1.34 -.12 2.12 -.12c3.6 0 6.6 2 9 6c-.563 .938 -1.166 1.773 -1.805 2.5m-2.527 2.177c-1.47 .92 -3.11 1.403 -4.668 1.323c-3.217 -.187 -5.969 -2.26 -7.999 -5.999c.538 -.938 1.143 -1.773 1.805 -2.5"/>
                  </svg>
                </a>
              </span>
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="col-12 col-md-6">
            <label class="form-label">Confirm Password</label>
            <div class="input-group input-group-flat">
              <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Repeat password" required>
              <span class="input-group-text">
                <a href="javascript:void(0)" id="toggleConfirmPassword" class="link-secondary" title="Show password">
                  <!-- Eye -->
                  <svg id="confirm-eye" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                  </svg>
                  <svg id="confirm-eye-off" style="display:none;" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M3 3l18 18"/>
                    <path d="M10.584 10.587a2 2 0 0 0 2.829 2.828"/>
                    <path d="M9.88 4.12c.66 -.075 1.34 -.12 2.12 -.12c3.6 0 6.6 2 9 6c-.563 .938 -1.166 1.773 -1.805 2.5m-2.527 2.177c-1.47 .92 -3.11 1.403 -4.668 1.323c-3.217 -.187 -5.969 -2.26 -7.999 -5.999c.538 -.938 1.143 -1.773 1.805 -2.5"/>
                  </svg>
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
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                  {{ $role->name }}
                </option>
              @endforeach
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Create User</button>
      </div>
    </form>
  </div>
</div>

<!-- Eye toggle JS khusus modal -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle Password
    document.getElementById('togglePassword').addEventListener('click', function(){
        const input = document.getElementById('password');
        const eye = document.getElementById('icon-eye');
        const eyeOff = document.getElementById('icon-eye-off');
        if(input.type === 'password'){
            input.type = 'text';
            eye.style.display = 'none';
            eyeOff.style.display = 'block';
        } else {
            input.type = 'password';
            eye.style.display = 'block';
            eyeOff.style.display = 'none';
        }
    });

    // Toggle Confirm Password
    document.getElementById('toggleConfirmPassword').addEventListener('click', function(){
        const input = document.getElementById('password_confirmation');
        const eye = document.getElementById('confirm-eye');
        const eyeOff = document.getElementById('confirm-eye-off');
        if(input.type === 'password'){
            input.type = 'text';
            eye.style.display = 'none';
            eyeOff.style.display = 'block';
        } else {
            input.type = 'password';
            eye.style.display = 'block';
            eyeOff.style.display = 'none';
        }
    });
});
</script>
