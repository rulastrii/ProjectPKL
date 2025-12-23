<!-- Modal Create User Pegawai -->
<div class="modal modal-blur fade"
     id="modalCreateUser-{{ $pegawai->id }}"
     tabindex="-1"
     aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.pegawai.store-user', $pegawai->id) }}"
          method="POST"
          class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Buat Akun Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Nama Pegawai -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama Pegawai</label>
            <input type="text"
                   id="name-{{ $pegawai->id }}"
                   class="form-control"
                   value="{{ $pegawai->nama }}"
                   readonly>

            <input type="hidden" name="name" value="{{ $pegawai->nama }}">
          </div>

          <!-- Email -->
          <div class="col-12 col-md-6">
            <label class="form-label">Email</label>
            <input type="email"
                   name="email"
                   class="form-control" placeholder="your@email.com"
                   required>
          </div>

          <!-- Password -->
          <div class="col-12 col-md-6">
            <label class="form-label">Password</label>
            <div class="input-group input-group-flat">
              <input type="password"
                     name="password"
                     id="password-{{ $pegawai->id }}"
                     class="form-control"
                     readonly
                     required>

              <span class="input-group-text">
  <a href="javascript:void(0)"
     onclick="togglePassword({{ $pegawai->id }})"
     class="link-secondary"
     title="Show password">

    {{-- eye --}}
    <svg id="eye-{{ $pegawai->id }}"
         xmlns="http://www.w3.org/2000/svg"
         class="icon"
         width="20"
         height="20"
         viewBox="0 0 24 24"
         stroke-width="2"
         stroke="currentColor"
         fill="none"
         stroke-linecap="round"
         stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
      <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
    </svg>

    {{-- eye-off --}}
    <svg id="eye-off-{{ $pegawai->id }}"
         xmlns="http://www.w3.org/2000/svg"
         class="icon"
         width="20"
         height="20"
         viewBox="0 0 24 24"
         stroke-width="2"
         stroke="currentColor"
         fill="none"
         stroke-linecap="round"
         stroke-linejoin="round"
         style="display:none">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M3 3l18 18"/>
      <path d="M10.584 10.587a2 2 0 0 0 2.829 2.828"/>
      <path d="M9.88 4.12c.66 -.075 1.34 -.12 2.12 -.12c3.6 0 6.6 2 9 6"/>
      <path d="M6.12 6.12c-1.47 .92 -2.77 2.2 -3.88 3.88c2.4 4 5.4 6 9 6"/>
    </svg>

  </a>
</span>

            </div>
          </div>

          <!-- Confirm Password -->
          <div class="col-12 col-md-6">
            <label class="form-label">Confirm Password</label>
            <div class="input-group input-group-flat">
              <input type="password"
                     name="password_confirmation"
                     id="confirm-{{ $pegawai->id }}"
                     class="form-control"
                     readonly
                     required>

              <span class="input-group-text">
  <a href="javascript:void(0)"
     onclick="toggleConfirm({{ $pegawai->id }})"
     class="link-secondary"
     title="Show password">

    {{-- Eye (show) --}}
    <svg id="confirm-eye-{{ $pegawai->id }}"
         xmlns="http://www.w3.org/2000/svg"
         class="icon"
         width="20"
         height="20"
         viewBox="0 0 24 24"
         stroke-width="2"
         stroke="currentColor"
         fill="none"
         stroke-linecap="round"
         stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
      <path d="M21 12c-2.4 4 -5.4 6 -9 6
               c-3.6 0 -6.6 -2 -9 -6
               c2.4 -4 5.4 -6 9 -6
               c3.6 0 6.6 2 9 6"/>
    </svg>

    {{-- Eye Off (hide) --}}
    <svg id="confirm-eye-off-{{ $pegawai->id }}"
         xmlns="http://www.w3.org/2000/svg"
         class="icon"
         width="20"
         height="20"
         viewBox="0 0 24 24"
         stroke-width="2"
         stroke="currentColor"
         fill="none"
         stroke-linecap="round"
         stroke-linejoin="round"
         style="display:none">
      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
      <path d="M3 3l18 18"/>
      <path d="M10.584 10.587a2 2 0 0 0 2.829 2.828"/>
      <path d="M9.88 4.12c.66 -.075 1.34 -.12 2.12 -.12
               c3.6 0 6.6 2 9 6"/>
      <path d="M6.12 6.12
               c-1.47 .92 -2.77 2.2 -3.88 3.88
               c2.4 4 5.4 6 9 6"/>
    </svg>

  </a>
</span>


            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button"
                class="btn btn-outline-info"
                onclick="generatePasswordPegawai({{ $pegawai->id }})">
          Generate Password
        </button>

        <button type="submit" class="btn btn-primary ms-auto">
          Buat Akun
        </button>
      </div>
    </form>
  </div>
</div>
<script>
function generatePasswordPegawai(id) {
    const name = document
        .getElementById('name-' + id)
        .value
        .trim()
        .split(' ')[0]
        .toLowerCase();

    const random = Math.floor(100000 + Math.random() * 900000);
    const password = name + random;

    document.getElementById('password-' + id).value = password;
    document.getElementById('confirm-' + id).value  = password;
}

function togglePassword(id) {
    const input = document.getElementById('password-' + id);
    const eye = document.getElementById('eye-' + id);
    const eyeOff = document.getElementById('eye-off-' + id);

    if (input.type === 'password') {
        input.type = 'text';
        eye.style.display = 'none';
        eyeOff.style.display = 'block';
    } else {
        input.type = 'password';
        eye.style.display = 'block';
        eyeOff.style.display = 'none';
    }
}

function toggleConfirm(id) {
    const input  = document.getElementById('confirm-' + id);
    const eye    = document.getElementById('confirm-eye-' + id);
    const eyeOff = document.getElementById('confirm-eye-off-' + id);

    if (input.type === 'password') {
        input.type = 'text';
        eye.style.display = 'none';
        eyeOff.style.display = 'block';
    } else {
        input.type = 'password';
        eye.style.display = 'block';
        eyeOff.style.display = 'none';
    }
}


// auto-generate saat modal dibuka
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id^="modalCreateUser-"]').forEach(modal => {
        modal.addEventListener('shown.bs.modal', function () {
            const id = this.id.split('-').pop();
            generatePasswordPegawai(id);
        });
    });
});
</script>
