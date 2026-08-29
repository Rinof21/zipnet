@extends('layouts.app2')

@section('title', 'Kategori Dokumen')

@push('styles')
<style>
  .page-toolbar { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
  .page-heading { font-size: 20px; font-weight: 700; color: #202124; }
  .page-heading-sub { font-size: 13px; color: #70757a; margin-top: 2px; }

  /* Layout */
  .cat-layout { display: grid; grid-template-columns: 300px 1fr; gap: 24px; align-items: start; }

  /* Left panel */
  .panel-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; position: sticky; top: 80px; }
  .panel-header { padding: 18px 20px; background: linear-gradient(135deg, #0f1117, #1a2340); display: flex; align-items: center; gap: 10px; }
  .panel-header-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(26,115,232,.3); display: flex; align-items: center; justify-content: center; font-size: 15px; }
  .panel-header h6 { font-size: 14px; font-weight: 600; color: #fff; margin: 0; }
  .panel-body { padding: 20px; }

  .info-tip { font-size: 13px; color: #4d5156; line-height: 1.6; margin-bottom: 14px; }
  .info-list { list-style: none; padding: 0; margin-bottom: 18px; }
  .info-list li { font-size: 12.5px; color: #5f6368; padding: 6px 0; border-bottom: 1px solid #f5f5f5; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5; }
  .info-list li:last-child { border-bottom: none; }
  .info-list li::before { content: "•"; color: #1a73e8; font-weight: 700; flex-shrink: 0; margin-top: 1px; }
  .panel-divider { height: 1px; background: #e8eaed; margin: 16px 0; }
  .panel-section-label { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #9aa0a6; margin-bottom: 12px; }

  /* Add form */
  .btn-add { width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; background: transparent; border: 1.5px dashed #dadce0; border-radius: 8px; padding: 10px; font-size: 13px; font-weight: 500; color: #5f6368; cursor: pointer; font-family: "Inter", sans-serif; transition: border-color .15s, color .15s, background .15s; }
  .btn-add:hover { border-color: #1a73e8; color: #1a73e8; background: #e8f0fe; }

  .add-form-panel { display: none; margin-top: 14px; background: #f8f9fa; border: 1px solid #e8eaed; border-radius: 10px; padding: 16px; }
  .add-form-panel.show { display: block; }
  .mini-label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #70757a; margin-bottom: 6px; display: block; }
  .mini-input { width: 100%; border: 1.5px solid #e8eaed; border-radius: 8px; padding: 9px 12px; font-size: 13px; font-family: "Inter", sans-serif; color: #202124; outline: none; background: #fff; margin-bottom: 10px; transition: border-color .2s; }
  .mini-input:focus { border-color: #1a73e8; box-shadow: 0 0 0 3px rgba(26,115,232,.1); }
  .mini-actions { display: flex; gap: 8px; }
  .btn-mini-save { flex: 1; background: #1a73e8; color: #fff; border: none; border-radius: 7px; padding: 8px; font-size: 12px; font-weight: 600; font-family: "Inter", sans-serif; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 5px; transition: background .15s; }
  .btn-mini-save:hover { background: #1557b0; }
  .btn-mini-cancel { background: transparent; color: #70757a; border: 1px solid #e8eaed; border-radius: 7px; padding: 8px 14px; font-size: 12px; font-family: "Inter", sans-serif; cursor: pointer; transition: background .15s; }
  .btn-mini-cancel:hover { background: #f1f3f4; }

  /* Main table card */
  .table-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; }
  .table-card-header { padding: 18px 24px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; gap: 12px; }
  .table-card-title { font-size: 15px; font-weight: 700; color: #202124; display: flex; align-items: center; gap: 8px; }
  .count-badge { background: #e8f0fe; color: #1a73e8; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

  .cat-table { width: 100%; border-collapse: collapse; }
  .cat-table thead tr { background: #f8f9fa; }
  .cat-table th { padding: 11px 20px; text-align: left; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .6px; color: #70757a; border-bottom: 1px solid #e8eaed; }
  .cat-table th.center { text-align: center; }
  .cat-table td { padding: 14px 20px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; color: #202124; }
  .cat-table td.center { text-align: center; }
  .cat-table tbody tr:last-child td { border-bottom: none; }
  .cat-table tbody tr { transition: background .12s; }
  .cat-table tbody tr:hover td { background: #fafbff; }
  .td-no { color: #9aa0a6; font-size: 12px; font-weight: 500; }

  /* Category chip */
  .cat-name-cell { display: flex; align-items: center; gap: 12px; }
  .cat-icon-circle { width: 36px; height: 36px; border-radius: 10px; background: #e8f0fe; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
  .cat-name { font-size: 14px; font-weight: 500; color: #202124; }

  /* Action buttons */
  .action-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }
  .btn-action { width: 32px; height: 32px; border-radius: 8px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; transition: background .15s, transform .1s; }
  .btn-action:hover { transform: scale(1.1); }
  .btn-edit { background: #fef3e2; color: #e37400; }
  .btn-edit:hover { background: #fde7b0; }

  /* Empty state */
  .empty-state { padding: 60px 20px; text-align: center; }
  .empty-icon { font-size: 48px; margin-bottom: 14px; }
  .empty-title { font-size: 16px; font-weight: 600; color: #202124; margin-bottom: 6px; }
  .empty-sub { font-size: 14px; color: #70757a; }

  /* Alert */
  .alert-success { background: #e6f4ea; border: 1px solid #a8d5b5; color: #188038; border-radius: 10px; padding: 12px 18px; font-size: 13px; display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }

  @media (max-width: 900px) { .cat-layout { grid-template-columns: 1fr; } .panel-card { position: static; } }
</style>
@endpush

@section('content')

  @if(session('success'))
    <div class="alert-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif

  <div class="page-toolbar">
    <div>
      <div class="page-heading">Kategori Dokumen</div>
      <div class="page-heading-sub">Kelola pengelompokan arsip berdasarkan jenis surat</div>
    </div>
  </div>

  <div class="cat-layout">

    {{-- Left Panel --}}
    <div class="panel-card">
      <div class="panel-header">
        <div class="panel-header-icon">🏷️</div>
        <h6>Panduan Kategori</h6>
      </div>
      <div class="panel-body">
        <p class="info-tip">Kategori digunakan untuk mengelompokkan dokumen agar mudah dicari dan diatur.</p>
        <ul class="info-list">
          <li>Pastikan nama kategori jelas dan konsisten</li>
          <li>Kategori dapat diedit sesuai kebutuhan</li>
          <li>Kategori tidak dapat dihapus jika masih digunakan oleh dokumen</li>
        </ul>

        <div class="panel-divider"></div>
        <div class="panel-section-label">Tambah Kategori</div>

        <button id="btnTambah" class="btn-add">
          <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
          Tambah Kategori Baru
        </button>

        <div id="addFormPanel" class="add-form-panel">
          <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <span class="mini-label">Nama Kategori</span>
            <input type="text" name="name" class="mini-input" placeholder="Masukkan nama kategori..." autofocus required>
            <div class="mini-actions">
              <button type="submit" class="btn-mini-save">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/></svg>
                Simpan
              </button>
              <button type="button" id="btnBatal" class="btn-mini-cancel">Batal</button>
            </div>
          </form>
        </div>

      </div>
    </div>

    {{-- Right: Table --}}
    <div class="table-card">
      <div class="table-card-header">
        <div class="table-card-title">
          <span>🗂️</span>
          Daftar Kategori
          <span class="count-badge">{{ $categories->count() }}</span>
        </div>
      </div>
      <div style="overflow-x:auto">
        <table class="cat-table">
          <thead>
            <tr>
              <th class="center" style="width:50px">No</th>
              <th>Nama Kategori</th>
              <th class="center" style="width:90px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $i => $cat)
              <tr>
                <td class="center td-no">{{ $i + 1 }}</td>
                <td>
                  <div class="cat-name-cell">
                    <div class="cat-icon-circle">🏷️</div>
                    <span class="cat-name">{{ $cat->name }}</span>
                  </div>
                </td>
                <td class="center">
                  <div class="action-wrap">
                    <a href="{{ route('categories.edit', $cat->id) }}" class="btn-action btn-edit" title="Edit">
                      <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3">
                  <div class="empty-state">
                    <div class="empty-icon">🏷️</div>
                    <div class="empty-title">Belum ada kategori</div>
                    <div class="empty-sub">Tambahkan kategori pertama dari panel kiri</div>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>

@endsection

@push('scripts')
<script>
  const btnTambah    = document.getElementById('btnTambah');
  const addFormPanel = document.getElementById('addFormPanel');
  const btnBatal     = document.getElementById('btnBatal');

  btnTambah.addEventListener('click', () => {
    addFormPanel.classList.add('show');
    btnTambah.style.display = 'none';
    addFormPanel.querySelector('input').focus();
  });
  btnBatal.addEventListener('click', () => {
    addFormPanel.classList.remove('show');
    btnTambah.style.display = 'flex';
  });
</script>
@endpush
