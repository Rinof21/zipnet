@extends('layouts.app2')

@section('title', 'Pencarian Dokumen')

@push('styles')
<style>
  /* ===== TOOLBAR ===== */
  .page-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }

  .page-heading { font-size: 20px; font-weight: 700; color: #202124; }
  .page-heading-sub { font-size: 13px; color: #70757a; margin-top: 2px; }

  .btn-upload {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1a73e8;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    text-decoration: none;
    cursor: pointer;
    transition: background .15s, box-shadow .15s;
    white-space: nowrap;
  }
  .btn-upload:hover { background: #1557b0; box-shadow: 0 4px 14px rgba(26,115,232,.35); color: #fff; }

  /* ===== SEARCH BAR ===== */
  .search-bar-wrap {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 20px;
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
  }

  .search-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 9px 14px;
    flex: 1;
    min-width: 200px;
    transition: border-color .2s, box-shadow .2s;
  }
  .search-input-group:focus-within {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,.1);
    background: #fff;
  }
  .search-input-group svg { color: #9aa0a6; flex-shrink: 0; }
  .search-input-group input {
    border: none; outline: none; background: transparent;
    font-size: 14px; font-family: "Inter", sans-serif; color: #202124;
    width: 100%;
  }
  .search-input-group input::placeholder { color: #9aa0a6; }

  .search-select-group {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #f8f9fa;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 9px 14px;
    min-width: 180px;
    transition: border-color .2s;
  }
  .search-select-group:focus-within { border-color: #1a73e8; background: #fff; }
  .search-select-group svg { color: #9aa0a6; flex-shrink: 0; }
  .search-select-group select {
    border: none; outline: none; background: transparent;
    font-size: 14px; font-family: "Inter", sans-serif; color: #202124;
    cursor: pointer; width: 100%;
  }

  .btn-search {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #1a73e8;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 14px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    transition: background .15s;
    white-space: nowrap;
  }
  .btn-search:hover { background: #1557b0; }

  .btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: transparent;
    color: #70757a;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 500;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, border-color .15s;
    white-space: nowrap;
  }
  .btn-reset:hover { background: #f1f3f4; border-color: #dadce0; color: #202124; }

  /* ===== RESULT META ===== */
  .result-meta {
    font-size: 13px;
    color: #70757a;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .result-badge {
    background: #e8f0fe;
    color: #1a73e8;
    font-size: 12px;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 20px;
  }

  /* ===== TABLE ===== */
  .table-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    overflow: hidden;
  }

  .doc-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }

  .doc-table thead tr { background: #f8f9fa; }
  .doc-table th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #70757a;
    border-bottom: 1px solid #e8eaed;
    white-space: nowrap;
  }
  .doc-table th.center { text-align: center; }

  .doc-table td {
    padding: 13px 16px;
    border-bottom: 1px solid #f5f5f5;
    color: #202124;
    vertical-align: middle;
  }
  .doc-table td.center { text-align: center; }
  .doc-table tbody tr:last-child td { border-bottom: none; }
  .doc-table tbody tr { transition: background .12s; }
  .doc-table tbody tr:hover td { background: #fafbff; }

  /* No column */
  .td-no { color: #9aa0a6; font-size: 12px; font-weight: 500; }

  /* Title cell */
  .doc-title {
    font-weight: 600;
    color: #202124;
    line-height: 1.4;
    max-width: 200px;
  }

  /* Nomor surat */
  .doc-nomor {
    font-size: 12.5px;
    color: #3c4043;
    font-family: "Inter", monospace;
    max-width: 160px;
    word-break: break-all;
  }

  /* Perihal */
  .doc-perihal {
    font-size: 13px;
    color: #4d5156;
    max-width: 220px;
    line-height: 1.5;
  }

  /* Kategori badge */
  .cat-badge {
    display: inline-block;
    background: #e6f4ea;
    color: #188038;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
  }

  /* Tag badges */
  .tags-wrap { display: flex; flex-wrap: wrap; gap: 4px; max-width: 160px; }
  .tag-badge {
    display: inline-block;
    background: #e8f0fe;
    color: #1a73e8;
    font-size: 11px;
    font-weight: 500;
    padding: 3px 9px;
    border-radius: 20px;
    text-decoration: none;
    white-space: nowrap;
    transition: background .12s;
  }
  .tag-badge:hover { background: #d2e3fc; }

  /* Tanggal */
  .doc-date { font-size: 12.5px; color: #5f6368; white-space: nowrap; }

  /* Action buttons */
  .action-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }
  .btn-action {
    width: 32px; height: 32px;
    border-radius: 8px;
    border: none;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .1s;
  }
  .btn-action:hover { transform: scale(1.1); }
  .btn-view { background: #e8f0fe; color: #1a73e8; }
  .btn-view:hover { background: #d2e3fc; }
  .btn-edit { background: #fef3e2; color: #e37400; }
  .btn-edit:hover { background: #fde7b0; }

  /* Empty state */
  .empty-state {
    padding: 60px 20px;
    text-align: center;
  }
  .empty-icon { font-size: 48px; margin-bottom: 14px; }
  .empty-title { font-size: 16px; font-weight: 600; color: #202124; margin-bottom: 6px; }
  .empty-sub { font-size: 14px; color: #70757a; }

  /* Pagination */
  .pagination-wrap { padding: 16px 20px; border-top: 1px solid #e8eaed; display: flex; justify-content: center; }
  .pagination { display: flex; align-items: center; gap: 4px; list-style: none; margin: 0; padding: 0; }
  .page-item .page-link, .page-item span.page-link {
    display: flex; align-items: center; justify-content: center; gap: 5px;
    min-width: 36px; height: 36px; padding: 0 10px;
    border-radius: 8px; font-size: 13px; font-weight: 500;
    color: #5f6368; background: transparent; border: 1px solid transparent;
    text-decoration: none; transition: background .12s; font-family: "Inter", sans-serif; cursor: pointer;
  }
  .page-item .page-link:hover { background: #f1f3f4; color: #202124; }
  .page-item.active .page-link, .page-item.active span.page-link { background: #1a73e8; color: #fff; border-color: #1a73e8; }
  .page-item.disabled .page-link, .page-item.disabled span.page-link { opacity: .35; pointer-events: none; }



  /* Success alert */
  .alert-success {
    background: #e6f4ea;
    border: 1px solid #a8d5b5;
    color: #188038;
    border-radius: 10px;
    padding: 12px 18px;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
  }
  /* ===== RIGHT DRAWER ===== */
  .drawer-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 500; opacity: 0; pointer-events: none; transition: opacity .3s ease; }
  .drawer-overlay.active { opacity: 1; pointer-events: all; }
  .drawer { position: fixed; top: 0; right: 0; width: min(820px, 100vw); height: 100vh; background: #fff; z-index: 600; transform: translateX(100%); transition: transform .35s cubic-bezier(.4,0,.2,1); display: flex; flex-direction: column; box-shadow: -6px 0 40px rgba(0,0,0,.2); }
  .drawer.open { transform: translateX(0); }
  .drawer-header { display: flex; align-items: center; gap: 12px; padding: 14px 20px; border-bottom: 1px solid #e8eaed; flex-shrink: 0; background: #fff; }
  .drawer-close { width: 36px; height: 36px; border: none; background: transparent; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #5f6368; transition: background .15s; flex-shrink: 0; }
  .drawer-close:hover { background: #f1f3f4; }
  .drawer-title-info { flex: 1; min-width: 0; }
  .drawer-doc-title { font-size: 14px; font-weight: 700; color: #202124; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .drawer-doc-sub { font-size: 12px; color: #70757a; margin-top: 2px; }
  .drawer-header-actions { display: flex; gap: 8px; flex-shrink: 0; }
  .drawer-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; font-family: "Inter", sans-serif; text-decoration: none; cursor: pointer; border: 1px solid #dadce0; background: #fff; color: #5f6368; transition: background .15s; white-space: nowrap; }
  .drawer-btn:hover { background: #f1f3f4; color: #202124; }
  .drawer-body { flex: 1; overflow: hidden; background: #525659; position: relative; }
  .drawer-body iframe { width: 100%; height: 100%; border: none; }
  .drawer-loading { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; color: rgba(255,255,255,.8); font-size: 14px; background: #525659; z-index: 2; transition: opacity .3s; }
  .drawer-loading.hidden { opacity: 0; pointer-events: none; }
  .spinner-ring { width: 40px; height: 40px; border: 3px solid rgba(255,255,255,.15); border-top-color: #4ca3ff; border-radius: 50%; animation: spin .9s linear infinite; }
  @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')

  {{-- Success alert --}}
  @if(session('success'))
    <div class="alert-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif

  {{-- Toolbar --}}
  <div class="page-toolbar">
    <div>
      <div class="page-heading">Pencarian Dokumen</div>
      <div class="page-heading-sub">Kelola dan cari seluruh arsip dokumen</div>
    </div>
    <a href="{{ route('documents.create') }}" class="btn-upload">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
      Upload Dokumen
    </a>
  </div>

  {{-- Search Bar --}}
  <form action="{{ route('documents.search') }}" method="GET" class="search-bar-wrap">
    <div class="search-input-group">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="text" name="q" value="{{ $q }}" placeholder="Cari judul, nomor surat, atau perihal...">
    </div>

    <div class="search-select-group">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
      <select name="category">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="search-select-group">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
      <select name="uploader">
        <option value="">Semua Pengupload</option>
        @foreach($uploaders as $u)
          <option value="{{ $u->id }}" {{ $uploader == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn-search">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      Cari
    </button>

    @if($q || $category || $uploader)
      <a href="{{ route('documents.search') }}" class="btn-reset">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3 21 21"/><path d="M10.5 10.677a2 2 0 0 0 2.823 2.823"/><path d="M7.362 7.561C5.68 8.74 4.279 10.42 3.29 12c1.9 3.05 5.19 6 8.71 6 1.5 0 2.9-.55 4.1-1.38"/><path d="m12 6c4.522 0 7.67 3.65 9.2 6-.64 1.06-1.4 2-2.2 2.77"/></svg>
        Reset
      </a>
    @endif
  </form>

  {{-- Result meta --}}
  <div class="result-meta">
    <span>Menampilkan</span>
    <span class="result-badge">{{ $documents->total() }} dokumen</span>
    @if($q) <span>untuk "<strong>{{ $q }}</strong>"</span> @endif
  </div>

  {{-- Table --}}
  <div class="table-card">
    <div style="overflow-x:auto">
      <table class="doc-table">
        <thead>
          <tr>
            <th class="center" style="width:46px">No</th>
            <th style="min-width:160px">Judul</th>
            <th style="min-width:140px">Nomor Surat</th>
            <th style="min-width:160px">Perihal</th>
            <th style="min-width:110px">Kategori</th>
            <th style="min-width:85px">Akses</th>
            <th style="min-width:130px">Pengupload</th>
            <th style="min-width:130px">Tags</th>
            <th class="center" style="min-width:100px">Tanggal Surat</th>
            <th class="center" style="min-width:80px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($documents as $index => $doc)
            <tr>
              <td class="center td-no">{{ $documents->firstItem() + $index }}</td>

              <td>
                <div class="doc-title">{{ $doc->title }}</div>
              </td>

              <td>
                <div class="doc-nomor">{{ $doc->nomor_surat ?: '-' }}</div>
              </td>

              <td>
                <div class="doc-perihal">{{ Str::limit($doc->perihal, 80) ?: '-' }}</div>
              </td>

              <td>
                @if($doc->category)
                  <span class="cat-badge">{{ $doc->category->name }}</span>
                @else
                  <span style="color:#9aa0a6;font-size:12px">—</span>
                @endif
              </td>

              <td>
                @if($doc->is_private_to_uploader)
                  <span style="background:#fce8e6;color:#d93025;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;white-space:nowrap" title="Hanya Anda dan Super Admin yang bisa melihat">🔐 Privat Saya</span>
                @elseif($doc->is_public)
                  <span style="background:#e8f0fe;color:#1a73e8;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;white-space:nowrap">🌐 Publik</span>
                @else
                  <span style="background:#fef3e2;color:#e37400;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px;white-space:nowrap">👥 Internal</span>
                @endif
              </td>

              <td>
                <div style="display:flex;align-items:center;gap:6px;font-size:12.5px">
                  <span style="width:24px;height:24px;border-radius:50%;background:#e8f0fe;color:#1a73e8;display:inline-flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;flex-shrink:0">
                    {{ strtoupper(substr($doc->uploader->name ?? 'U', 0, 1)) }}
                  </span>
                  <span style="white-space:nowrap">{{ $doc->uploader->name ?? '-' }}</span>
                </div>
              </td>

              <td>
                @php
                  $tags = is_array($doc->tags) ? $doc->tags : json_decode($doc->tags, true);
                  $tags = array_filter(array_map('trim', (array) $tags));
                @endphp
                <div class="tags-wrap">
                  @forelse($tags as $tag)
                    <a href="{{ url('tags/' . urlencode($tag)) }}" class="tag-badge">{{ $tag }}</a>
                  @empty
                    <span style="color:#9aa0a6;font-size:12px">—</span>
                  @endforelse
                </div>
              </td>

              <td class="center">
                <div class="doc-date">{{ $doc->tanggal_surat->format('d M Y') }}</div>
              </td>

              <td class="center">
                <div class="action-wrap">
                  <button
                    class="btn-action btn-view"
                    title="Preview"
                    onclick="openDrawer(
                      {{ json_encode($doc->title) }},
                      {{ json_encode($doc->nomor_surat) }},
                      {{ json_encode(asset('storage/' . $doc->file_path)) }},
                      {{ $doc->id }}
                    )"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                  </button>
                  <a href="{{ route('documents.edit', $doc->id) }}" class="btn-action btn-edit" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="10">
                <div class="empty-state">
                  <div class="empty-icon">🔍</div>
                  <div class="empty-title">Tidak ada dokumen ditemukan</div>
                  <div class="empty-sub">Coba ubah kata kunci atau filter kategori</div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($documents->hasPages())
      <div class="pagination-wrap">
        {{ $documents->onEachSide(1)->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>

  {{-- RIGHT DRAWER --}}
  <div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
  <div class="drawer" id="pdfDrawer" role="dialog" aria-modal="true">
    <div class="drawer-header">
      <button class="drawer-close" onclick="closeDrawer()" aria-label="Tutup">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
      </button>
      <div class="drawer-title-info">
        <div class="drawer-doc-title" id="drawerTitle">—</div>
        <div class="drawer-doc-sub" id="drawerSub">—</div>
      </div>
      <div class="drawer-header-actions">
        <a href="#" id="drawerEditLink" class="drawer-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          Edit
        </a>
        <a href="#" id="drawerOpenLink" class="drawer-btn" target="_blank" rel="noopener">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          Buka Penuh
        </a>
      </div>
    </div>
    <div class="drawer-body">
      <div class="drawer-loading" id="drawerLoading">
        <div class="spinner-ring"></div>
        <span>Memuat dokumen…</span>
      </div>
      <iframe id="pdfFrame" src="" title="Preview PDF" onload="document.getElementById('drawerLoading').classList.add('hidden')"></iframe>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  const drawer  = document.getElementById('pdfDrawer');
  const overlay = document.getElementById('drawerOverlay');
  const frame   = document.getElementById('pdfFrame');
  const loading = document.getElementById('drawerLoading');
  const titleEl = document.getElementById('drawerTitle');
  const subEl   = document.getElementById('drawerSub');
  const openLink  = document.getElementById('drawerOpenLink');
  const editLink  = document.getElementById('drawerEditLink');

  function openDrawer(title, nomor, pdfUrl, docId) {
    titleEl.textContent = title;
    subEl.textContent   = nomor ? 'Nomor Surat: ' + nomor : '—';
    openLink.href       = pdfUrl;
    editLink.href       = '/documents/' + docId + '/edit';
    loading.classList.remove('hidden');
    frame.src = '';
    drawer.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
    setTimeout(() => { frame.src = pdfUrl; }, 200);
  }

  function closeDrawer() {
    drawer.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
    setTimeout(() => { frame.src = ''; }, 350);
  }

  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });
</script>
@endpush
