@extends('layouts.app2')

@section('title', 'Dashboard')

@push('styles')
<style>
  /* ===== STAT CARDS ===== */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
  }

  .stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    text-decoration: none;
    color: inherit;
    border: 1px solid #e8eaed;
    transition: box-shadow .2s, transform .2s, border-color .2s;
    cursor: pointer;
  }
  .stat-card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,.1);
    transform: translateY(-2px);
    border-color: transparent;
  }

  .stat-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
  }
  .stat-icon.blue   { background: #e8f0fe; }
  .stat-icon.green  { background: #e6f4ea; }
  .stat-icon.purple { background: #f3e8fd; }
  .stat-icon.orange { background: #fef3e2; }

  .stat-body { flex: 1; min-width: 0; }
  .stat-label {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #70757a;
    margin-bottom: 6px;
  }
  .stat-value {
    font-size: 34px;
    font-weight: 700;
    line-height: 1;
    color: #202124;
  }
  .stat-value.blue   { color: #1a73e8; }
  .stat-value.green  { color: #188038; }
  .stat-value.purple { color: #7b1fa2; }
  .stat-value.orange { color: #e37400; }

  .stat-trend {
    font-size: 12px;
    color: #70757a;
    margin-top: 6px;
  }

  /* ===== WELCOME CARD ===== */
  .welcome-card {
    background: linear-gradient(135deg, #0f1117 0%, #1a2340 50%, #0d2340 100%);
    border-radius: 14px;
    padding: 28px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
  }
  .welcome-card::before {
    content: "";
    position: absolute;
    width: 300px; height: 300px;
    background: #1a73e8;
    border-radius: 50%;
    filter: blur(80px);
    opacity: .3;
    top: -100px; right: -60px;
    pointer-events: none;
  }
  .welcome-text { position: relative; z-index: 1; }
  .welcome-greeting {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin-bottom: 6px;
  }
  .welcome-greeting span { color: #4ca3ff; }
  .welcome-sub { font-size: 14px; color: rgba(255,255,255,.55); line-height: 1.5; }

  .welcome-actions { display: flex; gap: 12px; position: relative; z-index: 1; flex-shrink: 0; }
  .btn-primary-white {
    background: #1a73e8;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: background .15s, box-shadow .15s;
  }
  .btn-primary-white:hover { background: #1557b0; box-shadow: 0 4px 16px rgba(26,115,232,.4); }

  .btn-outline-white {
    background: rgba(255,255,255,.08);
    color: rgba(255,255,255,.8);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 8px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: background .15s;
  }
  .btn-outline-white:hover { background: rgba(255,255,255,.14); }

  /* ===== SECTION TITLE ===== */
  .section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 14px;
  }
  .section-title {
    font-size: 15px;
    font-weight: 600;
    color: #202124;
  }
  .section-link {
    font-size: 13px;
    color: #1a73e8;
    text-decoration: none;
    font-weight: 500;
  }
  .section-link:hover { text-decoration: underline; }

  /* ===== QUICK ACTIONS ===== */
  .quick-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 14px;
    margin-bottom: 28px;
  }
  .quick-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 12px;
    padding: 20px 16px;
    text-align: center;
    text-decoration: none;
    color: #202124;
    transition: box-shadow .2s, transform .2s, border-color .2s;
  }
  .quick-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,.08);
    transform: translateY(-2px);
    border-color: #1a73e8;
  }
  .quick-icon { font-size: 28px; margin-bottom: 10px; }
  .quick-label { font-size: 13px; font-weight: 500; color: #3c4043; }

  /* ===== MODAL ===== */
  .modal-body { padding: 8px 0; }
  .table-modern { width: 100%; border-collapse: collapse; font-size: 14px; }
  .table-modern th { padding: 11px 20px; text-align: left; font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #70757a; border-bottom: 1px solid #e8eaed; background: #f8f9fa; }
  .table-modern td { padding: 13px 20px; border-bottom: 1px solid #f5f5f5; }
  .table-modern tbody tr:last-child td { border-bottom: none; }
  .table-modern tbody tr:hover td { background: #fafbff; }
  .user-badge { display: inline-flex; align-items: center; gap: 8px; }
  .user-badge-avatar { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg,#1a73e8,#4ca3ff); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #fff; }
</style>
@endpush

@section('content')

  {{-- Welcome Card --}}
  <div class="welcome-card">
    <div class="welcome-text">
      <div class="welcome-greeting">
        Selamat datang, <span>{{ auth()->user()->name }}</span> 👋
      </div>
      <div class="welcome-sub">Kelola arsip dokumen Fakultas Kedokteran dari panel ini.</div>
    </div>
    <div class="welcome-actions">
      <a href="{{ route('documents.create') }}" class="btn-primary-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
        Upload Dokumen
      </a>
      <a href="/search" class="btn-outline-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        Pencarian
      </a>
    </div>
  </div>

  {{-- Stats --}}
  <div class="stats-grid">
    <a href="{{ route('documents.search') }}" class="stat-card">
      <div class="stat-icon blue">📄</div>
      <div class="stat-body">
        <div class="stat-label">Total Dokumen</div>
        <div class="stat-value blue">{{ \App\Models\Document::count() }}</div>
        <div class="stat-trend">Arsip tersimpan</div>
      </div>
    </a>

    <a href="{{ route('categories.index') }}" class="stat-card">
      <div class="stat-icon green">🏷️</div>
      <div class="stat-body">
        <div class="stat-label">Total Kategori</div>
        <div class="stat-value green">{{ \App\Models\Category::count() }}</div>
        <div class="stat-trend">Kategori aktif</div>
      </div>
    </a>

    @can('kelola pengguna')
    <a href="{{ route('users.index') }}" class="stat-card">
      <div class="stat-icon purple">👥</div>
      <div class="stat-body">
        <div class="stat-label">Total Pengguna</div>
        <div class="stat-value purple">{{ \App\Models\User::count() }}</div>
        <div class="stat-trend">Akun terdaftar</div>
      </div>
    </a>
    @endcan

    @can('kelola peran')
    <a href="{{ route('roles.index') }}" class="stat-card">
      <div class="stat-icon orange">🛡️</div>
      <div class="stat-body">
        <div class="stat-label">Peran & Izin</div>
        <div class="stat-value orange">{{ \Spatie\Permission\Models\Role::count() }}</div>
        <div class="stat-trend">Role aktif</div>
      </div>
    </a>
    @endcan
  </div>

  {{-- Quick Actions --}}
  <div class="section-header">
    <div class="section-title">Aksi Cepat</div>
  </div>
  <div class="quick-grid">
    @can('tambah dokumen')
    <a href="{{ route('documents.create') }}" class="quick-card">
      <div class="quick-icon">📤</div>
      <div class="quick-label">Upload Dokumen</div>
    </a>
    @endcan
    <a href="/search" class="quick-card">
      <div class="quick-icon">🔍</div>
      <div class="quick-label">Cari Arsip</div>
    </a>
    @can('kelola kategori')
    <a href="{{ route('categories.index') }}" class="quick-card">
      <div class="quick-icon">🗂️</div>
      <div class="quick-label">Kelola Kategori</div>
    </a>
    @endcan
    @can('kelola pengguna')
    <a href="{{ route('users.index') }}" class="quick-card">
      <div class="quick-icon">👥</div>
      <div class="quick-label">Kelola User</div>
    </a>
    @endcan
    @can('kelola peran')
    <a href="{{ route('roles.index') }}" class="quick-card">
      <div class="quick-icon">🛡️</div>
      <div class="quick-label">Peran & Izin</div>
    </a>
    @endcan
    <a href="{{ route('public.search') }}" class="quick-card" target="_blank">
      <div class="quick-icon">🌐</div>
      <div class="quick-label">Halaman Publik</div>
    </a>
    <a href="{{ route('profile.edit') }}" class="quick-card">
      <div class="quick-icon">⚙️</div>
      <div class="quick-label">Profil Saya</div>
    </a>
  </div>

  {{-- MODAL USERS --}}
  <div class="modal" id="modalUsers" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <span class="modal-title">👥 Daftar Pengguna</span>
          <button type="button" class="btn-close-white" data-bs-dismiss="modal" aria-label="Close">✕</button>
        </div>
        <div class="modal-body" style="padding:0">
          <table class="table-modern">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              @foreach(\App\Models\User::orderBy('name')->get() as $i => $user)
                <tr>
                  <td style="color:#70757a;font-size:13px">{{ $i + 1 }}</td>
                  <td>
                    <div class="user-badge">
                      <div class="user-badge-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                      {{ $user->name }}
                    </div>
                  </td>
                  <td style="color:#70757a">{{ $user->email }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
