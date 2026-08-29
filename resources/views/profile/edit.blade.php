@extends('layouts.app2')

@section('title', 'Profil Saya')

@push('styles')
<style>
  /* ===== PROFILE HERO ===== */
  .profile-hero {
    background: linear-gradient(135deg, #0f1117 0%, #1a2340 50%, #0d2340 100%);
    border-radius: 16px;
    padding: 28px 32px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 22px;
    position: relative;
    overflow: hidden;
  }
  .profile-hero::before {
    content: "";
    position: absolute;
    width: 300px; height: 300px;
    background: #1a73e8;
    border-radius: 50%;
    filter: blur(90px);
    opacity: .2;
    top: -80px; right: -60px;
    pointer-events: none;
  }

  .avatar-circle {
    width: 68px; height: 68px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
    border: 3px solid rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 26px;
    font-weight: 700;
    color: #fff;
    font-family: "Inter", sans-serif;
    flex-shrink: 0;
    position: relative; z-index: 1;
  }

  .profile-hero-info { flex: 1; position: relative; z-index: 1; }
  .profile-hero-name { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 4px; }
  .profile-hero-email { font-size: 13px; color: rgba(255,255,255,.5); margin-bottom: 8px; }
  .profile-hero-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(26,115,232,.25);
    border: 1px solid rgba(74,163,255,.3);
    color: #4ca3ff;
    font-size: 11px; font-weight: 600;
    padding: 4px 12px; border-radius: 20px;
  }

  /* ===== SECTION CARDS ===== */
  .section-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    align-items: start;
  }

  .section-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    overflow: hidden;
  }

  .section-card-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .section-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .section-icon.blue { background: #e8f0fe; color: #1a73e8; }
  .section-icon.green { background: #e6f4ea; color: #188038; }
  .section-icon.red { background: #fce8e6; color: #d93025; }

  .section-card-title { font-size: 15px; font-weight: 700; color: #202124; }
  .section-card-sub { font-size: 12px; color: #70757a; margin-top: 2px; }
  .section-card-body { padding: 24px; }

  /* ===== FORM ELEMENTS ===== */
  .field-group { margin-bottom: 20px; }
  .field-group:last-of-type { margin-bottom: 0; }

  .field-label {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 600; color: #3c4043;
    margin-bottom: 7px;
  }

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
  .field-input:focus { border-color: #1a73e8; box-shadow: 0 0 0 3px rgba(26,115,232,.1); }
  .field-input::placeholder { color: #bdc1c6; }
  .field-input.password-field { padding-right: 44px; }

  .field-error { font-size: 12px; color: #d93025; margin-top: 5px; display: flex; align-items: center; gap: 5px; }

  /* Password wrapper */
  .password-wrap { position: relative; }
  .toggle-pw {
    position: absolute; right: 12px; top: 50%;
    transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #9aa0a6; padding: 4px;
    display: flex; align-items: center;
    transition: color .15s;
  }
  .toggle-pw:hover { color: #5f6368; }

  /* Success toast */
  .success-toast {
    display: none;
    align-items: center;
    gap: 8px;
    background: #e6f4ea;
    border: 1px solid #a8d5b5;
    color: #188038;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13px;
    margin-bottom: 16px;
  }
  .success-toast.show { display: flex; }

  /* Form actions */
  .form-footer { display: flex; align-items: center; gap: 10px; margin-top: 20px; }

  .btn-save-blue {
    display: inline-flex; align-items: center; gap: 7px;
    background: #1a73e8; color: #fff; border: none;
    border-radius: 10px; padding: 11px 24px; font-size: 13px; font-weight: 600;
    font-family: "Inter", sans-serif; cursor: pointer;
    transition: background .15s;
  }
  .btn-save-blue:hover { background: #1557b0; }

  .btn-save-green {
    display: inline-flex; align-items: center; gap: 7px;
    background: #188038; color: #fff; border: none;
    border-radius: 10px; padding: 11px 24px; font-size: 13px; font-weight: 600;
    font-family: "Inter", sans-serif; cursor: pointer;
    transition: background .15s;
  }
  .btn-save-green:hover { background: #0d6b2e; }

  /* Delete zone */
  .delete-zone {
    grid-column: 1 / -1;
  }

  .danger-box {
    background: #fce8e6;
    border: 1px solid #f5c6c4;
    border-radius: 10px;
    padding: 16px 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 16px;
  }
  .danger-box-icon { font-size: 22px; flex-shrink: 0; }
  .danger-box-title { font-size: 14px; font-weight: 700; color: #d93025; margin-bottom: 4px; }
  .danger-box-text { font-size: 13px; color: #7c0000; line-height: 1.5; }

  .btn-danger {
    display: inline-flex; align-items: center; gap: 7px;
    background: #d93025; color: #fff; border: none;
    border-radius: 10px; padding: 11px 24px; font-size: 13px; font-weight: 600;
    font-family: "Inter", sans-serif; cursor: pointer;
    transition: background .15s;
  }
  .btn-danger:hover { background: #b31c12; }

  /* Modal */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.5);
    z-index: 800; display: none; align-items: center; justify-content: center;
    padding: 20px;
  }
  .modal-overlay.open { display: flex; }
  .modal-box {
    background: #fff; border-radius: 16px;
    padding: 32px; max-width: 440px; width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
  }
  .modal-icon { font-size: 36px; margin-bottom: 16px; }
  .modal-title { font-size: 18px; font-weight: 700; color: #202124; margin-bottom: 8px; }
  .modal-text { font-size: 13px; color: #5f6368; line-height: 1.6; margin-bottom: 20px; }
  .modal-actions { display: flex; gap: 10px; justify-content: flex-end; }
  .btn-modal-cancel {
    background: transparent; color: #5f6368; border: 1.5px solid #e8eaed;
    border-radius: 8px; padding: 9px 20px; font-size: 13px; font-weight: 500;
    font-family: "Inter", sans-serif; cursor: pointer; transition: background .15s;
  }
  .btn-modal-cancel:hover { background: #f1f3f4; }

  @media (max-width: 860px) { .section-grid { grid-template-columns: 1fr; } .delete-zone { grid-column: 1; } }
</style>
@endpush

@section('content')

  {{-- Profile Hero --}}
  <div class="profile-hero">
    <div class="avatar-circle">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    <div class="profile-hero-info">
      <div class="profile-hero-name">{{ auth()->user()->name }}</div>
      <div class="profile-hero-email">{{ auth()->user()->email }}</div>
      <span class="profile-hero-badge">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/></svg>
        Administrator
      </span>
    </div>
  </div>

  <div class="section-grid">

    {{-- ===== UPDATE PROFILE INFO ===== --}}
    <div class="section-card">
      <div class="section-card-header">
        <div class="section-icon blue">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
        </div>
        <div>
          <div class="section-card-title">Informasi Profil</div>
          <div class="section-card-sub">Perbarui nama dan alamat email akun</div>
        </div>
      </div>
      <div class="section-card-body">

        @if(session('status') === 'profile-updated')
          <div class="success-toast show">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Profil berhasil diperbarui.
          </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PATCH')

          <div class="field-group">
            <label class="field-label" for="name">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
              Nama Lengkap
            </label>
            <input type="text" name="name" id="name" class="field-input" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name') <div class="field-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="field-group">
            <label class="field-label" for="email">
              <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
              Alamat Email
            </label>
            <input type="email" name="email" id="email" class="field-input" value="{{ old('email', $user->email) }}" required>
            @error('email') <div class="field-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="form-footer">
            <button type="submit" class="btn-save-blue">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
              Simpan Profil
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- ===== UPDATE PASSWORD ===== --}}
    <div class="section-card">
      <div class="section-card-header">
        <div class="section-icon green">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <div>
          <div class="section-card-title">Ubah Password</div>
          <div class="section-card-sub">Gunakan password yang panjang dan acak</div>
        </div>
      </div>
      <div class="section-card-body">

        @if(session('status') === 'password-updated')
          <div class="success-toast show">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            Password berhasil diperbarui.
          </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          @method('PUT')

          <div class="field-group">
            <label class="field-label" for="current_password">Password Saat Ini</label>
            <div class="password-wrap">
              <input type="password" name="current_password" id="current_password" class="field-input password-field" placeholder="••••••••">
              <button type="button" class="toggle-pw" onclick="togglePw('current_password', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('current_password', 'updatePassword') <div class="field-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="field-group">
            <label class="field-label" for="password">Password Baru</label>
            <div class="password-wrap">
              <input type="password" name="password" id="password" class="field-input password-field" placeholder="Min. 8 karakter">
              <button type="button" class="toggle-pw" onclick="togglePw('password', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('password', 'updatePassword') <div class="field-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="field-group">
            <label class="field-label" for="password_confirmation">Konfirmasi Password Baru</label>
            <div class="password-wrap">
              <input type="password" name="password_confirmation" id="password_confirmation" class="field-input password-field" placeholder="Ulangi password baru">
              <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation', this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
            </div>
            @error('password_confirmation', 'updatePassword') <div class="field-error">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="form-footer">
            <button type="submit" class="btn-save-green">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
              Perbarui Password
            </button>
          </div>
        </form>
      </div>
    </div>

    {{-- ===== DELETE ACCOUNT ===== --}}
    <div class="section-card delete-zone">
      <div class="section-card-header">
        <div class="section-icon red">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
        </div>
        <div>
          <div class="section-card-title">Hapus Akun</div>
          <div class="section-card-sub">Tindakan ini tidak dapat dibatalkan</div>
        </div>
      </div>
      <div class="section-card-body">
        <div class="danger-box">
          <div class="danger-box-icon">⚠️</div>
          <div>
            <div class="danger-box-title">Perhatian!</div>
            <div class="danger-box-text">Setelah akun dihapus, semua data dan informasi terkait akan dihapus secara permanen. Pastikan Anda telah mengunduh semua data yang diperlukan sebelum melanjutkan.</div>
          </div>
        </div>
        <button type="button" class="btn-danger" onclick="document.getElementById('deleteModal').classList.add('open')">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
          Hapus Akun Saya
        </button>
      </div>
    </div>

  </div>

  {{-- Delete Confirmation Modal --}}
  <div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
      <div class="modal-icon">🗑️</div>
      <div class="modal-title">Hapus Akun Secara Permanen?</div>
      <div class="modal-text">Setelah akun dihapus, semua data akan hilang selamanya. Masukkan password Anda untuk konfirmasi.</div>

      <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="field-group">
          <label class="field-label" for="delete_password">Password</label>
          <div class="password-wrap">
            <input type="password" name="password" id="delete_password" class="field-input password-field" placeholder="Masukkan password Anda..." required>
            <button type="button" class="toggle-pw" onclick="togglePw('delete_password', this)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          @error('password', 'userDeletion') <div class="field-error">⚠ {{ $message }}</div> @enderror
        </div>

        <div class="modal-actions">
          <button type="button" class="btn-modal-cancel" onclick="document.getElementById('deleteModal').classList.remove('open')">Batal</button>
          <button type="submit" class="btn-danger">Hapus Akun</button>
        </div>
      </form>
    </div>
  </div>

@endsection

@push('scripts')
<script>
  function togglePw(id, btn) {
    const inp = document.getElementById(id);
    const isHidden = inp.type === 'password';
    inp.type = isHidden ? 'text' : 'password';
    btn.innerHTML = isHidden
      ? `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>`
      : `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>`;
  }

  // Open delete modal if errors exist
  @if ($errors->userDeletion->isNotEmpty())
    document.getElementById('deleteModal').classList.add('open');
  @endif
</script>
@endpush
