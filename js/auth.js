document.addEventListener('DOMContentLoaded', () => {
  // Toggle password visibility (login)
  const togglePassword = document.getElementById('togglePassword');
  if (togglePassword) {
    togglePassword.addEventListener('click', function() {
      const pwd = document.getElementById('password');
      const isText = pwd.type === 'text';
      pwd.type = isText ? 'password' : 'text';
      this.className = isText ? 'fa-solid fa-eye password-toggle' : 'fa-solid fa-eye-slash password-toggle';
    });
  }

  // Login form handling
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
      e.preventDefault();
      handleLogin();
    });
  }

  function handleLogin() {
    const emailEl = document.getElementById('email');
    const passwordEl = document.getElementById('password');
    const errorEl = document.getElementById('loginError');
    if (!emailEl || !passwordEl) return;
    const email = emailEl.value;
    const password = passwordEl.value;

    if (!email || !password) {
      if (errorEl) errorEl.style.display = 'flex';
      return;
    }

    if (errorEl) errorEl.style.display = 'none';
    const btn = document.querySelector('.btn-primary-custom');
    if (btn) {
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Signing in…';
      btn.disabled = true;
    }
    loginForm.submit();
  }

  // Toggle password visibility (register)
  const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');
  if (toggleRegisterPassword) {
    toggleRegisterPassword.addEventListener('click', function() {
      const pwd = document.getElementById('registerPassword');
      const isText = pwd.type === 'text';
      pwd.type = isText ? 'password' : 'text';
      this.className = isText ? 'fa-solid fa-eye password-toggle' : 'fa-solid fa-eye-slash password-toggle';
    });
  }

  // Register form handling
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
      e.preventDefault();
      handleRegister();
    });

    // show server-side messages if provided via inline window.serverMessages
    try {
      const msgs = window.serverMessages || {};
      if (msgs.error) {
        const errorEl = document.getElementById('registerError');
        const errorText = document.getElementById('registerErrorText');
        if (errorEl && errorText) {
          errorText.textContent = msgs.error;
          errorEl.style.display = 'flex';
        }
      }
      if (msgs.success) {
        const successEl = document.getElementById('registerSuccess');
        if (successEl) successEl.style.display = 'flex';
      }
    } catch (e) {}
  }

  function handleRegister() {
    const name = (document.getElementById('fullName') || {}).value || '';
    const email = (document.getElementById('registerEmail') || {}).value || '';
    const password = (document.getElementById('registerPassword') || {}).value || '';
    const confirm = (document.getElementById('confirmPassword') || {}).value || '';
    const errorEl = document.getElementById('registerError');
    const errorText = document.getElementById('registerErrorText');
    const successEl = document.getElementById('registerSuccess');
    const btn = document.getElementById('registerBtn');

    if (!name.trim() || !email.trim() || !password || !confirm) {
      if (errorText) errorText.textContent = 'Please complete all fields.';
      if (errorEl) { errorEl.style.display = 'flex'; }
      if (successEl) { successEl.style.display = 'none'; }
      return;
    }

    if (password.length < 6) {
      if (errorText) errorText.textContent = 'Password must be at least 6 characters.';
      if (errorEl) { errorEl.style.display = 'flex'; }
      if (successEl) { successEl.style.display = 'none'; }
      return;
    }

    if (password !== confirm) {
      if (errorText) errorText.textContent = 'Passwords do not match.';
      if (errorEl) { errorEl.style.display = 'flex'; }
      if (successEl) { successEl.style.display = 'none'; }
      return;
    }

    if (errorEl) errorEl.style.display = 'none';
    if (successEl) successEl.style.display = 'flex';
    if (btn) {
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Creating account…';
      btn.disabled = true;
    }

    registerForm.submit();
  }
});
