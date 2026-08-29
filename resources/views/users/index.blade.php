@extends('layouts.app2')

@section('title', 'Kelola Pengguna')

@push('styles')
<style>
  .page-toolbar { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
  .page-heading { font-size: 20px; font-weight: 700; color: #202124; }
  .page-heading-sub { font-size: 13px; color: #70757a; margin-top: 2px; }

  .btn-add-user {
    display: inline-flex; align-items: center; gap: 8px;
    background: #1a73e8; color: #fff; border: none; border-radius: 8px;
    padding: 10px 20px; font-size: 13px; font-weight: 600; font-family: "Inter", sans-serif;
    text-decoration: none; cursor: pointer; transition: background .15s;
  }
  .btn-add-user:hover { background: #1557b0; color: #fff; }

  /* Table card */
  .table-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; }
  .table-card-header { padding: 18px 24px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
  .table-card-title { font-size: 15px; font-weight: 700; color: #202124; display: flex; align-items: center; gap: 8px; }
  .count-badge { background: #e8f0fe; color: #1a73e8; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

  .user-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  .user-table thead tr { background: #f8f9fa; }
  .user-table th { padding: 12px 20px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #70757a; border-bottom: 1px solid #e8eaed; }
  .user-table th.center { text-align: center; }
  .user-table td { padding: 14px 20px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; color: #202124; }
  .user-table td.center { text-align: center; }
  .user-table tbody tr:last-child td { border-bottom: none; }
  .user-table tbody tr { transition: background .12s; }
  .user-table tbody tr:hover td { background: #fafbff; }

  /* User cell */
  .user-cell { display: flex; align-items: center; gap: 12px; }
  .user-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #1a73e8, #0d47a1);
    color: #fff; font-size: 14px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .user-name { font-size: 14px; font-weight: 600; color: #202124; }
  .user-email { font-size: 12px; color: #70757a; }

  /* Role badges */
  .role-chip { display: inline-block; background: #e8f0fe; color: #1a73e8; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; margin-right: 4px; }
  .role-chip.super-admin { background: #fef3e2; color: #e37400; }

  /* Actions */
  .action-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }
  .btn-action { width: 32px; height: 32px; border-radius: 8px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; transition: background .15s, transform .1s; }
  .btn-action:hover { transform: scale(1.1); }
  .btn-edit { background: #fef3e2; color: #e37400; }
  .btn-edit:hover { background: #fde7b0; }
  .btn-delete { background: #fce8e6; color: #d93025; }
  .btn-delete:hover { background: #fad2cf; }

  /* Alert */
  .alert-box { padding: 12px 18px; border-radius: 10px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
  .alert-box.success { background: #e6f4ea; border: 1px solid #a8d5b5; color: #188038; }
  .alert-box.error { background: #fce8e6; border: 1px solid #f5c6c4; color: #d93025; }
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
      <div class="page-heading">Kelola Pengguna Sistem</div>
      <div class="page-heading-sub">Daftar pengguna dan penugasan peran akses</div>
    </div>
    <a href="{{ route('users.create') }}" class="btn-add-user">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="11" x2="19" y2="17"/><line x1="16" y1="14" x2="22" y2="14"/></svg>
      Tambah Pengguna Baru
    </a>
  </div>

  <div class="table-card">
    <div class="table-card-header">
      <div class="table-card-title">
        👥 Daftar Pengguna
        <span class="count-badge">{{ $users->total() }} User</span>
      </div>
    </div>

    <div style="overflow-x:auto">
      <table class="user-table">
        <thead>
          <tr>
            <th>Pengguna</th>
            <th>Peran (Role)</th>
            <th class="center">Tanggal Dibuat</th>
            <th class="center" style="width:100px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $u)
            <tr>
              <td>
                <div class="user-cell">
                  <div class="user-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                  <div>
                    <div class="user-name">{{ $u->name }} @if($u->id === auth()->id()) <span style="font-size:11px;color:#1a73e8;font-weight:600">(Anda)</span> @endif</div>
                    <div class="user-email">{{ $u->email }}</div>
                  </div>
                </div>
              </td>
              <td>
                @forelse($u->roles as $r)
                  <span class="role-chip {{ $r->name === 'Super Admin' ? 'super-admin' : '' }}">
                    @if($r->name === 'Super Admin') 👑 @else 🛡️ @endif {{ $r->name }}
                  </span>
                @empty
                  <span style="color:#9aa0a6;font-size:12px">Belum ada role</span>
                @endforelse
              </td>
              <td class="center" style="color:#5f6368;font-size:12.5px">
                {{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}
              </td>
              <td class="center">
                <div class="action-wrap">
                  <a href="{{ route('users.edit', $u->id) }}" class="btn-action btn-edit" title="Edit Pengguna & Role">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </a>
                  @if($u->id !== auth()->id())
                    <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin menghapus pengguna {{ $u->name }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-action btn-delete" title="Hapus Pengguna">
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

    @if($users->hasPages())
      <div style="padding:16px;border-top:1px solid #e8eaed;display:flex;justify-content:center">
        {{ $users->links() }}
      </div>
    @endif
  </div>

@endsection
