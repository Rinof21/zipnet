@extends('layouts.app2')

@section('title', 'Edit Dokumen')

@push('styles')
<style>
  .edit-layout {
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 24px;
    align-items: start;
  }

  /* ===== INFO SIDEBAR ===== */
  .info-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; position: sticky; top: 80px; }
  .info-card-header { padding: 18px 20px; background: linear-gradient(135deg, #332a00, #5c4400); display: flex; align-items: center; gap: 10px; }
  .info-card-header-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,193,7,.2); display: flex; align-items: center; justify-content: center; font-size: 15px; }
  .info-card-header h6 { font-size: 14px; font-weight: 600; color: #fff; margin: 0; }
  .info-card-body { padding: 20px; }
  .info-tip { font-size: 13px; color: #4d5156; line-height: 1.6; margin-bottom: 14px; }
  .info-highlight { background: #fef3e2; border-left: 3px solid #e37400; border-radius: 0 8px 8px 0; padding: 10px 14px; font-size: 12.5px; color: #7c3e00; margin-bottom: 16px; line-height: 1.5; }
  .info-divider { height: 1px; background: #e8eaed; margin: 16px 0; }

  /* Current file info */
  .current-file-box { background: #f8f9fa; border: 1px solid #e8eaed; border-radius: 10px; padding: 14px; }
  .current-file-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #9aa0a6; margin-bottom: 8px; }
  .current-file-name { font-size: 12px; color: #3c4043; word-break: break-all; display: flex; align-items: flex-start; gap: 7px; line-height: 1.5; }
  .current-file-name svg { flex-shrink: 0; margin-top: 1px; color: #e37400; }

  .btn-preview-small {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    margin-top: 12px;
    padding: 9px;
    border: 1.5px solid #e8eaed;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
    color: #5f6368;
    background: #fff;
    text-decoration: none;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    transition: background .15s, border-color .15s;
  }
  .btn-preview-small:hover { background: #f1f3f4; border-color: #dadce0; color: #202124; }

  /* ===== MAIN FORM CARD ===== */
  .form-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; }
  .form-card-header { padding: 20px 28px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 14px; }
  .form-card-icon { width: 40px; height: 40px; background: #fef3e2; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #e37400; }
  .form-card-title { font-size: 16px; font-weight: 700; color: #202124; }
  .form-card-sub { font-size: 12.5px; color: #70757a; margin-top: 2px; }
  .form-card-body { padding: 28px; }

  /* Form elements */
  .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  .field-group { margin-bottom: 22px; }
  .field-label { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #3c4043; margin-bottom: 8px; }
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
  .field-input:focus { border-color: #e37400; box-shadow: 0 0 0 3px rgba(227,116,0,.1); }
  .field-input::placeholder { color: #bdc1c6; }

  .field-hint { font-size: 12px; color: #9aa0a6; margin-top: 5px; }

  /* Tags preview */
  .tags-preview { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
  .tag-chip { background: #e8f0fe; color: #1a73e8; font-size: 12px; font-weight: 500; padding: 4px 10px; border-radius: 20px; }

  /* Change indicator */
  .change-dot { width: 7px; height: 7px; border-radius: 50%; background: #e37400; display: none; flex-shrink: 0; }
  .field-input.changed + .change-dot, .field-input.changed ~ * .change-dot { display: inline-block; }

  /* Section divider */
  .form-section-divider { height: 1px; background: #f0f0f0; margin: 4px 0 24px; }
  .form-section-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: #9aa0a6; margin-bottom: 18px; }

  /* Form actions */
  .form-actions { display: flex; align-items: center; gap: 12px; padding-top: 8px; }

  .btn-save {
    display: inline-flex; align-items: center; gap: 8px;
    background: #e37400; color: #fff; border: none;
    border-radius: 10px; padding: 12px 28px; font-size: 14px; font-weight: 600;
    font-family: "Inter", sans-serif; cursor: pointer;
    transition: background .15s, box-shadow .15s, transform .1s;
  }
  .btn-save:hover { background: #c35f00; box-shadow: 0 4px 16px rgba(227,116,0,.35); }
  .btn-save:active { transform: scale(.99); }

  .btn-cancel {
    display: inline-flex; align-items: center; gap: 8px;
    background: transparent; color: #5f6368; border: 1.5px solid #e8eaed;
    border-radius: 10px; padding: 11px 22px; font-size: 14px; font-weight: 500;
    font-family: "Inter", sans-serif; cursor: pointer; text-decoration: none;
    transition: background .15s;
  }
  .btn-cancel:hover { background: #f1f3f4; color: #202124; }

  /* Validation errors */
  .errors-box { background: #fce8e6; border: 1px solid #f5c6c4; border-radius: 10px; padding: 14px 18px; margin-bottom: 22px; font-size: 13px; color: #d93025; }
  .errors-box ul { margin: 6px 0 0 16px; padding: 0; }

  /* Success alert */
  .alert-success-bar { background: #e6f4ea; border: 1px solid #a8d5b5; color: #188038; border-radius: 10px; padding: 12px 18px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }

  /* Toggle Switch */
  .switch-wrap { position: relative; display: inline-block; width: 48px; height: 26px; flex-shrink: 0; }
  .switch-wrap input { opacity: 0; width: 0; height: 0; position: absolute; pointer-events: none; }
  .switch-slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #dadce0; transition: background-color .2s ease; border-radius: 26px; }
  .switch-slider::before { position: absolute; content: ""; height: 20px; width: 20px; left: 3px; bottom: 3px; background-color: #ffffff; transition: transform .2s ease; border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,.2); }
  .switch-wrap input:checked + .switch-slider { background-color: #1a73e8; }
  .switch-wrap input:checked + .switch-slider::before { transform: translateX(22px); }
  .switch-wrap.orange input:checked + .switch-slider { background-color: #e37400; }
</style>
<script>
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
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
@endpush

@section('content')

  {{-- Back + heading --}}
  <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px">
    <a href="{{ route('documents.search') }}" style="display:flex;align-items:center;gap:6px;font-size:13px;color:#70757a;text-decoration:none;padding:6px 12px;border:1px solid #e8eaed;border-radius:8px;transition:background .15s" onmouseover="this.style.background='#f1f3f4'" onmouseout="this.style.background='transparent'">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
      Kembali
    </a>
    <div>
      <div style="font-size:20px;font-weight:700;color:#202124">Edit Dokumen</div>
      <div style="font-size:13px;color:#70757a">Perbarui informasi arsip dokumen</div>
    </div>
  </div>

  {{-- Validation errors --}}
  @if ($errors->any())
    <div class="errors-box">
      <strong>Terdapat kesalahan:</strong>
      <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  @if(session('success'))
    <div class="alert-success-bar">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif

  <div class="edit-layout">

    {{-- ===== LEFT SIDEBAR ===== --}}
    <div class="info-card">
      <div class="info-card-header">
        <div class="info-card-header-icon">✏️</div>
        <h6>Info Dokumen</h6>
      </div>
      <div class="info-card-body">
        <p class="info-tip">Perbarui data surat sesuai kebutuhan. Perubahan akan langsung tersimpan ke sistem arsip.</p>
        <div class="info-highlight">
          ⚠️ Pastikan nomor surat dan tanggal sesuai dengan dokumen fisik asli.
        </div>

        <div class="info-divider"></div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#9aa0a6;margin-bottom:10px">File Saat Ini</div>

        <div class="current-file-box">
          <div class="current-file-name">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
            {{ basename($document->file_path) }}
          </div>
        </div>

        <a href="{{ route('documents.preview', $document->id) }}" class="btn-preview-small" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
          Preview Dokumen
        </a>

        {{-- Meta info --}}
        <div class="info-divider"></div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#9aa0a6;margin-bottom:10px">Informasi Arsip</div>
        <div style="display:flex;flex-direction:column;gap:8px">
          <div style="display:flex;justify-content:space-between;font-size:12px">
            <span style="color:#70757a">ID Dokumen</span>
            <span style="font-weight:600;color:#202124">#{{ $document->id }}</span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:12px">
            <span style="color:#70757a">Dibuat</span>
            <span style="font-weight:600;color:#202124">{{ $document->created_at->format('d M Y') }}</span>
          </div>
          @if($document->category)
          <div style="display:flex;justify-content:space-between;font-size:12px;align-items:center">
            <span style="color:#70757a">Kategori</span>
            <span style="background:#e6f4ea;color:#188038;font-size:11px;font-weight:600;padding:3px 9px;border-radius:20px">{{ $document->category->name }}</span>
          </div>
          @endif
        </div>
      </div>
    </div>

    {{-- ===== MAIN FORM ===== --}}
    <div class="form-card">
      <div class="form-card-header">
        <div class="form-card-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <div>
          <div class="form-card-title">Edit Informasi Dokumen</div>
          <div class="form-card-sub">{{ Str::limit($document->title, 60) }}</div>
        </div>
      </div>

      <div class="form-card-body">
        <form action="{{ route('documents.update', $document->id) }}" method="POST" id="editForm">
          @csrf
          @method('PUT')

          <div class="form-section-label">Informasi Surat</div>

          {{-- Judul --}}
          <div class="field-group">
            <label class="field-label" for="title">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e37400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
              Judul Dokumen <span class="required">*</span>
            </label>
            <input type="text" name="title" id="title" class="field-input" value="{{ old('title', $document->title) }}" required>
          </div>

          <div class="form-row-2">
            {{-- Nomor Surat --}}
            <div class="field-group">
              <label class="field-label" for="nomor_surat">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e37400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M7 8h10M7 12h10M7 16h6"/></svg>
                Nomor Surat
              </label>
              <input type="text" name="nomor_surat" id="nomor_surat" class="field-input" value="{{ old('nomor_surat', $document->nomor_surat) }}" placeholder="Contoh: 123/UN22/PP/2025">
            </div>

            {{-- Tanggal --}}
            <div class="field-group">
              <label class="field-label" for="tanggal_surat">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e37400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Tanggal Surat
              </label>
              <input type="date" name="tanggal_surat" id="tanggal_surat" class="field-input" value="{{ old('tanggal_surat', $document->tanggal_surat ? $document->tanggal_surat->format('Y-m-d') : '') }}">
            </div>
          </div>

          {{-- Perihal --}}
          <div class="field-group">
            <label class="field-label" for="perihal">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e37400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              Perihal
            </label>
            <input type="text" name="perihal" id="perihal" class="field-input" value="{{ old('perihal', $document->perihal) }}" placeholder="Isi perihal surat...">
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
                <input type="checkbox" name="is_public" value="1" {{ old('is_public', $document->is_public) ? 'checked' : '' }}>
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
                <input type="checkbox" name="is_private_to_uploader" value="1" {{ old('is_private_to_uploader', $document->is_private_to_uploader) ? 'checked' : '' }}>
                <span class="switch-slider"></span>
              </label>
            </div>
          </div>

          <div class="form-row-2">
            {{-- Kategori --}}
            <div class="field-group">
              <label class="field-label" for="category_id">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e37400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                Kategori
              </label>
              <select name="category_id" id="category_id" class="field-input">
                <option value="">-- Tidak Ada --</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ $document->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>

            {{-- Tags --}}
            <div class="field-group">
              <label class="field-label" for="tags">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#e37400" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
                Tags
              </label>
              @php
                $currentTags = is_array($document->tags) ? $document->tags : json_decode($document->tags, true);
                $currentTags = array_filter(array_map('trim', (array) $currentTags));
                $tagsString  = implode(', ', $currentTags);
              @endphp
              <input type="text" name="tags" id="tagsInput" class="field-input" value="{{ old('tags', $tagsString) }}" placeholder="Contoh: osce, data, fakultas">
              <div class="field-hint">Pisahkan dengan koma</div>
              <div class="tags-preview" id="tagsPreview"></div>
            </div>
          </div>

          <div class="form-section-divider"></div>

          <div class="form-actions">
            <button type="submit" class="btn-save" id="btnSave">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              Simpan Perubahan
            </button>
            <a href="{{ route('documents.search') }}" class="btn-cancel">Batal</a>
          </div>

        </form>
      </div>
    </div>

  </div>

@endsection

@push('scripts')
<script>
  // Live tag chips
  const tagsInput   = document.getElementById('tagsInput');
  const tagsPreview = document.getElementById('tagsPreview');

  function renderTags(val) {
    tagsPreview.innerHTML = '';
    val.split(',').map(t => t.trim()).filter(Boolean).forEach(tag => {
      const chip = document.createElement('span');
      chip.className = 'tag-chip';
      chip.textContent = tag;
      tagsPreview.appendChild(chip);
    });
  }

  if (tagsInput) {
    tagsInput.addEventListener('input', () => renderTags(tagsInput.value));
    if (tagsInput.value) renderTags(tagsInput.value);
  }

  // Submit loading state
  const form    = document.getElementById('editForm');
  const btnSave = document.getElementById('btnSave');
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
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
@endpush
