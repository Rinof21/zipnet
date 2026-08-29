@extends('layouts.app2')

@section('title', 'Edit Peran – ' . $role->name)

@push('styles')
<style>
  .form-wrap { max-width: 640px; margin: 0 auto; }
  .form-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; }
  .form-card-header { padding: 20px 28px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 14px; }
  .form-card-icon { width: 40px; height: 40px; background: #fef3e2; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
  .form-card-title { font-size: 16px; font-weight: 700; color: #202124; }
  .form-card-sub { font-size: 12.5px; color: #70757a; margin-top: 2px; }
  .form-card-body { padding: 28px; }

  .field-group { margin-bottom: 22px; }
  .field-label { display: flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: #3c4043; margin-bottom: 8px; }
  .field-label .required { color: #d93025; }
  .field-input { width: 100%; border: 1.5px solid #e8eaed; border-radius: 10px; padding: 11px 14px; font-size: 14px; font-family: "Inter", sans-serif; color: #202124; outline: none; background: #fff; transition: border-color .2s; }
  .field-input:focus { border-color: #e37400; box-shadow: 0 0 0 3px rgba(227,116,0,.1); }

  .perm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; background: #f8f9fa; border: 1px solid #e8eaed; border-radius: 10px; padding: 16px; margin-top: 6px; }
  .perm-checkbox-item { display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid #e8eaed; border-radius: 8px; padding: 10px 14px; cursor: pointer; transition: border-color .15s, background .15s; }
  .perm-checkbox-item:hover { border-color: #e37400; background: #fffbf5; }
  .perm-checkbox-item input[type="checkbox"] { width: 16px; height: 16px; accent-color: #e37400; cursor: pointer; }
  .perm-name { font-size: 13px; font-weight: 500; color: #202124; }

  .form-actions { display: flex; gap: 10px; padding-top: 12px; }
  .btn-save { display: inline-flex; align-items: center; gap: 8px; background: #e37400; color: #fff; border: none; border-radius: 10px; padding: 12px 28px; font-size: 14px; font-weight: 600; font-family: "Inter", sans-serif; cursor: pointer; transition: background .15s; }
  .btn-save:hover { background: #c35f00; }
  .btn-cancel { display: inline-flex; align-items: center; gap: 8px; background: transparent; color: #5f6368; border: 1.5px solid #e8eaed; border-radius: 10px; padding: 11px 22px; font-size: 14px; font-weight: 500; font-family: "Inter", sans-serif; cursor: pointer; text-decoration: none; transition: background .15s; }
  .btn-cancel:hover { background: #f1f3f4; color: #202124; }
</style>
@endpush

@section('content')

  <div style="display:flex;align-items:center;gap:14px;margin-bottom:22px">
    <a href="{{ route('roles.index') }}" style="display:flex;align-items:center;gap:6px;font-size:13px;color:#70757a;text-decoration:none;padding:6px 12px;border:1px solid #e8eaed;border-radius:8px;transition:background .15s" onmouseover="this.style.background='#f1f3f4'" onmouseout="this.style.background='transparent'">
      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
      Kembali
    </a>
    <div>
      <div style="font-size:20px;font-weight:700;color:#202124">Edit Peran (Role)</div>
      <div style="font-size:13px;color:#70757a">Perbarui nama role dan penugasan izin</div>
    </div>
  </div>

  <div class="form-wrap">
    <div class="form-card">
      <div class="form-card-header">
        <div class="form-card-icon">✏️</div>
        <div>
          <div class="form-card-title">Edit Role: {{ $role->name }}</div>
          <div class="form-card-sub">Perbarui izin terhubung untuk role ini</div>
        </div>
      </div>

      <div class="form-card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="field-group">
            <label class="field-label" for="name">
              Nama Peran (Role) <span class="required">*</span>
            </label>
            <input
              type="text"
              name="name"
              id="name"
              class="field-input"
              value="{{ old('name', $role->name) }}"
              required
              {{ $role->name === 'Super Admin' ? 'readonly style=background:#f8f9fa' : '' }}
            >
            @error('name') <div style="font-size:12px;color:#d93025;margin-top:5px">⚠ {{ $message }}</div> @enderror
          </div>

          <div class="field-group">
            <label class="field-label">Pilih Izin Akses (Permissions)</label>
            @if($role->name === 'Super Admin')
              <div style="font-size:13px;color:#188038;background:#e6f4ea;border:1px solid #a8d5b5;padding:12px 16px;border-radius:10px">
                ★ <strong>Super Admin</strong> memiliki akses ke seluruh izin secara otomatis.
              </div>
            @else
              <div class="perm-grid">
                @foreach($permissions as $perm)
                  <label class="perm-checkbox-item">
                    <input
                      type="checkbox"
                      name="permissions[]"
                      value="{{ $perm->name }}"
                      {{ in_array($perm->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                    >
                    <span class="perm-name">{{ $perm->name }}</span>
                  </label>
                @endforeach
              </div>
            @endif
          </div>

          <div class="form-actions">
            <button type="submit" class="btn-save">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
              Simpan Perubahan
            </button>
            <a href="{{ route('roles.index') }}" class="btn-cancel">Batal</a>
          </div>

        </form>
      </div>
    </div>
  </div>

@endsection
