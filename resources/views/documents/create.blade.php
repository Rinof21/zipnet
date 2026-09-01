@extends('layouts.app2')

@section('title', 'Upload Dokumen')

@push('styles')
<style>
  /* ===== PAGE LAYOUT ===== */
  .create-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 24px;
    align-items: start;
  }

  /* ===== SIDEBAR INFO CARD ===== */
  .info-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    overflow: hidden;
    position: sticky;
    top: 80px;
  }
  .info-card-header {
    padding: 18px 20px;
    background: linear-gradient(135deg, #0f1117, #1a2340);
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .info-card-header-icon {
    width: 32px; height: 32px;
    border-radius: 8px;
    background: rgba(26,115,232,.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
  }
  .info-card-header h6 {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    margin: 0;
  }

  .info-card-body { padding: 20px; }

  .info-tip {
    font-size: 13px;
    color: #4d5156;
    line-height: 1.6;
    margin-bottom: 16px;
  }

  .info-highlight {
    background: #e8f0fe;
    border-left: 3px solid #1a73e8;
    border-radius: 0 8px 8px 0;
    padding: 10px 14px;
    font-size: 12.5px;
    color: #174ea6;
    margin-bottom: 18px;
    line-height: 1.5;
  }

  .info-divider { height: 1px; background: #e8eaed; margin: 16px 0; }

  /* Add category inline */
  .btn-add-cat {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: transparent;
    border: 1.5px dashed #dadce0;
    border-radius: 8px;
    padding: 10px;
    font-size: 13px;
    font-weight: 500;
    color: #5f6368;
    cursor: pointer;
    font-family: "Inter", sans-serif;
    transition: border-color .15s, color .15s, background .15s;
  }
  .btn-add-cat:hover {
    border-color: #1a73e8;
    color: #1a73e8;
    background: #e8f0fe;
  }

  .add-cat-form {
    display: none;
    margin-top: 14px;
    background: #f8f9fa;
    border: 1px solid #e8eaed;
    border-radius: 10px;
    padding: 14px;
  }
  .add-cat-form.show { display: block; }

  .mini-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #70757a;
    margin-bottom: 6px;
    display: block;
  }
  .mini-input {
    width: 100%;
    border: 1.5px solid #e8eaed;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    font-family: "Inter", sans-serif;
    color: #202124;
    outline: none;
    background: #fff;
    margin-bottom: 10px;
    transition: border-color .2s;
  }
  .mini-input:focus { border-color: #1a73e8; }
  .mini-actions { display: flex; gap: 8px; }
  .btn-mini-save {
    flex: 1;
    background: #1a73e8;
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 7px;
    font-size: 12px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    transition: background .15s;
  }
  .btn-mini-save:hover { background: #1557b0; }
  .btn-mini-cancel {
    background: transparent;
    color: #70757a;
    border: 1px solid #e8eaed;
    border-radius: 7px;
    padding: 7px 12px;
    font-size: 12px;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    transition: background .15s;
  }
  .btn-mini-cancel:hover { background: #f1f3f4; }

  /* ===== MAIN FORM CARD ===== */
  .form-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    overflow: hidden;
  }
  .form-card-header {
    padding: 20px 28px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .form-card-icon {
    width: 40px; height: 40px;
    background: #e8f0fe;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #1a73e8;
  }
  .form-card-title { font-size: 16px; font-weight: 700; color: #202124; }
  .form-card-sub { font-size: 12.5px; color: #70757a; margin-top: 2px; }

  .form-card-body { padding: 28px; }

  /* ===== FORM ELEMENTS ===== */
  .form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }

  .field-group { margin-bottom: 22px; }

  .field-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #3c4043;
    margin-bottom: 8px;
  }
  .field-label .required { color: #d93025; }

  .field-input {
    width: 100%;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 11px 14px;
    font-size: 14px;
    font-family: "Inter", sans-serif;
    color: #202124;
    outline: none;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
  }
  .field-input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,.1);
  }
  .field-input::placeholder { color: #bdc1c6; }
  .field-input.is-error { border-color: #d93025; }
  .field-input.is-error:focus { box-shadow: 0 0 0 3px rgba(217,48,37,.1); }

  .field-hint {
    font-size: 12px;
    color: #9aa0a6;
    margin-top: 5px;
  }

  .field-error-msg {
    font-size: 12px;
    color: #d93025;
    margin-top: 5px;
    display: flex;
    align-items: center;
    gap: 5px;
  }

  /* File upload zone */
  .file-zone {
    border: 2px dashed #dadce0;
    border-radius: 12px;
    padding: 32px 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color .2s, background .2s, box-shadow .2s;
    position: relative;
    background: #fafafa;
  }
  .file-zone:hover, .file-zone.drag-over { border-color: #1a73e8; background: #e8f0fe4d; box-shadow: 0 0 0 4px rgba(26, 115, 232, 0.1); }
  .file-zone.has-file { border-color: #188038; background: #e6f4ea33; }

  .file-zone input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
  }
  .file-icon { font-size: 36px; margin-bottom: 10px; }
  .file-zone-label { font-size: 14px; font-weight: 600; color: #3c4043; margin-bottom: 4px; }
  .file-zone-sub { font-size: 12px; color: #9aa0a6; }
  .file-name-display {
    display: none;
    font-size: 13px;
    font-weight: 600;
    color: #188038;
    margin-top: 8px;
    align-items: center;
    gap: 6px;
    justify-content: center;
  }
  .file-name-display.show { display: flex; }

  /* Tags input with chips */
  .tags-input-wrap { position: relative; }
  .tags-hint { font-size: 12px; color: #9aa0a6; margin-top: 5px; }
  .tags-preview { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
  .tag-chip {
    background: #e8f0fe;
    color: #1a73e8;
    font-size: 12px;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
    display: none;
  }

  /* Divider */
  .form-section-divider {
    height: 1px;
    background: #f0f0f0;
    margin: 4px 0 24px;
  }
  .form-section-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
    color: #9aa0a6;
    margin-bottom: 18px;
  }

  /* Footer actions */
  .form-actions {
    display: flex;
    align-items: center;
    gap: 12px;
    padding-top: 8px;
  }
  .btn-save {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #1a73e8;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px 28px;
    font-size: 14px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    transition: background .15s, box-shadow .15s, transform .1s;
  }
  .btn-save:hover { background: #1557b0; box-shadow: 0 4px 16px rgba(26,115,232,.35); }
  .btn-save:active { transform: scale(.99); }

  .btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: transparent;
    color: #5f6368;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 11px 22px;
    font-size: 14px;
    font-weight: 500;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, border-color .15s;
  }
  .btn-back:hover { background: #f1f3f4; border-color: #dadce0; color: #202124; }

  /* Validation errors global */
  .errors-box {
    background: #fce8e6;
    border: 1px solid #f5c6c4;
    border-radius: 10px;
    padding: 14px 18px;
    margin-bottom: 22px;
    font-size: 13px;
    color: #d93025;
  }
  .errors-box ul { margin: 6px 0 0 16px; padding: 0; }
  .errors-box li { margin-bottom: 2px; }

  @media (max-width: 900px) {
    .create-layout { grid-template-columns: 1fr; }
    .info-card { position: static; }
    .form-row-2 { grid-template-columns: 1fr; }
  }

  /* Toggle Switch */
  .switch-wrap { position: relative; display: inline-block; width: 48px; height: 26px; flex-shrink: 0; }
  .switch-wrap input { opacity: 0; width: 0; height: 0; position: absolute; pointer-events: none; }
  .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #dadce0; transition: background-color .2s ease; border-radius: 26px; }
  .switch-slider::before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: #ffffff; transition: transform .2s ease; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,.2); }
  .switch-wrap input:checked + .switch-slider { background-color: #1a73e8; }
  .switch-wrap input:checked + .switch-slider::before { transform: translateX(22px); }
  .switch-wrap.orange input:checked + .switch-slider { background-color: #e37400; }
</style>
@endpush

@section('content')

  {{-- Back button + page heading --}}
  <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:22px">
    <div>
      <div style="font-size:20px;font-weight:700;color:#202124">Upload Dokumen</div>
      <div style="font-size:13px;color:#70757a">Tambah arsip dokumen baru ke sistem</div>
    </div>
    <a href="{{ route('documents.search') }}" style="display:flex;align-items:center;gap:6px;font-size:13px;color:#70757a;text-decoration:none;padding:6px 12px;border:1px solid #e8eaed;border-radius:8px;background:#fff;transition:background .15s" onmouseover="this.style.background='#f1f3f4'" onmouseout="this.style.background='#fff'">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
      Kembali
    </a>
  </div>

  {{-- Validation errors --}}
  @if ($errors->any())
    <div class="errors-box">
      <strong>Terdapat kesalahan pada form:</strong>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="create-layout">

    {{-- ===== LEFT: Info Panel ===== --}}
    <div class="info-card">
      <div class="info-card-header">
        <div class="info-card-icon">📋</div>
        <h6>Panduan Pengisian</h6>
      </div>
      <div class="info-card-body">
        <p class="info-tip">Isi semua field yang diperlukan dengan data surat yang akurat agar arsip mudah ditemukan saat pencarian.</p>

        <div class="info-highlight">
          💡 Gunakan <strong>Tags</strong> dengan kata kunci relevan (pisah dengan koma) untuk memudahkan pencarian.
        </div>

        <div class="info-divider"></div>
        <p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#9aa0a6;margin-bottom:12px">Kategori Dokumen</p>
        <p class="info-tip" style="font-size:12.5px;margin-bottom:14px">Tidak ada kategori yang sesuai? Tambahkan kategori baru di sini.</p>

        <button id="btnTambahKategori" class="btn-add-cat">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
          Tambah Kategori Baru
        </button>

        <div id="formTambahKategori" class="add-cat-form">
          <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <span class="mini-label">Nama Kategori</span>
            <input type="text" name="name" class="mini-input" placeholder="Masukkan nama kategori..." required>
            <div class="mini-actions">
              <button type="submit" class="btn-mini-save">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Simpan
              </button>
              <button type="button" id="btnBatalKategori" class="btn-mini-cancel">Batal</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- ===== RIGHT: Form Card ===== --}}
    <div class="form-card">
      <div class="form-card-header">
        <div class="form-card-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        </div>
        <div>
          <div class="form-card-title">Form Upload Dokumen</div>
          <div class="form-card-sub">Isi semua informasi surat dengan lengkap dan benar</div>
        </div>
      </div>

      <div class="form-card-body">
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
          @csrf

          {{-- SECTION: Informasi Surat --}}
          <div class="form-section-label">Informasi Surat</div>

          <div class="form-row-2">
            {{-- Kategori --}}
            <div class="field-group">
              <label class="field-label" for="category_id">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Kategori <span class="required">*</span>
              </label>
              <select name="category_id" id="category_id" class="field-input" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>

            {{-- Tanggal Surat --}}
            <div class="field-group">
              <label class="field-label" for="tanggal_surat">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Tanggal Surat
              </label>
              <input type="date" name="tanggal_surat" id="tanggal_surat" class="field-input {{ $errors->has('tanggal_surat') ? 'is-error' : '' }}" value="{{ old('tanggal_surat') }}">
            </div>
          </div>

          {{-- Judul --}}
          <div class="field-group">
            <label class="field-label" for="title">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
              Judul Dokumen <span class="required">*</span>
            </label>
            <input type="text" name="title" id="title" class="field-input {{ $errors->has('title') ? 'is-error' : '' }}" placeholder="Contoh: SK Rektor Nomor 001 Tahun 2025" value="{{ old('title') }}" required>
            @error('title') <div class="field-error-msg">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="form-row-2">
            {{-- Nomor Surat --}}
            <div class="field-group">
              <label class="field-label" for="nomor_surat">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 8h10M7 12h10M7 16h6"/></svg>
                Nomor Surat <span class="required">*</span>
              </label>
              <input type="text" name="nomor_surat" id="nomor_surat" class="field-input {{ $errors->has('nomor_surat') ? 'is-error' : '' }}" placeholder="Contoh: 123/UN22/PP/2025" value="{{ old('nomor_surat') }}" required>
              @error('nomor_surat') <div class="field-error-msg">⚠ {{ $message }}</div> @enderror
            </div>

            {{-- Tags --}}
            <div class="field-group">
              <label class="field-label" for="tags">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                Tags
              </label>
              <div class="tags-input-wrap">
                <input type="text" name="tags" id="tagsInput" class="field-input" placeholder="Contoh: osce, data, fakultas" value="{{ old('tags') }}">
                <div class="tags-hint">Pisahkan dengan koma</div>
                <div class="tags-preview" id="tagsPreview"></div>
              </div>
            </div>
          </div>

          {{-- Perihal --}}
          <div class="field-group">
            <label class="field-label" for="perihal">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              Perihal <span class="required">*</span>
            </label>
            <input type="text" name="perihal" id="perihal" class="field-input {{ $errors->has('perihal') ? 'is-error' : '' }}" placeholder="Contoh: Permohonan Data OSCE Mahasiswa" value="{{ old('perihal') }}" required>
            @error('perihal') <div class="field-error-msg">⚠ {{ $message }}</div> @enderror
          </div>

          {{-- Akses Publik Toggle --}}
          <div class="field-group" style="background:#f8f9fa;border:1.5px solid #e8eaed;border-radius:12px;padding:16px 20px;margin-bottom:14px">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:16px">
              <div>
                <div style="font-size:13.5px;font-weight:600;color:#202124;display:flex;align-items:center;gap:6px">
                  🌐 Akses Publik (Dapat dicari tanpa login)
                </div>
                <div style="font-size:12px;color:#70757a;margin-top:2px">
                  Jika dicentang, dokumen ini dapat dicari & dibuka oleh pengunjung publik.
                </div>
              </div>
              <label class="switch-wrap">
                <input type="checkbox" name="is_public" value="1" {{ old('is_public', '1') ? 'checked' : '' }}>
                <span class="switch-slider"></span>
              </label>
            </div>
          </div>

          {{-- Rahasia / Khusus Pengupload Toggle --}}
          <div class="field-group" style="background:#fffbf5;border:1.5px solid #fde7b0;border-radius:12px;padding:16px 20px;margin-bottom:22px">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:16px">
              <div>
                <div style="font-size:13.5px;font-weight:600;color:#e37400;display:flex;align-items:center;gap:6px">
                  🔐 Dokumen Rahasia (Hanya Saya yang dapat melihat)
                </div>
                <div style="font-size:12px;color:#7c3e00;margin-top:2px">
                  Jika dicentang, dokumen ini hanya dapat dilihat, dicari, & diunduh oleh Anda sendiri (dan Super Admin). Admin lain tidak dapat melihatnya.
                </div>
              </div>
              <label class="switch-wrap orange">
                <input type="checkbox" name="is_private_to_uploader" value="1" {{ old('is_private_to_uploader') ? 'checked' : '' }}>
                <span class="switch-slider"></span>
              </label>
            </div>
          </div>

          <div class="form-section-divider"></div>
          <div class="form-section-label">File Dokumen</div>

          {{-- File Upload Zone --}}
          <div class="field-group">
            <label class="field-label">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              File PDF Utama <span class="required">*</span>
            </label>
            <div class="file-zone" id="fileZone">
              <input type="file" name="file" id="fileInput" accept="application/pdf" required>
              <div class="file-icon">📄</div>
              <div class="file-zone-label">Pilih atau seret file PDF utama di sini</div>
              <div class="file-zone-sub">Format: PDF | Maksimal: 10 MB</div>
              <div class="file-name-display" id="fileNameDisplay">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <span id="fileNameText"></span>
              </div>
            </div>
            @error('file') <div class="field-error-msg">⚠ {{ $message }}</div> @enderror
          </div>

          {{-- Lampiran Tambahan --}}
          <div class="field-group" style="margin-top:20px">
            <label class="field-label" for="attachmentInput">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57a4 4 0 1 1 5.66 5.66l-8.59 8.58a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
              Lampiran Tambahan (Opsional — Bisa pilih beberapa file sekaligus)
            </label>
            <input type="file" name="attachments[]" id="attachmentInput" multiple class="field-input" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx" onchange="displayAttachmentNames(this)">
            <div class="field-hint">Format didukung: PDF, Word, Excel, Gambar (Maks 10MB per file)</div>
            <div id="attachmentList" style="display:flex;flex-direction:column;gap:6px;margin-top:10px"></div>
          </div>

          {{-- Actions --}}
          <div class="form-actions">
            <button type="submit" class="btn-save" id="btnSave">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              Simpan Dokumen
            </button>
            <a href="{{ route('documents.search') }}" class="btn-back">
              Batal
            </a>
          </div>

        </form>
      </div>
    </div>

  </div>

@endsection

@push('scripts')
<script>
  // Toggle add category form
  const btnTambah = document.getElementById('btnTambahKategori');
  const formTambah = document.getElementById('formTambahKategori');
  const btnBatal  = document.getElementById('btnBatalKategori');

  if (btnTambah) {
    btnTambah.addEventListener('click', () => {
      formTambah.classList.add('show');
      btnTambah.style.display = 'none';
    });
  }
  if (btnBatal) {
    btnBatal.addEventListener('click', () => {
      formTambah.classList.remove('show');
      btnTambah.style.display = 'flex';
    });
  }

  function displayAttachmentNames(input) {
    const container = document.getElementById('attachmentList');
    if (!container) return;
    container.innerHTML = '';
    if (input.files && input.files.length > 0) {
      Array.from(input.files).forEach((file, idx) => {
        const chip = document.createElement('div');
        chip.style.cssText = 'font-size:12.5px;color:#174ea6;background:#e8f0fe;padding:6px 12px;border-radius:8px;display:flex;align-items:center;gap:6px;width:fit-content';
        chip.innerHTML = '📎 <strong>Lampiran ' + (idx + 1) + ':</strong> ' + file.name + ' <span style="color:#70757a">(' + (file.size / 1024 / 1024).toFixed(2) + ' MB)</span>';
        container.appendChild(chip);
      });
    }
  }

  // File input display & drag-and-drop
  const fileInput   = document.getElementById('fileInput');
  const fileZone    = document.getElementById('fileZone');
  const fileDisplay = document.getElementById('fileNameDisplay');
  const fileNameTxt = document.getElementById('fileNameText');

  function updateFileDisplay(file) {
    if (file) {
      const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
      fileNameTxt.textContent = `${file.name} (${sizeMB} MB)`;
      fileDisplay.classList.add('show');
      fileZone.classList.add('has-file');
    } else {
      fileNameTxt.textContent = '';
      fileDisplay.classList.remove('show');
      fileZone.classList.remove('has-file');
    }
  }

  if (fileInput) {
    fileInput.addEventListener('change', () => {
      if (fileInput.files && fileInput.files.length > 0) {
        updateFileDisplay(fileInput.files[0]);
      } else {
        updateFileDisplay(null);
      }
    });
  }

  // Drag & drop logic
  if (fileZone && fileInput) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      fileZone.addEventListener(eventName, e => {
        e.preventDefault();
        e.stopPropagation();
      }, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
      fileZone.addEventListener(eventName, () => {
        fileZone.classList.add('drag-over');
      }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
      fileZone.addEventListener(eventName, () => {
        fileZone.classList.remove('drag-over');
      }, false);
    });

    fileZone.addEventListener('drop', e => {
      const dt = e.dataTransfer;
      if (dt && dt.files && dt.files.length > 0) {
        const file = dt.files[0];
        
        // Validate PDF extension/type
        if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
          alert('File yang diseret harus berformat PDF!');
          return;
        }

        // Validate max size 10MB
        if (file.size > 10 * 1024 * 1024) {
          alert('Ukuran file maksimal adalah 10 MB!');
          return;
        }

        try {
          const container = new DataTransfer();
          container.items.add(file);
          fileInput.files = container.files;
          fileInput.dispatchEvent(new Event('change', { bubbles: true }));
        } catch (err) {
          console.error('Error setting dropped file:', err);
        }
      }
    }, false);
  }

  // Live tags preview
  const tagsInput   = document.getElementById('tagsInput');
  const tagsPreview = document.getElementById('tagsPreview');

  function renderTags(value) {
    tagsPreview.innerHTML = '';
    const tags = value.split(',').map(t => t.trim()).filter(Boolean);
    tags.forEach(tag => {
      const chip = document.createElement('span');
      chip.className = 'tag-chip';
      chip.textContent = tag;
      chip.style.display = 'inline-block';
      tagsPreview.appendChild(chip);
    });
  }

  if (tagsInput) {
    tagsInput.addEventListener('input', () => renderTags(tagsInput.value));
    if (tagsInput.value) renderTags(tagsInput.value);
  }

  // Submit loading state
  const form    = document.getElementById('uploadForm');
  const btnSave = document.getElementById('btnSave');
  if (form && btnSave) {
    form.addEventListener('submit', () => {
      btnSave.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan...';
      btnSave.disabled = true;
      btnSave.style.opacity = '.75';
    });
  }

  // Toggle mutual exclusion
  const publicToggle  = document.querySelector('input[name="is_public"]');
  const privateToggle = document.querySelector('input[name="is_private_to_uploader"]');
  if (publicToggle && privateToggle) {
    privateToggle.addEventListener('change', function() {
      if (this.checked) publicToggle.checked = false;
    });
    publicToggle.addEventListener('change', function() {
      if (this.checked) privateToggle.checked = false;
    });
  }
</script>
@endpush
