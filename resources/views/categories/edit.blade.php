@extends('layouts.app2')

@section('title', 'Edit Kategori')

@push('styles')
<style>
  .edit-wrap {
    max-width: 560px;
    margin: 0 auto;
  }

  .edit-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    overflow: hidden;
  }

  .edit-card-header {
    padding: 20px 28px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .edit-card-icon {
    width: 40px; height: 40px;
    background: #fef3e2;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
  }
  .edit-card-title { font-size: 16px; font-weight: 700; color: #202124; }
  .edit-card-sub { font-size: 12.5px; color: #70757a; margin-top: 2px; }

  .edit-card-body { padding: 28px; }

  .field-group { margin-bottom: 24px; }
  .field-label { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #3c4043; margin-bottom: 8px; }
  .field-label .required { color: #d93025; }

  .field-input {
    width: 100%;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 12px 14px;
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

  .field-hint { font-size: 12px; color: #9aa0a6; margin-top: 5px; }

  .form-actions { display: flex; gap: 10px; padding-top: 4px; }

  .btn-update {
    display: inline-flex; align-items: center; gap: 8px;
    background: #1a73e8; color: #fff; border: none;
    border-radius: 10px; padding: 12px 28px; font-size: 14px; font-weight: 600;
    font-family: "Inter", sans-serif; cursor: pointer;
    transition: background .15s, box-shadow .15s;
  }
  .btn-update:hover { background: #1557b0; box-shadow: 0 4px 16px rgba(26,115,232,.35); }

  .btn-cancel {
    display: inline-flex; align-items: center; gap: 8px;
    background: transparent; color: #5f6368; border: 1.5px solid #e8eaed;
    border-radius: 10px; padding: 11px 22px; font-size: 14px; font-weight: 500;
    font-family: "Inter", sans-serif; cursor: pointer; text-decoration: none;
    transition: background .15s;
  }
  .btn-cancel:hover { background: #f1f3f4; color: #202124; }
</style>
@endpush

@section('content')

  <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px">
    <a href="{{ route('categories.index') }}" style="display:flex;align-items:center;gap:6px;font-size:13px;color:#70757a;text-decoration:none;padding:6px 12px;border:1px solid #e8eaed;border-radius:8px;transition:background .15s" onmouseover="this.style.background='#f1f3f4'" onmouseout="this.style.background='transparent'">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
      Kembali ke Kategori
    </a>
    <div>
      <div style="font-size:20px;font-weight:700;color:#202124">Edit Kategori</div>
      <div style="font-size:13px;color:#70757a">Ubah nama kategori dokumen</div>
    </div>
  </div>

  <div class="edit-wrap">
    <div class="edit-card">
      <div class="edit-card-header">
        <div class="edit-card-icon">✏️</div>
        <div>
          <div class="edit-card-title">Edit Kategori</div>
          <div class="edit-card-sub">Mengubah: <strong>{{ $category->name }}</strong></div>
        </div>
      </div>
      <div class="edit-card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="field-group">
            <label class="field-label" for="name">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
              Nama Kategori <span class="required">*</span>
            </label>
            <input
              type="text"
              name="name"
              id="name"
              class="field-input"
              value="{{ old('name', $category->name) }}"
              placeholder="Masukkan nama kategori..."
              required
              autofocus
            >
            <div class="field-hint">Gunakan nama yang jelas dan deskriptif</div>
            @error('name')
              <div style="font-size:12px;color:#d93025;margin-top:5px">⚠ {{ $message }}</div>
            @enderror
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-update">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              Simpan Perubahan
            </button>
            <a href="{{ route('categories.index') }}" class="btn-cancel">Batal</a>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection
