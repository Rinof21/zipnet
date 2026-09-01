<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') – cariArsip</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  @stack('styles')
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --sidebar-w: 240px;
      --topbar-h: 60px;
      --blue: #1a73e8;
      --blue-dark: #1557b0;
      --blue-light: #e8f0fe;
      --text: #202124;
      --text-muted: #5f6368;
      --border: #e8eaed;
      --bg: #f1f3f4;
      --white: #ffffff;
      --sidebar-bg: #0f1117;
      --sidebar-text: rgba(255,255,255,.75);
      --sidebar-text-hover: #ffffff;
      --sidebar-active: rgba(26,115,232,.2);
      --radius: 12px;
    }

    body {
      font-family: "Inter", sans-serif;
      background: var(--bg);
      color: var(--text);
      display: flex;
      min-height: 100vh;
      max-width: 100vw;
      overflow-x: hidden;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
      width: var(--sidebar-w);
      min-height: 100vh;
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      position: fixed;
      top: 0; left: 0; bottom: 0;
      z-index: 200;
      transition: transform .3s ease;
    }

    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 20px 20px 16px;
      text-decoration: none;
      border-bottom: 1px solid rgba(255,255,255,.08);
      margin-bottom: 8px;
    }
    .sidebar-brand-icon {
      width: 36px; height: 36px;
      background: var(--blue);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 16px;
      flex-shrink: 0;
    }
    .sidebar-brand-text {
      font-size: 18px;
      font-weight: 700;
      color: var(--white);
      letter-spacing: -.3px;
    }
    .sidebar-brand-text span { color: #4ca3ff; }

    .sidebar-label {
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: rgba(255,255,255,.3);
      padding: 12px 20px 6px;
    }

    .sidebar-nav { flex: 1; padding: 4px 12px; }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 12px;
      border-radius: 8px;
      color: var(--sidebar-text);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 2px;
      transition: background .15s, color .15s;
    }
    .nav-item:hover {
      background: rgba(255,255,255,.07);
      color: var(--sidebar-text-hover);
    }
    .nav-item.active {
      background: var(--sidebar-active);
      color: #4ca3ff;
    }
    .nav-item svg { flex-shrink: 0; opacity: .75; }
    .nav-item.active svg, .nav-item:hover svg { opacity: 1; }

    .sidebar-footer {
      padding: 16px 12px;
      border-top: 1px solid rgba(255,255,255,.08);
    }
    .sidebar-user {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 12px;
      border-radius: 8px;
      cursor: pointer;
      transition: background .15s;
      position: relative;
    }
    .sidebar-user:hover { background: rgba(255,255,255,.07); }

    .avatar {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--blue), #4ca3ff);
      display: flex; align-items: center; justify-content: center;
      font-size: 13px;
      font-weight: 700;
      color: #fff;
      flex-shrink: 0;
    }
    .avatar-info { flex: 1; min-width: 0; }
    .avatar-name {
      font-size: 13px;
      font-weight: 600;
      color: var(--white);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .avatar-role { font-size: 11px; color: rgba(255,255,255,.4); }

    .user-menu {
      position: absolute;
      bottom: calc(100% + 8px);
      left: 0; right: 0;
      background: #1e2130;
      border: 1px solid rgba(255,255,255,.1);
      border-radius: 10px;
      overflow: hidden;
      display: none;
      z-index: 300;
    }
    .user-menu.open { display: block; }
    .user-menu-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 11px 14px;
      font-size: 13px;
      color: rgba(255,255,255,.7);
      text-decoration: none;
      transition: background .12s, color .12s;
      cursor: pointer;
      background: none;
      border: none;
      width: 100%;
      font-family: "Inter", sans-serif;
    }
    .user-menu-item:hover { background: rgba(255,255,255,.07); color: #fff; }
    .user-menu-item.danger:hover { background: rgba(217,48,37,.15); color: #ff6b6b; }

    /* ===== MAIN CONTENT ===== */
    .main-wrap {
      margin-left: var(--sidebar-w);
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      min-width: 0;
      max-width: 100%;
    }

    /* Topbar */
    .topbar {
      height: var(--topbar-h);
      background: var(--white);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 28px;
      gap: 16px;
      position: sticky;
      top: 0;
      z-index: 100;
      max-width: 100%;
    }

    .topbar-title {
      font-size: 16px;
      font-weight: 600;
      color: var(--text);
      flex: 1;
    }

    .topbar-actions { display: flex; align-items: center; gap: 10px; }

    .topbar-btn {
      width: 36px; height: 36px;
      border-radius: 50%;
      border: none;
      background: transparent;
      cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      color: var(--text-muted);
      transition: background .15s;
    }
    .topbar-btn:hover { background: var(--bg); }

    .topbar-user {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 5px 12px 5px 5px;
      border-radius: 24px;
      border: 1px solid var(--border);
      cursor: pointer;
      transition: background .15s;
      font-size: 13px;
      font-weight: 500;
      color: var(--text);
      text-decoration: none;
    }
    .topbar-user:hover { background: var(--bg); }
    .topbar-avatar {
      width: 28px; height: 28px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--blue), #4ca3ff);
      display: flex; align-items: center; justify-content: center;
      font-size: 10.5px; font-weight: 600; color: #fff;
    }

    /* Page content */
    .page-content {
      padding: 28px;
      flex: 1;
      min-width: 0;
      max-width: 100%;
      box-sizing: border-box;
    }

    /* ===== Bootstrap modal fix (standalone) ===== */
    .modal-backdrop { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1040; display: none; }
    .modal-backdrop.show { display: block; }
    .modal { display: none; position: fixed; inset: 0; z-index: 1050; overflow-y: auto; padding: 40px 16px; }
    .modal.show { display: flex; align-items: flex-start; justify-content: center; }
    .modal-dialog { width: 100%; max-width: 700px; }
    .modal-content { background: #fff; border-radius: var(--radius); overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
    .modal-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; background: var(--blue); color: #fff; }
    .modal-title { font-size: 15px; font-weight: 600; }
    .modal-body { padding: 24px; }
    .btn-close-white { background: none; border: none; color: #fff; cursor: pointer; font-size: 18px; line-height: 1; padding: 0; }

    /* Table */
    .table-modern { width: 100%; border-collapse: collapse; font-size: 14px; }
    .table-modern thead tr { background: #f8f9fa; }
    .table-modern th { padding: 11px 16px; text-align: left; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: .5px; color: var(--text-muted); border-bottom: 1px solid var(--border); }
    .table-modern td { padding: 12px 16px; border-bottom: 1px solid #f5f5f5; color: var(--text); }
    .table-modern tbody tr:hover { background: #fafafa; }
    .table-modern tbody tr:last-child td { border-bottom: none; }

    /* Responsive table wrapper */
    .table-responsive {
      width: 100%;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      border-radius: var(--radius);
    }

    /* Responsive */
    @media (max-width: 768px) {
      #sidebarToggle { display: flex !important; }
      .sidebar { transform: translateX(-100%); z-index: 1060; }
      .sidebar.open { transform: translateX(0); }
      .main-wrap { margin-left: 0; }
      .topbar { padding: 0 14px; gap: 10px; }
      .page-content { padding: 16px 12px; }
      .topbar-user-name { display: none; }
      .topbar-public-text { display: none; }
      .topbar-title { font-size: 15px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
      .modal-dialog { margin: 10px; max-width: calc(100% - 20px); }
    }
  </style>
</head>
<body>

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <a href="/dashboard" class="sidebar-brand">
      <div class="sidebar-brand-icon">📁</div>
      <div class="sidebar-brand-text">cari<span>Arsip</span></div>
    </a>

    <div class="sidebar-label">Menu Utama</div>

    <nav class="sidebar-nav">
      <a href="/search" class="nav-item {{ request()->is('search*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Pencarian
      </a>
      @can('tambah dokumen')
      <a href="{{ route('documents.create') }}" class="nav-item {{ request()->is('documents/create') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        Upload Dokumen
      </a>
      @endcan
      @can('kelola kategori')
      <a href="{{ route('categories.index') }}" class="nav-item {{ request()->is('categories*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
        Kategori
      </a>
      @endcan
      @can('hapus dokumen')
      <a href="{{ route('documents.trash') }}" class="nav-item {{ request()->is('documents/trash*') ? 'active' : '' }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        Sampah / Trash
      </a>
      @endcan

      @if(auth()->user()->can('kelola pengguna') || auth()->user()->can('kelola peran') || auth()->user()->can('kelola pin'))
        <div class="sidebar-label" style="margin-top:16px">Hak Akses</div>

        @can('kelola pengguna')
        <a href="{{ route('users.index') }}" class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          Kelola Pengguna
        </a>
        @endcan
        @can('kelola peran')
        <a href="{{ route('roles.index') }}" class="nav-item {{ request()->is('roles*') ? 'active' : '' }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
          Peran & Izin
        </a>
        @endcan
        @if(auth()->user()->hasRole('Super Admin'))
        <a href="{{ route('quick-links.index') }}" class="nav-item {{ request()->is('quick-links*') ? 'active' : '' }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="19" cy="5" r="1"/><circle cx="5" cy="5" r="1"/><circle cx="12" cy="19" r="1"/><circle cx="19" cy="19" r="1"/><circle cx="5" cy="19" r="1"/></svg>
          Kelola Link Menu
        </a>
        @endif
        @can('kelola pin')
        <a href="{{ route('settings.public-pin') }}" class="nav-item {{ request()->is('settings/public-pin*') ? 'active' : '' }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          PIN Akses Publik
        </a>
        @endcan
      @endif
    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user" id="sidebarUserBtn">
        <div class="user-menu" id="userMenu">
          <a href="{{ route('profile.edit') }}" class="user-menu-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profil Saya
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="user-menu-item danger">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
              Logout
            </button>
          </form>
        </div>
        <div class="avatar">{{ auth()->user()->initials ?? 'US' }}</div>
        <div class="avatar-info">
          <div class="avatar-name">{{ auth()->user()->name ?? 'User' }}</div>
          <div class="avatar-role">{{ auth()->user()->roles->first()?->name ?? 'Administrator' }}</div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.4)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main-wrap">

    <!-- Topbar -->
    <header class="topbar">
      <button class="topbar-btn" id="sidebarToggle" style="display:none">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <span class="topbar-title">@yield('title', 'Dashboard')</span>
      <div class="topbar-actions">
        <a href="{{ route('public.search') }}" class="topbar-btn" title="Halaman Publik" style="width:auto;padding:0 10px;border-radius:16px;border:1px solid #e8eaed;font-size:12px;font-weight:500;color:#5f6368;gap:5px;display:flex;align-items:center">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          <span class="topbar-public-text">Halaman Publik</span>
        </a>
        <div style="width:1px;height:24px;background:#e8eaed" class="topbar-user-name"></div>
        <div style="font-size:13px;font-weight:500;color:#202124" class="topbar-user-name">{{ auth()->user()->name ?? 'User' }}</div>
        <div class="topbar-avatar">{{ auth()->user()->initials ?? 'US' }}</div>
      </div>
    </header>

    <!-- Page Content -->
    <main class="page-content">
      @yield('content')
    </main>

  </div>

  <!-- Modal backdrop -->
  <div class="modal-backdrop" id="modalBackdrop"></div>

  <script>
    // Sidebar user menu toggle
    const userBtn  = document.getElementById('sidebarUserBtn');
    const userMenu = document.getElementById('userMenu');
    if (userBtn) {
      userBtn.addEventListener('click', e => {
        e.stopPropagation();
        userMenu.classList.toggle('open');
      });
      document.addEventListener('click', () => userMenu.classList.remove('open'));
    }

    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar       = document.getElementById('sidebar');
    const backdrop      = document.getElementById('modalBackdrop');
    if (window.innerWidth <= 768 && sidebarToggle) sidebarToggle.style.display = 'flex';
    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        backdrop.classList.toggle('show');
      });
    }

    // Bootstrap-compatible modal trigger (simple)
    document.addEventListener('click', e => {
      const trigger = e.target.closest('[data-bs-toggle="modal"]');
      if (trigger) {
        e.preventDefault();
        const target = document.querySelector(trigger.dataset.bsTarget);
        if (target) { target.classList.add('show'); backdrop.classList.add('show'); }
      }
      const dismiss = e.target.closest('[data-bs-dismiss="modal"]');
      if (dismiss) {
        const modal = dismiss.closest('.modal');
        if (modal) { modal.classList.remove('show'); backdrop.classList.remove('show'); }
      }
    });
    backdrop.addEventListener('click', () => {
      document.querySelectorAll('.modal.show').forEach(m => m.classList.remove('show'));
      backdrop.classList.remove('show');
      sidebar.classList.remove('open');
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') {
        document.querySelectorAll('.modal.show').forEach(m => m.classList.remove('show'));
        backdrop.classList.remove('show');
      }
    });
  </script>

  @stack('scripts')
</body>
</html>
