<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Akses Terproteksi PIN – cariArsip</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: "Inter", sans-serif;
      background: #0f1117;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }

    .pin-container {
      width: 100%;
      max-width: 420px;
      background: #1a2340;
      border: 1px solid rgba(255,255,255,.1);
      border-radius: 20px;
      padding: 36px 30px;
      box-shadow: 0 20px 50px rgba(0,0,0,.4);
      text-align: center;
    }

    .brand-logo {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-size: 22px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 24px;
      text-decoration: none;
    }
    .brand-logo span { color: #4ca3ff; }
    .brand-icon {
      width: 40px; height: 40px;
      background: #1a73e8;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px;
    }

    .lock-icon-wrap {
      width: 64px; height: 64px;
      border-radius: 50%;
      background: rgba(26,115,232,.15);
      border: 2px solid rgba(26,115,232,.3);
      color: #4ca3ff;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 20px;
    }

    .pin-title {
      font-size: 19px;
      font-weight: 700;
      color: #fff;
      margin-bottom: 8px;
    }

    .pin-sub {
      font-size: 13.5px;
      color: rgba(255,255,255,.65);
      line-height: 1.5;
      margin-bottom: 26px;
    }

    .pin-form {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .pin-input-group {
      position: relative;
    }

    .pin-input {
      width: 100%;
      background: rgba(255,255,255,.06);
      border: 1.5px solid rgba(255,255,255,.15);
      border-radius: 12px;
      padding: 14px 46px 14px 16px;
      font-size: 18px;
      font-family: monospace, sans-serif;
      letter-spacing: 4px;
      color: #fff;
      text-align: center;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .pin-input:focus {
      border-color: #4ca3ff;
      box-shadow: 0 0 0 3px rgba(76,163,255,.2);
      background: rgba(255,255,255,.09);
    }
    .pin-input::placeholder {
      letter-spacing: normal;
      font-size: 13.5px;
      font-family: "Inter", sans-serif;
      color: rgba(255,255,255,.35);
    }

    .toggle-pwd {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: rgba(255,255,255,.5);
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .toggle-pwd:hover { color: #fff; }

    .btn-submit {
      width: 100%;
      background: #1a73e8;
      color: #fff;
      border: none;
      border-radius: 12px;
      padding: 14px;
      font-size: 14px;
      font-weight: 600;
      font-family: "Inter", sans-serif;
      cursor: pointer;
      transition: background .2s, transform .1s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-submit:hover { background: #1557b0; }
    .btn-submit:active { transform: scale(.99); }

    .alert-error {
      background: rgba(217,48,37,.15);
      border: 1px solid rgba(217,48,37,.3);
      color: #ff6b6b;
      border-radius: 10px;
      padding: 11px 14px;
      font-size: 13px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 8px;
      text-align: left;
    }

    .login-link {
      margin-top: 24px;
      font-size: 12.5px;
      color: rgba(255,255,255,.5);
    }
    .login-link a {
      color: #4ca3ff;
      text-decoration: none;
      font-weight: 500;
    }
    .login-link a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <div class="pin-container">
    <div class="brand-logo">
      <div class="brand-icon">📁</div>
      <div>cari<span>Arsip</span></div>
    </div>

    <div class="lock-icon-wrap">
      <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    </div>

    <h1 class="pin-title">Akses Publik Terproteksi</h1>
    <p class="pin-sub">Masukkan PIN keamanan untuk mengakses pencarian dan arsip dokumen publik.</p>

    @if ($errors->any())
      <div class="alert-error">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <span>{{ $errors->first('pin') }}</span>
      </div>
    @endif

    <form action="{{ route('public.pin.verify') }}" method="POST" class="pin-form">
      @csrf

      <div class="pin-input-group">
        <input type="password" name="pin" id="pinInput" class="pin-input" placeholder="Masukkan PIN" required autofocus autocomplete="off">
        <button type="button" class="toggle-pwd" id="togglePin" title="Tampilkan PIN">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
        </button>
      </div>

      <button type="submit" class="btn-submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
        Buka Akses Publik
      </button>
    </form>

    <div class="login-link">
      Pengelola Sistem? <a href="{{ route('login') }}">Login Pengelola</a>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('togglePin');
    const pinInput  = document.getElementById('pinInput');
    if (toggleBtn && pinInput) {
      toggleBtn.addEventListener('click', () => {
        const type = pinInput.getAttribute('type') === 'password' ? 'text' : 'password';
        pinInput.setAttribute('type', type);
      });
    }
  </script>
</body>
</html>
