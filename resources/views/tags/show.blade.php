@extends('layouts.app2')

@section('title', 'Tag: ' . $tag)

@push('styles')
<style>
  /* Hero tag banner */
  .tag-hero {
    background: linear-gradient(135deg, #0f1117 0%, #1a2340 50%, #0d2340 100%);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
    overflow: hidden;
  }
  .tag-hero::before {
    content: "";
    position: absolute;
    width: 280px; height: 280px;
    background: #1a73e8;
    border-radius: 50%;
    filter: blur(90px);
    opacity: .25;
    top: -80px; right: -60px;
    pointer-events: none;
  }
  .tag-hero-icon { width: 56px; height: 56px; border-radius: 14px; background: rgba(26,115,232,.25); border: 1px solid rgba(26,115,232,.3); display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; position: relative; z-index: 1; }
  .tag-hero-info { flex: 1; position: relative; z-index: 1; }
  .tag-hero-label { font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .8px; color: rgba(255,255,255,.4); margin-bottom: 5px; }
  .tag-hero-name { font-size: 26px; font-weight: 700; color: #fff; margin-bottom: 4px; display: flex; align-items: center; gap: 12px; }
  .tag-chip { background: rgba(26,115,232,.25); border: 1px solid rgba(74,163,255,.35); color: #4ca3ff; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; }
  .tag-hero-count { font-size: 13px; color: rgba(255,255,255,.5); }
  .tag-hero-count strong { color: rgba(255,255,255,.8); }
  .btn-back-hero { display: inline-flex; align-items: center; gap: 7px; background: rgba(255,255,255,.08); color: rgba(255,255,255,.75); border: 1px solid rgba(255,255,255,.15); border-radius: 8px; padding: 9px 18px; font-size: 13px; font-weight: 500; font-family: "Inter", sans-serif; text-decoration: none; white-space: nowrap; flex-shrink: 0; transition: background .15s; position: relative; z-index: 1; }
  .btn-back-hero:hover { background: rgba(255,255,255,.14); color: #fff; }

  /* Table card */
  .table-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; }
  .table-card-header { padding: 18px 24px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
  .table-card-title { font-size: 15px; font-weight: 700; color: #202124; display: flex; align-items: center; gap: 8px; }
  .count-badge { background: #e8f0fe; color: #1a73e8; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
  .doc-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  .doc-table thead tr { background: #f8f9fa; }
  .doc-table th { padding: 11px 18px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #70757a; border-bottom: 1px solid #e8eaed; white-space: nowrap; }
  .doc-table th.center { text-align: center; }
  .doc-table td { padding: 14px 18px; border-bottom: 1px solid #f5f5f5; color: #202124; vertical-align: middle; }
  .doc-table td.center { text-align: center; }
  .doc-table tbody tr:last-child td { border-bottom: none; }
  .doc-table tbody tr { transition: background .12s; }
  .doc-table tbody tr:hover td { background: #fafbff; }
  .doc-title { font-weight: 600; color: #202124; line-height: 1.4; }
  .doc-nomor { font-size: 12.5px; color: #3c4043; word-break: break-all; max-width: 160px; }
  .doc-perihal { font-size: 13px; color: #4d5156; line-height: 1.5; max-width: 220px; }
  .doc-date { font-size: 12.5px; color: #5f6368; white-space: nowrap; }
  .cat-badge { display: inline-block; background: #e6f4ea; color: #188038; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; white-space: nowrap; }
  .action-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }
  .btn-action { width: 32px; height: 32px; border-radius: 8px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; transition: background .15s, transform .1s; }
  .btn-action:hover { transform: scale(1.1); }
  .btn-view { background: #e8f0fe; color: #1a73e8; cursor:pointer; }
  .btn-view:hover { background: #d2e3fc; }
  .btn-edit { background: #fef3e2; color: #e37400; }
  .btn-edit:hover { background: #fde7b0; }
  .empty-state { padding: 60px 20px; text-align: center; }
  .empty-icon { font-size: 48px; margin-bottom: 14px; }
  .empty-title { font-size: 16px; font-weight: 600; color: #202124; margin-bottom: 6px; }
  .empty-sub { font-size: 14px; color: #70757a; }
  .pagination-wrap { padding: 16px 20px; border-top: 1px solid #e8eaed; display: flex; justify-content: center; }
  .pagination { display: flex; gap: 4px; list-style: none; margin: 0; padding: 0; }
  .page-item .page-link { display: flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; font-size: 13px; font-weight: 500; color: #5f6368; background: transparent; border: none; text-decoration: none; transition: background .12s; font-family: "Inter", sans-serif; }
  .page-item .page-link:hover { background: #f1f3f4; color: #202124; }
  .page-item.active .page-link { background: #1a73e8; color: #fff; }
  .page-item.disabled .page-link { opacity: .4; pointer-events: none; }

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
  .drawer-doc-sub { font-size: 12px; color: #70757a; margin-top: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .drawer-header-actions { display: flex; gap: 8px; flex-shrink: 0; }
  .drawer-btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 500; font-family: "Inter", sans-serif; text-decoration: none; cursor: pointer; border: 1px solid #dadce0; background: #fff; color: #5f6368; transition: background .15s; white-space: nowrap; }
  .drawer-btn:hover { background: #f1f3f4; color: #202124; }
  .drawer-body { flex: 1; overflow: hidden; background: #525659; position: relative; }
  .drawer-body iframe { width: 100%; height: 100%; border: none; }
  .drawer-loading { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 14px; color: rgba(255,255,255,.8); font-size: 14px; background: #525659; z-index: 2; transition: opacity .3s; }
  .drawer-loading.hidden { opacity: 0; pointer-events: none; }
  .spinner-ring { width: 40px; height: 40px; border: 3px solid rgba(255,255,255,.15); border-top-color: #4ca3ff; border-radius: 50%; animation: spin .9s linear infinite; }
  @keyframes spin { to { transform: rotate(360deg); } }
  @media (max-width: 768px) { .drawer { width: 100vw; } }
</style>
@endpush

@section('content')

  <div class="tag-hero">
    <div class="tag-hero-icon">🏷️</div>
    <div class="tag-hero-info">
      <div class="tag-hero-label">Filter berdasarkan tag</div>
      <div class="tag-hero-name">{{ $tag }} <span class="tag-chip"># tag</span></div>
      <div class="tag-hero-count">Ditemukan <strong>{{ $documents->total() }} dokumen</strong> dengan tag ini</div>
    </div>
    <a href="{{ route('documents.search') }}" class="btn-back-hero">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
      Kembali ke Pencarian
    </a>
  </div>

  <div class="table-card">
    <div class="table-card-header">
      <div class="table-card-title">📄 Dokumen dengan Tag <span class="count-badge">{{ $documents->total() }}</span></div>
    </div>
    <div style="overflow-x:auto">
      <table class="doc-table">
        <thead>
          <tr>
            <th style="min-width:180px">Judul</th>
            <th style="min-width:150px">Nomor Surat</th>
            <th style="min-width:180px">Perihal</th>
            <th style="min-width:110px">Kategori</th>
            <th class="center" style="min-width:100px">Tanggal</th>
            <th class="center" style="min-width:90px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($documents as $doc)
            <tr>
              <td><div class="doc-title">{{ $doc->title }}</div></td>
              <td><div class="doc-nomor">{{ $doc->nomor_surat ?: '—' }}</div></td>
              <td><div class="doc-perihal">{{ Str::limit($doc->perihal, 90) ?: '—' }}</div></td>
              <td>
                @if($doc->category) <span class="cat-badge">{{ $doc->category->name }}</span>
                @else <span style="color:#9aa0a6;font-size:12px">—</span> @endif
              </td>
              <td class="center"><div class="doc-date">{{ $doc->tanggal_surat->format('d M Y') }}</div></td>
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
              <td colspan="6">
                <div class="empty-state">
                  <div class="empty-icon">🔍</div>
                  <div class="empty-title">Tidak ada dokumen dengan tag ini</div>
                  <div class="empty-sub">Tag "<strong>{{ $tag }}</strong>" belum digunakan pada dokumen manapun</div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($documents->hasPages())
      <div class="pagination-wrap">{{ $documents->onEachSide(1)->links('pagination::bootstrap-5') }}</div>
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
