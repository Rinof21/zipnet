@extends('layouts.app2')

@section('title', 'Pengaturan PIN Publik')

@push('styles')
<style>
  .settings-layout {
    max-width: 720px;
    margin: 0 auto;
  }

  .settings-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.03);
  }

  .settings-card-header {
    padding: 22px 28px;
    background: linear-gradient(135deg, #0f1117, #1a2340);
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .settings-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(26,115,232,.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
  }

  .settings-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
  }

  .settings-card-sub {
    font-size: 12.5px;
    color: rgba(255,255,255,.7);
    margin-top: 2px;
  }

  .settings-card-body {
    padding: 28px;
  }

  /* Toggle Switch */
  .switch-box {
    background: #f8f9fa;
    border: 1.5px solid #e8eaed;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
  }

  .switch-wrap {
    position: relative;
    display: inline-block;
    width: 52px;
    height: 28px;
    flex-shrink: 0;
  }
  .switch-wrap input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
  }
  .switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #dadce0;
    transition: background-color .2s ease;
    border-radius: 28px;
  }
  .switch-slider::before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background-color: #ffffff;
    transition: transform .2s ease;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,.2);
  }
  .switch-wrap input:checked + .switch-slider {
    background-color: #1a73e8;
  }
  .switch-wrap input:checked + .switch-slider::before {
    transform: translateX(24px);
  }

  .field-group {
    margin-bottom: 24px;
    margin-top: 20px;
  }
  .field-label {
    font-size: 13.5px;
    font-weight: 600;
    color: #3c4043;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
  }
  .field-input-wrap {
    position: relative;
  }
  .field-input {
    width: 100%;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 12px 44px 12px 14px;
    font-size: 15px;
    font-family: monospace, sans-serif;
    letter-spacing: 2px;
    color: #202124;
    outline: none;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
  }
  .field-input:focus {
    border-color: #1a73e8;
    box-shadow: 0 0 0 3px rgba(26,115,232,.1);
  }

  .btn-toggle-pin {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #70757a;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
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
    transition: background .15s, box-shadow .15s;
  }
  .btn-save:hover {
    background: #1557b0;
    box-shadow: 0 4px 16px rgba(26,115,232,.35);
  }

  .alert-success {
    background: #e6f4ea;
    border: 1px solid #a8d5b5;
    color: #188038;
    border-radius: 10px;
    padding: 12px 18px;
    font-size: 13.5px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
</style>
@endpush

@section('content')

  <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;margin-bottom:22px">
    <div>
      <div style="font-size:20px;font-weight:700;color:#202124">Pengaturan PIN Akses Publik</div>
      <div style="font-size:13px;color:#70757a">Kelola proteksi PIN untuk Pencarian Publik dan Preview Dokumen</div>
    </div>
  </div>

  @if (session('success'))
    <div class="alert-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif

  @if ($errors->any())
    <div style="background:#fce8e6;border:1px solid #f5c6c4;color:#d93025;border-radius:10px;padding:12px 18px;font-size:13px;margin-bottom:20px">
      <strong>Terjadi kesalahan:</strong>
      <ul style="margin:4px 0 0 16px;padding:0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="settings-layout">
    <div class="settings-card">
      <div class="settings-card-header">
        <div class="settings-icon">🔑</div>
        <div>
          <div class="settings-card-title">Proteksi PIN Halaman Publik</div>
          <div class="settings-card-sub">Atur penguncian pencarian publik dan preview file menggunakan PIN</div>
        </div>
      </div>

      <div class="settings-card-body">
        <form action="{{ route('settings.public-pin.update') }}" method="POST">
          @csrf

          {{-- Switch 1: Public Search Protection --}}
          <div class="switch-box">
            <div>
              <div style="font-size:14px;font-weight:600;color:#202124;display:flex;align-items:center;gap:6px">
                🔍 Proteksi Halaman Utama / Pencarian Publik
              </div>
              <div style="font-size:12.5px;color:#70757a;margin-top:2px">
                Jika diaktifkan, pengunjung wajib memasukkan PIN saat mengakses Halaman Utama & Pencarian Publik (<code style="background:#e8eaed;padding:1px 5px;border-radius:4px">/</code> & <code style="background:#e8eaed;padding:1px 5px;border-radius:4px">/arsip</code>).
              </div>
            </div>
            <label class="switch-wrap">
              <input type="checkbox" name="public_pin_enabled" value="1" {{ $pinEnabled ? 'checked' : '' }}>
              <span class="switch-slider"></span>
            </label>
          </div>

          {{-- Switch 2: Document Preview Protection --}}
          <div class="switch-box">
            <div>
              <div style="font-size:14px;font-weight:600;color:#202124;display:flex;align-items:center;gap:6px">
                📄 Proteksi Preview / Buka File Dokumen
              </div>
              <div style="font-size:12.5px;color:#70757a;margin-top:2px">
                Jika diaktifkan, pengunjung wajib memasukkan PIN saat membuka/preview file PDF dokumen (<code style="background:#e8eaed;padding:1px 5px;border-radius:4px">/preview/id</code>).
              </div>
            </div>
            <label class="switch-wrap">
              <input type="checkbox" name="public_preview_pin_enabled" value="1" {{ $previewPinEnabled ? 'checked' : '' }}>
              <span class="switch-slider"></span>
            </label>
          </div>

          {{-- PIN Input --}}
          <div class="field-group">
            <label class="field-label" for="public_pin">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              Kode PIN Akses Publik <span style="color:#d93025">*</span>
            </label>
            <div class="field-input-wrap">
              <input type="password" name="public_pin" id="public_pin" class="field-input" value="{{ old('public_pin', $pin) }}" required placeholder="Masukkan PIN (contoh: 123456)">
              <button type="button" class="btn-toggle-pin" id="togglePinBtn" title="Tampilkan PIN">
                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            <div style="font-size:12px;color:#70757a;margin-top:6px">PIN berlaku untuk akses pencarian publik maupun preview file dokumen jika fitur proteksinya diaktifkan.</div>
          </div>

          <div style="border-top:1px solid #f0f0f0;padding-top:20px;display:flex;justify-content:flex-end">
            <button type="submit" class="btn-save">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
              Simpan Pengaturan
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  const toggleBtn = document.getElementById('togglePinBtn');
  const pinInput  = document.getElementById('public_pin');

  if (toggleBtn && pinInput) {
    toggleBtn.addEventListener('click', () => {
      const type = pinInput.getAttribute('type') === 'password' ? 'text' : 'password';
      pinInput.setAttribute('type', type);
    });
  }
</script>
@endpush
