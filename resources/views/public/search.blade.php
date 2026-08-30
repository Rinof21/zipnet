<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>cariArsip - Pencarian Dokumen</title>
  <meta name="description" content="Cari arsip dokumen surat dengan mudah dan cepat.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: "Inter", sans-serif; background: #f8f9fa; color: #202124; min-height: 100vh; }

    /* TOP BAR */
    .topbar { position: fixed; top: 0; right: 0; left: 0; height: 60px; display: flex; align-items: center; justify-content: flex-end; padding: 0 20px; gap: 12px; z-index: 100; background: transparent; }
    .topbar.has-query { background: #fff; border-bottom: 1px solid #e8eaed; }
    .menu-btn { width: 36px; height: 36px; border-radius: 50%; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .15s; }
    .menu-btn:hover { background: #f1f3f4; }
    .dot-grid { display: grid; grid-template-columns: repeat(3, 4px); gap: 2.5px; }
    .dot-grid span { width: 4px; height: 4px; border-radius: 50%; background: #5f6368; }
    /* GOOGLE APP LAUNCHER POPUP */
    .dropdown {
      position: absolute;
      top: 46px;
      right: 0;
      background: #ffffff;
      border: 1px solid #e0e0e0;
      border-radius: 20px;
      box-shadow: 0 1px 3px 0 rgba(60,64,67,0.3), 0 4px 12px 3px rgba(60,64,67,0.15);
      width: 320px;
      padding: 14px 10px;
      display: none;
      z-index: 200;
      max-height: 400px;
      overflow-y: auto;
    }
    .dropdown::-webkit-scrollbar { width: 5px; }
    .dropdown::-webkit-scrollbar-thumb { background: #dadce0; border-radius: 4px; }
    .dropdown.open { display: grid; grid-template-columns: repeat(3, 1fr); gap: 4px 2px; }
    .app-item { display: flex; flex-direction: column; align-items: center; justify-content: flex-start; padding: 10px 4px 8px; border-radius: 14px; text-decoration: none; transition: background .12s; min-height: 86px; }
    .app-item:hover { background: #e8f0fe; }
    .app-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 15px; font-weight: 600; color: #fff; margin-bottom: 6px; box-shadow: 0 1px 3px rgba(0,0,0,.15); flex-shrink: 0; }
    .app-label { font-size: 12px; font-weight: 400; color: #3c4043; text-align: center; line-height: 1.25; max-width: 100%; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .login-btn { font-size: 13px; font-weight: 500; color: #fff; background: #1a73e8; padding: 8px 20px; border-radius: 20px; text-decoration: none; transition: background .15s, box-shadow .15s; }
    .login-btn:hover { background: #1557b0; box-shadow: 0 2px 8px rgba(26,115,232,.4); }
    .user-avatar-btn {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: #1a73e8;
      color: #fff;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 400;
      text-decoration: none;
      transition: background .15s, box-shadow .15s;
      flex-shrink: 0;
    }
    .user-avatar-btn:hover {
      background: #1557b0;
      box-shadow: 0 2px 8px rgba(26,115,232,.4);
    }

    /* HOME */
    .home-wrapper { display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; padding: 60px 20px 20px; }
    .logo-home { font-size: 64px; font-weight: 300; color: #5f6368; letter-spacing: -1px; margin-bottom: 32px; text-decoration: none; }
    .logo-home span { color: #1a73e8; font-weight: 700; }
    .home-btn { background: #f8f9fa; border: 1px solid #dadce0; border-radius: 6px; color: #3c4043; font-size: 14px; font-weight: 500; font-family: "Inter", sans-serif; padding: 9px 20px; cursor: pointer; transition: background .15s, border-color .15s, box-shadow .15s, color .15s; }
    .home-btn:hover { background: #fff; border-color: #1a73e8; color: #1a73e8; box-shadow: 0 1px 4px rgba(26,115,232,.15); }

    /* SEARCH BAR */
    .search-form { width: 100%; }
    .search-input-wrap { display: flex; align-items: center; background: #fff; border: 1px solid #dfe1e5; border-radius: 24px; padding: 8px 16px; gap: 10px; transition: box-shadow .2s, border-color .2s; }
    .search-input-wrap:hover, .search-input-wrap:focus-within { box-shadow: 0 1px 6px rgba(32,33,36,.28); border-color: rgba(223,225,229,0); }
    .search-input-wrap.home-style { max-width: 584px; width: 100%; padding: 12px 20px; border-radius: 28px; }
    .search-icon { color: #9aa0a6; flex-shrink: 0; }
    .search-input-wrap input { flex: 1; border: none; outline: none; font-size: 16px; font-family: "Inter", sans-serif; color: #202124; background: transparent; }
    .search-btn { background: #1a73e8; color: #fff; border: none; border-radius: 20px; padding: 7px 18px; font-size: 14px; font-weight: 500; font-family: "Inter", sans-serif; cursor: pointer; transition: background .15s; flex-shrink: 0; }
    .search-btn:hover { background: #1557b0; }

    /* STICKY SEARCH BAR */
    .search-bar-sticky { position: fixed; top: 0; left: 0; right: 0; height: 60px; background: #fff; border-bottom: 1px solid #e8eaed; display: flex; align-items: center; padding: 0 20px; gap: 16px; z-index: 100; }
    .logo-small { font-size: 22px; font-weight: 300; color: #5f6368; text-decoration: none; white-space: nowrap; flex-shrink: 0; }
    .logo-small span { color: #1a73e8; font-weight: 700; }
    .topbar-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; flex-shrink: 0; }

    /* RESULTS */
    .results-wrapper { padding-top: 80px; padding-left: 160px; padding-right: 24px; max-width: 900px; }
    .result-meta { font-size: 13px; color: #70757a; margin-bottom: 20px; padding-top: 8px; }
    .result-list { display: flex; flex-direction: column; gap: 2px; }
    .result-card { padding: 16px 0; border-bottom: 1px solid #f0f0f0; cursor: pointer; text-decoration: none; display: block; color: inherit; }
    .result-card:last-child { border-bottom: none; }
    .result-card:hover .result-title { text-decoration: underline; }
    .result-url { font-size: 12px; color: #4d5156; margin-bottom: 4px; }
    .result-title { font-size: 20px; font-weight: 400; color: #1a0dab; margin-bottom: 4px; line-height: 1.3; }
    .result-snippet { font-size: 14px; color: #4d5156; line-height: 1.58; }
    .result-snippet strong { color: #202124; font-weight: 500; }
    .result-date { font-size: 12px; color: #70757a; margin-top: 4px; }
    .no-result { text-align: left; color: #4d5156; padding-top: 24px; font-size: 16px; }

    /* DRAWER */
    .drawer-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.35); z-index: 300; opacity: 0; pointer-events: none; transition: opacity .3s ease; }
    .drawer-overlay.active { opacity: 1; pointer-events: all; }
    .drawer { position: fixed; top: 0; right: 0; width: min(780px, 100vw); height: 100vh; background: #fff; z-index: 400; transform: translateX(100%); transition: transform .35s cubic-bezier(.4,0,.2,1); display: flex; flex-direction: column; box-shadow: -4px 0 30px rgba(0,0,0,.2); }
    .drawer.open { transform: translateX(0); }
    .drawer-header { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-bottom: 1px solid #e8eaed; flex-shrink: 0; background: #fff; }
    .drawer-close { width: 36px; height: 36px; border: none; background: transparent; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #5f6368; transition: background .15s; flex-shrink: 0; }
    .drawer-close:hover { background: #f1f3f4; }
    .drawer-title-info { flex: 1; min-width: 0; }
    .drawer-doc-title { font-size: 14px; font-weight: 600; color: #202124; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .drawer-doc-sub { font-size: 12px; color: #70757a; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .drawer-open-btn { font-size: 12px; color: #1a73e8; background: none; border: 1px solid #dadce0; border-radius: 16px; padding: 6px 14px; cursor: pointer; text-decoration: none; white-space: nowrap; font-family: "Inter", sans-serif; transition: background .15s; display: flex; align-items: center; gap: 5px; }
    .drawer-open-btn:hover { background: #e8f0fe; }
    .drawer-body { flex: 1; overflow: hidden; background: #525659; position: relative; }
    .drawer-body iframe { width: 100%; height: 100%; border: none; }
    .drawer-loading { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 12px; color: #fff; font-size: 14px; }
    .spinner { width: 36px; height: 36px; border: 3px solid rgba(255,255,255,.2); border-top-color: #fff; border-radius: 50%; animation: spin .8s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* RESPONSIVE DESIGN FOR MOBILE */
    @media (max-width: 768px) {
      .results-wrapper { padding-top: 76px; padding-left: 16px; padding-right: 16px; }
      .drawer { width: 100vw; height: 100dvh; }
      .result-title { font-size: 18px; }
    }

    @media (max-width: 640px) {
      .topbar { padding: 0 12px; height: 54px; }
      .logo-home { font-size: 42px; margin-bottom: 24px; }
      .home-wrapper { padding: 40px 16px 20px; }
      .home-style { padding: 10px 16px !important; }
      
      .search-bar-sticky { height: 56px; padding: 0 10px; gap: 8px; }
      .logo-small { font-size: 16px; }
      .search-input-wrap { padding: 5px 10px; gap: 6px; }
      .search-input-wrap input { font-size: 13.5px; }
      .search-btn { padding: 6px 12px; font-size: 12px; border-radius: 16px; }
      .topbar-actions { gap: 6px; }
      .login-btn { padding: 6px 12px; font-size: 12px; }
      
      .results-wrapper { padding-top: 68px; padding-left: 12px; padding-right: 12px; }
      .result-title { font-size: 16px; }
      .result-snippet { font-size: 13px; line-height: 1.5; }
      .result-card { padding: 12px 0; }

      .drawer-header { padding: 10px 12px; gap: 8px; }
      .drawer-doc-title { font-size: 13px; }
      .drawer-doc-sub { font-size: 11px; }
      .drawer-open-btn { padding: 5px 10px; font-size: 11px; }
    }
  </style>
</head>

<body>

@if(empty($q))

<div class="topbar">
  <div style="position:relative">
    <button id="menuToggle" class="menu-btn" aria-label="Menu">
      <div class="dot-grid">
        @for($i=0;$i<9;$i++)<span></span>@endfor
      </div>
    </button>
    @php
      $gradients = [
        'linear-gradient(135deg, #4285f4, #1a73e8)',
        'linear-gradient(135deg, #34a853, #188038)',
        'linear-gradient(135deg, #fbbc04, #f9ab00)',
        'linear-gradient(135deg, #ea4335, #d93025)',
        'linear-gradient(135deg, #af52de, #8e24aa)',
        'linear-gradient(135deg, #00897b, #00695c)',
      ];
    @endphp
    <div id="menuDropdown" class="dropdown">
      @forelse($quickLinks ?? [] as $idx => $link)
        <a href="{{ $link->url }}" target="_blank" class="app-item">
          <div class="app-icon" style="background: {{ $gradients[$idx % count($gradients)] }}">
            {{ $link->initials }}
          </div>
          <span class="app-label">{{ $link->title }}</span>
        </a>
      @empty
        <a href="https://silatfk.untan.ac.id" target="_blank" class="app-item">
          <div class="app-icon" style="background: linear-gradient(135deg, #4285f4, #1a73e8)">SI</div>
          <span class="app-label">Silat</span>
        </a>
        <a href="http://203.24.51.238:8015" target="_blank" class="app-item">
          <div class="app-icon" style="background: linear-gradient(135deg, #34a853, #188038)">RS</div>
          <span class="app-label">Reservasi Ruang Sidang</span>
        </a>
        <a href="https://kedokteran.untan.ac.id" target="_blank" class="app-item">
          <div class="app-icon" style="background: linear-gradient(135deg, #fbbc04, #f9ab00)">WF</div>
          <span class="app-label">Website Fakultas</span>
        </a>
      @endforelse
    </div>
  </div>
  @auth
    <a href="{{ route('documents.search') }}" class="user-avatar-btn" title="Dashboard Staff ({{ auth()->user()->name }})">
      {{ auth()->user()->initials }}
    </a>
  @else
    <a href="/login" class="login-btn">Login</a>
  @endauth
</div>

<div class="home-wrapper">
  <a href="{{ route('public.search') }}" class="logo-home">cari<span>Arsip</span></a>
  <form action="{{ route('public.search') }}" method="GET" class="search-form" style="display:flex;flex-direction:column;align-items:center;gap:24px;width:100%">
    <div class="search-input-wrap home-style">
      <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari judul, nomor surat atau perihal..." autofocus>
    </div>
    <div class="home-buttons">
      <button type="submit" class="home-btn">Cari Arsip</button>
    </div>
  </form>
</div>

@else

<div class="search-bar-sticky">
  <a href="{{ route('public.search') }}" class="logo-small">cari<span>Arsip</span></a>
  <form action="{{ route('public.search') }}" method="GET" class="search-form" style="flex:1">
    <div class="search-input-wrap">
      <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari arsip...">
      <button type="submit" class="search-btn">Cari</button>
    </div>
  </form>
  <div class="topbar-actions">
    <div style="position:relative">
      <button id="menuToggle2" class="menu-btn" aria-label="Menu">
        <div class="dot-grid">
          @for($i=0;$i<9;$i++)<span></span>@endfor
        </div>
      </button>
      <div id="menuDropdown2" class="dropdown" style="right:0">
        @forelse($quickLinks ?? [] as $idx => $link)
          <a href="{{ $link->url }}" target="_blank" class="app-item">
            <div class="app-icon" style="background: {{ $gradients[$idx % count($gradients)] }}">
              {{ $link->initials }}
            </div>
            <span class="app-label">{{ $link->title }}</span>
          </a>
        @empty
          <a href="https://silatfk.untan.ac.id" target="_blank" class="app-item">
            <div class="app-icon" style="background: linear-gradient(135deg, #4285f4, #1a73e8)">SI</div>
            <span class="app-label">Silat</span>
          </a>
          <a href="http://203.24.51.238:8015" target="_blank" class="app-item">
            <div class="app-icon" style="background: linear-gradient(135deg, #34a853, #188038)">RS</div>
            <span class="app-label">Reservasi Ruang Sidang</span>
          </a>
          <a href="https://kedokteran.untan.ac.id" target="_blank" class="app-item">
            <div class="app-icon" style="background: linear-gradient(135deg, #fbbc04, #f9ab00)">WF</div>
            <span class="app-label">Website Fakultas</span>
          </a>
        @endforelse
      </div>
    </div>
    @auth
      <a href="{{ route('documents.search') }}" class="user-avatar-btn" title="Dashboard Staff ({{ auth()->user()->name }})">
        {{ auth()->user()->initials }}
      </a>
    @else
      <a href="/login" class="login-btn">Login</a>
    @endauth
  </div>
</div>

<div class="results-wrapper">
  <p class="result-meta">Menampilkan hasil untuk: <strong>{{ $q }}</strong></p>
  <div class="result-list">
    @forelse($documents as $doc)
      @php
        $isAccessible = $doc->is_public && !$doc->is_private_to_uploader;
      @endphp
      @if($isAccessible)
        <a href="#" class="result-card" onclick="openDrawer({{ json_encode($doc->title) }}, {{ json_encode($doc->nomor_surat) }}, {{ json_encode(asset('storage/' . $doc->file_path)) }}, {{ json_encode($doc->attachments) }}); return false;">
          <div class="result-url">cariarsip › arsip › {{ Str::slug($doc->title) }}</div>
          <div class="result-title">{{ $doc->title }}</div>
          <div class="result-snippet">
            Nomor Surat: <strong>{{ $doc->nomor_surat }}</strong>
            @if($doc->perihal) &nbsp;·&nbsp; {{ Str::limit($doc->perihal, 120) }} @endif
            @if($doc->attachments && $doc->attachments->count() > 0)
              &nbsp;·&nbsp; <span style="color:#1a73e8;font-weight:600">📎 {{ $doc->attachments->count() }} Lampiran</span>
            @endif
          </div>
          <div class="result-date">{{ $doc->tanggal_surat ? $doc->tanggal_surat->format('d M Y') : '' }}</div>
        </a>
      @else
        <div class="result-card" onclick="alert('🔒 Dokumen ini bersifat {{ $doc->is_private_to_uploader ? 'Private' : 'Internal' }}.\nFile PDF tidak dapat dibuka tanpa login sebagai pengelola yang berhak.'); return false;" style="opacity:.85">
          <div class="result-url">cariarsip › arsip › {{ Str::slug($doc->title) }}</div>
          <div class="result-title" style="color:#5f6368">{{ $doc->title }}</div>
          <div class="result-snippet">
            Nomor Surat: <strong>{{ $doc->nomor_surat }}</strong>
            @if($doc->perihal) &nbsp;·&nbsp; {{ Str::limit($doc->perihal, 120) }} @endif
          </div>
          <div class="result-date" style="color:#d93025;font-weight:500;margin-top:4px">
            🔒 Akses Terbatas ({{ $doc->is_private_to_uploader ? 'Private' : 'Internal' }})
          </div>
        </div>
      @endif
    @empty
      <p class="no-result">Tidak ada arsip yang sesuai dengan pencarian "<strong>{{ $q }}</strong>".</p>
    @endforelse
  </div>
</div>

<div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
<div class="drawer" id="pdfDrawer" role="dialog" aria-modal="true">
  <div class="drawer-header">
    <button class="drawer-close" onclick="closeDrawer()" aria-label="Tutup">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
    </button>
    <div class="drawer-title-info">
      <div class="drawer-doc-title" id="drawerTitle">-</div>
      <div class="drawer-doc-sub" id="drawerSub">-</div>
    </div>
    <a href="#" id="drawerOpenLink" class="drawer-open-btn" target="_blank" rel="noopener">
      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
      Buka Penuh
    </a>
  </div>

  {{-- File Selector Pills --}}
  <div id="drawerFileSelector" style="background:#f8f9fa;border-bottom:1px solid #e8eaed;padding:8px 16px;display:none;gap:8px;align-items:center;overflow-x:auto;white-space:nowrap"></div>

  <div class="drawer-body">
    <div class="drawer-loading" id="drawerLoading">
      <div class="spinner"></div>
      <span>Memuat dokumen...</span>
    </div>
    <iframe id="pdfFrame" src="" title="Preview PDF" onload="hideLoading()"></iframe>
  </div>
</div>

@endif

<script>
  function setupMenu(btnId, menuId) {
    const btn = document.getElementById(btnId);
    const menu = document.getElementById(menuId);
    if (!btn || !menu) return;
    btn.addEventListener('click', e => { e.stopPropagation(); menu.classList.toggle('open'); });
    document.addEventListener('click', e => { if (!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.remove('open'); });
  }
  setupMenu('menuToggle', 'menuDropdown');
  setupMenu('menuToggle2', 'menuDropdown2');

  const drawer = document.getElementById('pdfDrawer');
  const overlay = document.getElementById('drawerOverlay');
  const frame = document.getElementById('pdfFrame');
  const loading = document.getElementById('drawerLoading');
  const titleEl = document.getElementById('drawerTitle');
  const subEl = document.getElementById('drawerSub');
  const openLink = document.getElementById('drawerOpenLink');
  const fileSelector = document.getElementById('drawerFileSelector');

  function openDrawer(title, nomor, primaryPdfUrl, attachments = []) {
    if (!drawer) return;
    titleEl.textContent = title;
    subEl.textContent = 'Nomor Surat: ' + nomor;
    if (openLink) openLink.href = primaryPdfUrl;

    // Build file switcher pills
    if (fileSelector) {
      fileSelector.innerHTML = '';
      if (attachments && attachments.length > 0) {
        fileSelector.style.display = 'flex';

        // Main file
        const mainPill = document.createElement('button');
        mainPill.style.cssText = 'padding:5px 12px;border-radius:16px;font-size:12px;font-weight:600;border:1px solid #1a73e8;background:#1a73e8;color:#fff;cursor:pointer;white-space:nowrap';
        mainPill.textContent = '📄 Surat Utama';
        mainPill.onclick = () => switchPublicFile(primaryPdfUrl, mainPill);
        fileSelector.appendChild(mainPill);

        // Attachment files
        attachments.forEach((att, i) => {
          const attUrl = '/storage/' + att.file_path;
          const attPill = document.createElement('button');
          attPill.style.cssText = 'padding:5px 12px;border-radius:16px;font-size:12px;font-weight:500;border:1px solid #dadce0;background:#fff;color:#5f6368;cursor:pointer;white-space:nowrap';
          attPill.textContent = '📎 Lampiran ' + (i + 1) + ': ' + att.file_name;
          attPill.onclick = () => switchPublicFile(attUrl, attPill);
          fileSelector.appendChild(attPill);
        });
      } else {
        fileSelector.style.display = 'none';
      }
    }

    if (loading) loading.style.display = 'flex';
    if (frame) frame.src = '';
    drawer.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    setTimeout(() => { if (frame) frame.src = primaryPdfUrl; }, 250);
  }

  function switchPublicFile(url, activePill) {
    if (fileSelector) {
      fileSelector.querySelectorAll('button').forEach(b => {
        b.style.background = '#fff';
        b.style.color = '#5f6368';
        b.style.borderColor = '#dadce0';
      });
    }
    activePill.style.background = '#1a73e8';
    activePill.style.color = '#fff';
    activePill.style.borderColor = '#1a73e8';
    if (openLink) openLink.href = url;
    if (loading) loading.style.display = 'flex';
    if (frame) frame.src = url;
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
    setTimeout(() => { if (frame) frame.src = ''; }, 350);
  }

  function hideLoading() {
    if (loading) loading.style.display = 'none';
  }

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
</script>

</body>
</html>
