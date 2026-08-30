@extends('layouts.app2')

@section('title', 'Kelola Link Menu (Titik 9)')

@push('styles')
<style>
  .page-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
  }
  .page-heading { font-size: 20px; font-weight: 700; color: #202124; display: flex; align-items: center; gap: 8px; }
  .page-heading-sub { font-size: 13px; color: #70757a; margin-top: 2px; }

  .grid-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 20px;
    align-items: start;
  }

  .card-box {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    padding: 20px;
  }
  .card-box-title {
    font-size: 15px;
    font-weight: 600;
    color: #202124;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .form-group { margin-bottom: 14px; }
  .form-group label { display: block; font-size: 12.5px; font-weight: 600; color: #3c4043; margin-bottom: 6px; }
  .form-control {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid #dadce0;
    border-radius: 8px;
    font-size: 13.5px;
    font-family: "Inter", sans-serif;
    color: #202124;
    transition: border-color .15s;
  }
  .form-control:focus { outline: none; border-color: #1a73e8; }
  .invalid-feedback { font-size: 12px; color: #d93025; margin-top: 4px; }

  .btn-submit {
    width: 100%;
    background: #1a73e8;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    font-family: "Inter", sans-serif;
    transition: background .15s;
  }
  .btn-submit:hover { background: #1557b0; }

  .doc-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  .doc-table thead tr { background: #f8f9fa; }
  .doc-table th {
    padding: 11px 14px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #70757a;
    border-bottom: 1px solid #e8eaed;
  }
  .doc-table th.center { text-align: center; }
  .doc-table td { padding: 12px 14px; border-bottom: 1px solid #f5f5f5; vertical-align: middle; }
  .doc-table td.center { text-align: center; }
  .doc-table tbody tr:hover td { background: #fafbff; }

  .badge-active { background: #e6f4ea; color: #137333; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 12px; }
  .badge-inactive { background: #f1f3f4; color: #5f6368; font-size: 11px; font-weight: 600; padding: 3px 8px; border-radius: 12px; }

  .btn-sm-action {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 6px; border: none; cursor: pointer;
    background: #f1f3f4; color: #5f6368; transition: background .12s, color .12s;
    text-decoration: none;
  }
  .btn-sm-action.edit:hover { background: #fef3e2; color: #e37400; }
  .btn-sm-action.del:hover { background: #fce8e6; color: #d93025; }

  @media (max-width: 900px) {
    .grid-layout { grid-template-columns: 1fr; }
  }
</style>
@endpush

@section('content')

  <div class="page-toolbar">
    <div>
      <div class="page-heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#1a73e8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="19" cy="5" r="1"/><circle cx="5" cy="5" r="1"/><circle cx="12" cy="19" r="1"/><circle cx="19" cy="19" r="1"/><circle cx="5" cy="19" r="1"/></svg>
        Kelola Link Menu (Titik 9)
      </div>
      <div class="page-heading-sub">Pengaturan link eksternal yang tampil pada menu Titik 9 di halaman pencarian publik</div>
    </div>
  </div>

  @if(session('success'))
    <div style="background:#e6f4ea;border:1px solid #ceead6;color:#137333;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:13.5px;display:flex;align-items:center;gap:8px">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif

  <div class="grid-layout">
    {{-- Form Tambah / Edit Link --}}
    <div class="card-box">
      <div class="card-box-title" id="formTitle">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Link Baru
      </div>

      <form id="linkForm" action="{{ route('quick-links.store') }}" method="POST">
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="POST">

        <div class="form-group">
          <label>Judul Link <span style="color:#d93025">*</span></label>
          <input type="text" name="title" id="inputTitle" class="form-control" placeholder="Contoh: Silat" value="{{ old('title') }}" required>
          @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label>URL Tujuan <span style="color:#d93025">*</span></label>
          <input type="url" name="url" id="inputUrl" class="form-control" placeholder="https://silatfk.untan.ac.id" value="{{ old('url') }}" required>
          @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
          <label>Urutan Tampilan</label>
          <input type="number" name="sort_order" id="inputSortOrder" class="form-control" placeholder="0" value="{{ old('sort_order', 0) }}">
        </div>

        <div class="form-group" style="display:flex;align-items:center;gap:8px;margin-top:10px">
          <input type="checkbox" name="is_active" id="inputIsActive" value="1" checked style="width:16px;height:16px;cursor:pointer">
          <label for="inputIsActive" style="margin:0;cursor:pointer;font-weight:500">Tampilkan di Menu Titik 9</label>
        </div>

        <div style="display:flex;gap:8px;margin-top:16px">
          <button type="submit" class="btn-submit" id="btnSave">Simpan Link</button>
          <button type="button" class="btn-submit" id="btnCancelEdit" style="background:#f1f3f4;color:#5f6368;display:none" onclick="resetForm()">Batal</button>
        </div>
      </form>
    </div>

    {{-- Tabel Daftar Link --}}
    <div class="card-box" style="padding:0;overflow:hidden">
      <div style="padding:16px 20px;border-bottom:1px solid #e8eaed;font-size:15px;font-weight:600;color:#202124">
        Daftar Link Menu Titik 9 ({{ $quickLinks->count() }})
      </div>
      <div style="overflow-x:auto">
        <table class="doc-table">
          <thead>
            <tr>
              <th class="center" style="width:40px">No</th>
              <th>Judul Link</th>
              <th>URL Tujuan</th>
              <th class="center" style="width:70px">Urutan</th>
              <th class="center" style="width:80px">Status</th>
              <th class="center" style="width:90px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($quickLinks as $index => $link)
              <tr>
                <td class="center" style="color:#70757a;font-size:12px">{{ $index + 1 }}</td>
                <td style="font-weight:600;color:#202124">{{ $link->title }}</td>
                <td style="font-size:12.5px">
                  <a href="{{ $link->url }}" target="_blank" style="color:#1a73e8;text-decoration:none">
                    {{ Str::limit($link->url, 40) }}
                  </a>
                </td>
                <td class="center" style="font-weight:600;color:#5f6368">{{ $link->sort_order }}</td>
                <td class="center">
                  @if($link->is_active)
                    <span class="badge-active">Aktif</span>
                  @else
                    <span class="badge-inactive">Nonaktif</span>
                  @endif
                </td>
                <td class="center">
                  <div style="display:flex;align-items:center;justify-content:center;gap:6px">
                    <button
                      type="button"
                      class="btn-sm-action edit"
                      title="Edit Link"
                      onclick="editLink({{ json_encode($link) }})"
                    >
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <form action="{{ route('quick-links.destroy', $link->id) }}" method="POST" style="margin:0" onsubmit="return confirm('Hapus link {{ json_encode($link->title) }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-sm-action del" title="Hapus Link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" style="text-align:center;padding:30px;color:#70757a">Belum ada link tersimpan.</td>
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
  function editLink(link) {
    document.getElementById('formTitle').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit Link';
    const form = document.getElementById('linkForm');
    form.action = '/quick-links/' + link.id;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('inputTitle').value = link.title;
    document.getElementById('inputUrl').value = link.url;
    document.getElementById('inputSortOrder').value = link.sort_order;
    document.getElementById('inputIsActive').checked = Boolean(link.is_active);
    document.getElementById('btnSave').innerText = 'Perbarui Link';
    document.getElementById('btnCancelEdit').style.display = 'block';
  }

  function resetForm() {
    document.getElementById('formTitle').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Tambah Link Baru';
    const form = document.getElementById('linkForm');
    form.action = "{{ route('quick-links.store') }}";
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('inputTitle').value = '';
    document.getElementById('inputUrl').value = '';
    document.getElementById('inputSortOrder').value = '0';
    document.getElementById('inputIsActive').checked = true;
    document.getElementById('btnSave').innerText = 'Simpan Link';
    document.getElementById('btnCancelEdit').style.display = 'none';
  }
</script>
@endpush
