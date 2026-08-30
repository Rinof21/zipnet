<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login – cariArsip</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: "Inter", sans-serif;
      min-height: 100vh;
      display: flex;
      background: #0f1117;
      overflow: hidden;
    }

    /* ======= LEFT PANEL – Branding ======= */
    .left-panel {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 60px 80px;
      position: relative;
      overflow: hidden;
      background: linear-gradient(135deg, #0f1117 0%, #1a1f2e 60%, #0d2340 100%);
    }

    /* Animated background blobs */
    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: .45;
      animation: float 8s ease-in-out infinite;
    }
    .blob-1 { width: 420px; height: 420px; background: #1a73e8; top: -80px; left: -100px; animation-delay: 0s; }
    .blob-2 { width: 300px; height: 300px; background: #0d47a1; bottom: -60px; right: -60px; animation-delay: -3s; }
    .blob-3 { width: 200px; height: 200px; background: #4285f4; top: 50%; left: 50%; transform: translate(-50%,-50%); animation-delay: -5s; }

    @keyframes float {
      0%, 100% { transform: translateY(0) scale(1); }
      50% { transform: translateY(-20px) scale(1.05); }
    }

    .brand-content { position: relative; z-index: 2; }

    .brand-logo {
      font-size: 52px;
      font-weight: 300;
      color: rgba(255,255,255,.9);
      letter-spacing: -1px;
      margin-bottom: 16px;
      text-decoration: none;
      display: block;
    }
    .brand-logo span { color: #4ca3ff; font-weight: 700; }

    .brand-tagline {
      font-size: 18px;
      color: rgba(255,255,255,.55);
      font-weight: 300;
      line-height: 1.6;
      max-width: 380px;
      margin-bottom: 48px;
    }

    .brand-features { display: flex; flex-direction: column; gap: 16px; }
    .brand-feature {
      display: flex;
      align-items: center;
      gap: 14px;
      color: rgba(255,255,255,.7);
      font-size: 14px;
    }
    .feature-icon {
      width: 36px; height: 36px;
      border-radius: 10px;
      background: rgba(74,163,255,.15);
      border: 1px solid rgba(74,163,255,.25);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      font-size: 16px;
    }

    /* ======= RIGHT PANEL – Form ======= */
    .right-panel {
      width: 460px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: #fff;
      padding: 60px 48px;
      position: relative;
    }

    .form-header { width: 100%; margin-bottom: 32px; }

    .form-back {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      color: #70757a;
      text-decoration: none;
      margin-bottom: 32px;
      transition: color .15s;
    }
    .form-back:hover { color: #1a73e8; }

    .form-title {
      font-size: 28px;
      font-weight: 700;
      color: #202124;
      margin-bottom: 6px;
    }
    .form-subtitle { font-size: 14px; color: #70757a; }
    .form-subtitle strong { color: #1a73e8; }

    /* Alert session status */
    .alert-success {
      background: #e8f5e9;
      border: 1px solid #a5d6a7;
      color: #2e7d32;
      border-radius: 10px;
      padding: 12px 16px;
      font-size: 13px;
      margin-bottom: 20px;
      width: 100%;
    }

    /* Form fields */
    .form-group { margin-bottom: 20px; width: 100%; }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 500;
      color: #3c4043;
      margin-bottom: 7px;
    }

    .input-wrap { position: relative; }
    .input-icon {
      position: absolute;
      left: 14px; top: 50%;
      transform: translateY(-50%);
      color: #9aa0a6;
      pointer-events: none;
    }

    .form-input {
      width: 100%;
      border: 1.5px solid #dadce0;
      border-radius: 10px;
      padding: 12px 14px 12px 42px;
      font-size: 15px;
      font-family: "Inter", sans-serif;
      color: #202124;
      background: #fff;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-input:focus {
      border-color: #1a73e8;
      box-shadow: 0 0 0 3px rgba(26,115,232,.12);
    }
    .form-input.is-error { border-color: #d93025; }
    .form-input.is-error:focus { box-shadow: 0 0 0 3px rgba(217,48,37,.12); }

    .toggle-password {
      position: absolute;
      right: 14px; top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: #9aa0a6;
      padding: 0;
      line-height: 0;
      transition: color .15s;
    }
    .toggle-password:hover { color: #5f6368; }

    .field-error {
      font-size: 12px;
      color: #d93025;
      margin-top: 6px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    /* Remember + Forgot */
    .form-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
      width: 100%;
    }

    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: #5f6368;
      cursor: pointer;
      user-select: none;
    }

    .checkbox-custom {
      width: 18px; height: 18px;
      border: 1.5px solid #dadce0;
      border-radius: 5px;
      background: #fff;
      display: flex; align-items: center; justify-content: center;
      transition: border-color .15s, background .15s;
      flex-shrink: 0;
    }
    input[type=checkbox]:checked + .checkbox-custom {
      background: #1a73e8;
      border-color: #1a73e8;
    }
    input[type=checkbox] { display: none; }

    .forgot-link {
      font-size: 13px;
      color: #1a73e8;
      text-decoration: none;
      font-weight: 500;
      transition: color .15s;
    }
    .forgot-link:hover { color: #1557b0; text-decoration: underline; }

    /* Submit button */
    .submit-btn {
      width: 100%;
      background: #1a73e8;
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: 13px;
      font-size: 15px;
      font-weight: 600;
      font-family: "Inter", sans-serif;
      cursor: pointer;
      transition: background .2s, box-shadow .2s, transform .1s;
      position: relative;
      overflow: hidden;
    }
    .submit-btn:hover { background: #1557b0; box-shadow: 0 4px 16px rgba(26,115,232,.4); }
    .submit-btn:active { transform: scale(.99); }

    .submit-btn::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(255,255,255,.12) 0%, transparent 100%);
    }

    /* Back to search */
    .back-to-search {
      margin-top: 28px;
      text-align: center;
      font-size: 13px;
      color: #70757a;
      width: 100%;
    }
    .back-to-search a { color: #1a73e8; text-decoration: none; font-weight: 500; }
    .back-to-search a:hover { text-decoration: underline; }

    /* Divider */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 24px 0;
      width: 100%;
      color: #bdc1c6;
      font-size: 12px;
    }
    .divider::before, .divider::after {
      content: ""; flex: 1; height: 1px; background: #e8eaed;
    }

    /* Responsive */
    @media (max-width: 900px) {
      body { overflow-y: auto; overflow-x: hidden; min-height: 100vh; }
      .left-panel { display: none; }
      .right-panel { width: 100%; min-height: 100vh; padding: 32px 20px; justify-content: center; }
      .form-title { font-size: 24px; }
    }
  </style>
</head>
<body>

  <!-- Left Panel -->
  <div class="left-panel">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <div class="brand-content">
      <a href="{{ route('public.search') }}" class="brand-logo">cari<span>Arsip</span></a>
      <p class="brand-tagline">
        Sistem pencarian arsip dokumen surat digital untuk civitas akademika Fakultas Kedokteran.
      </p>
      <div class="brand-features">
        <div class="brand-feature">
          <div class="feature-icon">🔍</div>
          <span>Cari arsip dengan cepat berdasarkan judul, nomor, atau perihal surat</span>
        </div>
        <div class="brand-feature">
          <div class="feature-icon">📄</div>
          <span>Preview dokumen PDF langsung tanpa unduh</span>
        </div>
        <div class="brand-feature">
          <div class="feature-icon">🔒</div>
          <span>Kelola dan unggah arsip secara aman dengan akun terverifikasi</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Right Panel -->
  <div class="right-panel">

    <div class="form-header" style="width:100%">
      <a href="{{ route('public.search') }}" class="form-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
        Kembali ke cariArsip
      </a>
      <div class="form-title">Selamat Datang</div>
      <div class="form-subtitle">Masuk untuk mengelola <strong>arsip dokumen</strong></div>
    </div>

    <!-- Session Status -->
    @if(session('status'))
      <div class="alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" style="width:100%">
      @csrf

      <!-- Email -->
      <div class="form-group">
        <label for="email" class="form-label">Alamat Email</label>
        <div class="input-wrap">
          <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
          <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
            placeholder="nama@email.com"
            required
            autofocus
            autocomplete="username"
          >
        </div>
        @error('email')
          <div class="field-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="password" class="form-label">Kata Sandi</label>
        <div class="input-wrap">
          <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          <input
            id="password"
            type="password"
            name="password"
            class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
            placeholder="••••••••"
            required
            autocomplete="current-password"
          >
          <button type="button" class="toggle-password" id="togglePwd" aria-label="Tampilkan kata sandi">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
        @error('password')
          <div class="field-error">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Remember + Forgot -->
      <div class="form-row">
        <label class="checkbox-label">
          <input type="checkbox" name="remember" id="remember_me">
          <div class="checkbox-custom">
            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          Ingat saya
        </label>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="forgot-link">Lupa kata sandi?</a>
        @endif
      </div>

      <button type="submit" class="submit-btn" id="loginBtn">
        Masuk
      </button>
    </form>

    <div class="back-to-search">
      Bukan admin? <a href="{{ route('public.search') }}">Cari arsip tanpa login</a>
    </div>
  </div>

  <script>
    // Toggle password visibility
    const toggleBtn = document.getElementById('togglePwd');
    const pwdInput  = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');

    const eyeOpen = `<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/>`;
    const eyeOff  = `<path d="M10.733 5.076a10.744 10.744 0 0 1 11.205 6.575 1 1 0 0 1 0 .696 10.747 10.747 0 0 1-1.444 2.49"/><path d="M14.084 14.158a3 3 0 0 1-4.242-4.242"/><path d="M17.479 17.499a10.75 10.75 0 0 1-15.417-5.151 1 1 0 0 1 0-.696 10.75 10.75 0 0 1 4.446-5.143"/><path d="m2 2 20 20"/>`;

    if (toggleBtn) {
      toggleBtn.addEventListener('click', () => {
        const isPassword = pwdInput.type === 'password';
        pwdInput.type = isPassword ? 'text' : 'password';
        eyeIcon.innerHTML = isPassword ? eyeOff : eyeOpen;
      });
    }

    // Loading state on submit
    const form = document.querySelector('form');
    const loginBtn = document.getElementById('loginBtn');
    if (form && loginBtn) {
      form.addEventListener('submit', () => {
        loginBtn.textContent = 'Memproses...';
        loginBtn.disabled = true;
        loginBtn.style.opacity = '.8';
      });
    }
  </script>

</body>
</html>
