@extends('layouts.app2')

@section('title', 'Preview – ' . Str::limit($document->title, 40))

@push('styles')
<style>
  /* Remove default page padding for full-height layout */
  .page-content { padding: 0 !important; display: flex; flex-direction: column; height: calc(100vh - 60px); }

  /* ===== TOP BAR ===== */
  .preview-topbar {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 24px;
    background: #fff;
    border-bottom: 1px solid #e8eaed;
    flex-shrink: 0;
    flex-wrap: wrap;
  }

  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border: 1.5px solid #e8eaed;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    color: #5f6368;
    text-decoration: none;
    font-family: "Inter", sans-serif;
    transition: background .15s, border-color .15s;
    white-space: nowrap;
    flex-shrink: 0;
  }
  .btn-back:hover { background: #f1f3f4; border-color: #dadce0; color: #202124; }

  .preview-doc-info { flex: 1; min-width: 0; }
  .preview-doc-title {
    font-size: 15px;
    font-weight: 700;
    color: #202124;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .preview-doc-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 3px;
    flex-wrap: wrap;
  }
  .meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #70757a;
  }
  .meta-item svg { flex-shrink: 0; }

  .preview-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
  }

  .btn-action-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    font-family: "Inter", sans-serif;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: background .15s, box-shadow .15s;
    white-space: nowrap;
  }
  .btn-action-pill.primary { background: #1a73e8; color: #fff; }
  .btn-action-pill.primary:hover { background: #1557b0; box-shadow: 0 3px 12px rgba(26,115,232,.35); }
  .btn-action-pill.secondary { background: #f8f9fa; color: #3c4043; border: 1.5px solid #e8eaed; }
  .btn-action-pill.secondary:hover { background: #f1f3f4; }
  .btn-action-pill.warning { background: #fef3e2; color: #e37400; border: 1.5px solid #fde7b0; }
  .btn-action-pill.warning:hover { background: #fde7b0; }

  .action-divider { width: 1px; height: 24px; background: #e8eaed; }

  /* ===== META STRIP ===== */
  .meta-strip {
    display: flex;
    align-items: center;
    gap: 0;
    background: #f8f9fa;
    border-bottom: 1px solid #e8eaed;
    flex-shrink: 0;
    overflow-x: auto;
  }
  .meta-strip-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    border-right: 1px solid #e8eaed;
    white-space: nowrap;
  }
  .meta-strip-item:last-child { border-right: none; }
  .strip-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #9aa0a6; }
  .strip-value { font-size: 13px; font-weight: 500; color: #202124; }
  .cat-badge { background: #e6f4ea; color: #188038; font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 20px; }

  /* ===== PDF FRAME ===== */
  .pdf-container {
    flex: 1;
    background: #525659;
    position: relative;
    overflow: hidden;
  }
  .pdf-container iframe {
    width: 100%;
    height: 100%;
    border: none;
    display: block;
  }
  .pdf-loading {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 14px;
    color: rgba(255,255,255,.8);
    font-size: 14px;
    background: #525659;
    z-index: 2;
    transition: opacity .3s;
  }
  .pdf-loading.hidden { opacity: 0; pointer-events: none; }
  .spinner-ring {
    width: 44px; height: 44px;
    border: 3px solid rgba(255,255,255,.15);
    border-top-color: #4ca3ff;
    border-radius: 50%;
    animation: spin .9s linear infinite;
  }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* Tags in meta */
  .tags-strip { display: flex; gap: 5px; flex-wrap: wrap; }
  .tag-chip { background: #e8f0fe; color: #1a73e8; font-size: 11px; font-weight: 500; padding: 3px 9px; border-radius: 20px; }
</style>
@endpush

@section('content')

  {{-- TOP BAR --}}
  <div class="preview-topbar">

    <a href="{{ url()->previous() }}" class="btn-back">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
      Kembali
    </a>

    <div class="preview-doc-info">
      <div class="preview-doc-title">{{ $document->title }}</div>
      <div class="preview-doc-meta">
        @if($document->nomor_surat)
          <div class="meta-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 8h10M7 12h10M7 16h6"/></svg>
            {{ $document->nomor_surat }}
          </div>
        @endif
        @if($document->tanggal_surat)
          <div class="meta-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            {{ $document->tanggal_surat->format('d M Y') }}
          </div>
        @endif
      </div>
    </div>

    <div class="preview-actions">
      <a href="{{ route('documents.download', $document->id) }}" class="btn-action-pill secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Unduh
      </a>
      <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="btn-action-pill secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
        Buka Tab Baru
      </a>
      <div class="action-divider"></div>
      <a href="{{ route('documents.edit', $document->id) }}" class="btn-action-pill warning">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit
      </a>
    </div>
  </div>

  {{-- META STRIP --}}
  <div class="meta-strip">
    @if($document->category)
      <div class="meta-strip-item">
        <div>
          <div class="strip-label">Kategori</div>
          <div class="strip-value"><span class="cat-badge">{{ $document->category->name }}</span></div>
        </div>
      </div>
    @endif

    @if($document->perihal)
      <div class="meta-strip-item">
        <div>
          <div class="strip-label">Perihal</div>
          <div class="strip-value" style="max-width:340px;white-space:normal;line-height:1.4">{{ $document->perihal }}</div>
        </div>
      </div>
    @endif

    @php
      $tags = is_array($document->tags) ? $document->tags : json_decode($document->tags, true);
      $tags = array_filter(array_map('trim', (array) $tags));
    @endphp
    @if(count($tags) > 0)
      <div class="meta-strip-item">
        <div>
          <div class="strip-label">Tags</div>
          <div class="strip-value">
            <div class="tags-strip">
              @foreach($tags as $t)
                <span class="tag-chip"># {{ $t }}</span>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endif

    @if($document->file_path)
      <div class="meta-strip-item" style="margin-left:auto;border-right:none">
        <div>
          <div class="strip-label">File</div>
          <div class="strip-value" style="color:#9aa0a6;font-size:12px">📄 PDF</div>
        </div>
      </div>
    @endif
  </div>

  {{-- PDF VIEWER --}}
  <div class="pdf-container">
    <div class="pdf-loading" id="pdfLoading">
      <div class="spinner-ring"></div>
      <span>Memuat dokumen…</span>
    </div>
    <iframe
      src="{{ asset('storage/' . $document->file_path) }}"
      title="Preview: {{ $document->title }}"
      onload="document.getElementById('pdfLoading').classList.add('hidden')"
    ></iframe>
  </div>

@endsection
