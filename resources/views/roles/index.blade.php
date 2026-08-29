@extends('layouts.app2')

@section('title', 'Kelola Peran & Izin')

@push('styles')
<style>
  .page-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
  .page-heading { font-size: 20px; font-weight: 700; color: #202124; }
  .page-heading-sub { font-size: 13px; color: #70757a; margin-top: 2px; }

  .roles-layout { display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start; }

  /* Left Panel */
  .panel-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; position: sticky; top: 80px; }
  .panel-header { padding: 18px 20px; background: linear-gradient(135deg, #0f1117, #1a2340); display: flex; align-items: center; gap: 10px; }
  .panel-header-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(26,115,232,.3); display: flex; align-items: center; justify-content: center; font-size: 15px; }
  .panel-header h6 { font-size: 14px; font-weight: 600; color: #fff; margin: 0; }
  .panel-body { padding: 20px; }

  .btn-action-primary {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    background: #1a73e8; color: #fff; border: none; border-radius: 8px;
    padding: 10px 18px; font-size: 13px; font-weight: 600; font-family: "Inter", sans-serif;
    text-decoration: none; cursor: pointer; transition: background .15s; width: 100%; margin-bottom: 10px;
  }
  .btn-action-primary:hover { background: #1557b0; color: #fff; }

  .btn-action-secondary {
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    background: transparent; color: #5f6368; border: 1.5px dashed #dadce0; border-radius: 8px;
    padding: 9px 18px; font-size: 13px; font-weight: 500; font-family: "Inter", sans-serif;
    text-decoration: none; cursor: pointer; transition: background .15s, border-color .15s; width: 100%;
  }
  .btn-action-secondary:hover { background: #e8f0fe; border-color: #1a73e8; color: #1a73e8; }

  /* Permission list badges in panel */
  .perm-list { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
  .perm-chip { background: #f1f3f4; color: #3c4043; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; font-family: "Inter", monospace; }

  /* Table card */
  .table-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; }
  .table-card-header { padding: 18px 24px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
  .table-card-title { font-size: 15px; font-weight: 700; color: #202124; display: flex; align-items: center; gap: 8px; }
  .count-badge { background: #e8f0fe; color: #1a73e8; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

  .role-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  .role-table thead tr { background: #f8f9fa; }
  .role-table th { padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #70757a; border-bottom: 1px solid #e8eaed; }
  .role-table th.center { text-align: center; }
  .role-table td { padding: 16px 20px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; color: #202124; }
  .role-table td.center { text-align: center; }
  .role-table tbody tr:last-child td { border-bottom: none; }
  .role-table tbody tr { transition: background .12s; }
  .role-table tbody tr:hover td { background: #fafbff; }

  .role-badge { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 700; color: #202124; }
  .role-icon { width: 32px; height: 32px; border-radius: 8px; background: #e8f0fe; color: #1a73e8; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
  .role-badge.super-admin .role-icon { background: #fef3e2; color: #e37400; }

  .permissions-wrap { display: flex; flex-wrap: wrap; gap: 4px; max-width: 450px; }
  .permission-tag { background: #e8f0fe; color: #1a73e8; font-size: 11px; font-weight: 500; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
  .permission-tag.all { background: #e6f4ea; color: #188038; font-weight: 700; }

  /* Actions */
  .action-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }
  .btn-action { width: 32px; height: 32px; border-radius: 8px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; transition: background .15s, transform .1s; }
  .btn-action:hover { transform: scale(1.1); }
  .btn-edit { background: #fef3e2; color: #e37400; }
  .btn-edit:hover { background: #fde7b0; }
  .btn-delete { background: #fce8e6; color: #d93025; }
  .btn-delete:hover { background: #fad2cf; }

  /* Alerts */
  .alert-box { padding: 12px 18px; border-radius: 10px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
  .alert-box.success { background: #e6f4ea; border: 1px solid #a8d5b5; color: #188038; }
  .alert-box.error { background: #fce8e6; border: 1px solid #f5c6c4; color: #d93025; }

  /* Modal add perm */
  .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 700; display: none; align-items: center; justify-content: center; padding: 20px; }
  .modal-overlay.open { display: flex; }
  .modal-box { background: #fff; border-radius: 14px; padding: 24px; max-width: 420px; width: 100%; box-shadow: 0 20px 60px rgba(0,0,0,.2); }
  .modal-title { font-size: 16px; font-weight: 700; color: #202124; margin-bottom: 4px; }
  .modal-sub { font-size: 12.5px; color: #70757a; margin-bottom: 16px; }

  @media (max-width: 900px) { .roles-layout { grid-template-columns: 1fr; } .panel-card { position: static; } }
</style>
@endpush

@section('content')

  @if(session('success'))
    <div class="alert-box success">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div class="alert-box error">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
  @endif

  <div class="page-toolbar">
    <div>
      <div class="page-heading">Kelola Peran & Izin (Roles & Permissions)</div>
      <div class="page-heading-sub">Atur perizinan hak akses pengguna dalam sistem Spatie</div>
    </div>
  </div>

  <div class="roles-layout">

    {{-- Left Panel --}}
    <div class="panel-card">
      <div class="panel-header">
        <div class="panel-header-icon">🔑</div>
        <h6>Manajemen Hak Akses</h6>
      </div>
      <div class="panel-body">

        <a href="{{ route('roles.create') }}" class="btn-action-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
          Tambah Peran (Role) Baru
        </a>

        <button type="button" class="btn-action-secondary" onclick="document.getElementById('permModal').classList.add('open')">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2H2v10l9.29 9.29c.94.94 2.48.94 3.42 0l6.58-6.58c.94-.94.94-2.48 0-3.42L12 2Z"/><path d="M7 7h.01"/></svg>
          Tambah Izin (Permission) Baru
        </button>

        <div style="height:1px;background:#e8eaed;margin:18px 0"></div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:#9aa0a6;margin-bottom:10px">
          Daftar Izin Sistem ({{ $permissions->count() }})
        </div>

        <div class="perm-list">
          @foreach($permissions as $perm)
            <span class="perm-chip">{{ $perm->name }}</span>
          @endforeach
        </div>

      </div>
    </div>

    {{-- Right Table --}}
    <div class="table-card">
      <div class="table-card-header">
        <div class="table-card-title">
          🛡️ Daftar Peran (Roles)
          <span class="count-badge">{{ $roles->count() }} Role</span>
        </div>
      </div>

      <div style="overflow-x:auto">
        <table class="role-table">
          <thead>
            <tr>
              <th style="width:180px">Nama Peran</th>
              <th>Izin Terhubung (Permissions)</th>
              <th class="center" style="width:100px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
              <tr>
                <td>
                  <div class="role-badge {{ $role->name === 'Super Admin' ? 'super-admin' : '' }}">
                    <div class="role-icon">
                      @if($role->name === 'Super Admin') 👑 @else 🛡️ @endif
                    </div>
                    <span>{{ $role->name }}</span>
                  </div>
                </td>
                <td>
                  <div class="permissions-wrap">
                    @if($role->name === 'Super Admin')
                      <span class="permission-tag all">★ SEMUA IZIN (FULL ACCESS)</span>
                    @else
                      @forelse($role->permissions as $p)
                        <span class="permission-tag">{{ $p->name }}</span>
                      @empty
                        <span style="color:#9aa0a6;font-size:12px">Tidak ada izin terpilih</span>
                      @endforelse
                    @endif
                  </div>
                </td>
                <td class="center">
                  <div class="action-wrap">
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn-action btn-edit" title="Edit Role & Permissions">
                      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                    @if($role->name !== 'Super Admin')
                      <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus role {{ $role->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete" title="Hapus Role">
                          <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>

  {{-- Modal Add Permission --}}
  <div class="modal-overlay" id="permModal">
    <div class="modal-box">
      <div class="modal-title">Tambah Izin (Permission) Baru</div>
      <div class="modal-sub">Gunakan nama huruf kecil dengan spasi (misal: export reports)</div>

      <form action="{{ route('roles.storePermission') }}" method="POST">
        @csrf
        <div style="margin-bottom:16px">
          <label style="font-size:12px;font-weight:600;color:#3c4043;display:block;margin-bottom:6px">Nama Izin</label>
          <input
            type="text"
            name="name"
            placeholder="Contoh: ekspor laporan"
            required
            style="width:100%;border:1.5px solid #e8eaed;border-radius:8px;padding:10px 12px;font-size:13.5px;outline:none"
          >
        </div>
        <div style="display:flex;gap:8px;justify-content:flex-end">
          <button type="button" class="btn-action-secondary" style="width:auto" onclick="document.getElementById('permModal').classList.remove('open')">Batal</button>
          <button type="submit" class="btn-action-primary" style="width:auto;margin:0">Simpan Izin</button>
        </div>
      </form>
    </div>
  </div>

@endsection
