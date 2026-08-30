@extends('layouts.app2')

@section('title', 'Tempat Sampah Dokumen')

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

  /* ===== SEARCH BAR ===== */
  .search-bar-wrap {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 20px;
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
  }

  .search-input-group {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8f9fa;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 9px 14px;
    flex: 1;
    min-width: 200px;
    transition: border-color .2s, box-shadow .2s;
  }
  .search-input-group:focus-within {
    border-color: #d93025;
    box-shadow: 0 0 0 3px rgba(217,48,37,.1);
    background: #fff;
  }
  .search-input-group svg { color: #9aa0a6; flex-shrink: 0; }
  .search-input-group input {
    border: none; outline: none; background: transparent;
    font-size: 14px; font-family: "Inter", sans-serif; color: #202124;
    width: 100%;
  }

  .btn-search {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #d93025;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 10px 22px;
    font-size: 14px;
    font-weight: 600;
    font-family: "Inter", sans-serif;
    cursor: pointer;
    transition: background .15s;
    white-space: nowrap;
  }
  .btn-search:hover { background: #b31412; }

  .btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: transparent;
    color: #70757a;
    border: 1.5px solid #e8eaed;
    border-radius: 10px;
    padding: 9px 16px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
  }
  .btn-reset:hover { background: #f1f3f4; color: #202124; }

  /* ===== RESULT META ===== */
  .result-meta {
    font-size: 13px;
    color: #70757a;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .result-badge {
    background: #fce8e6;
    color: #d93025;
    font-size: 12px;
    font-weight: 600;
    padding: 2px 10px;
    border-radius: 20px;
  }

  /* ===== TABLE ===== */
  .table-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 14px;
    min-height: 320px;
  }

  .table-scroll-wrap {
    overflow-x: auto;
    padding-bottom: 80px;
    margin-bottom: -80px;
    border-radius: 14px;
  }

  .doc-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
  .doc-table thead tr { background: #fffbfb; }
  .doc-table th {
    padding: 12px 16px;
    text-align: left;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .6px;
    color: #70757a;
    border-bottom: 1px solid #e8eaed;
    white-space: nowrap;
  }
  .doc-table th.center { text-align: center; }

  .doc-table td {
    padding: 13px 16px;
    border-bottom: 1px solid #f5f5f5;
    color: #202124;
    vertical-align: middle;
  }
  .doc-table td.center { text-align: center; }
  .doc-table tbody tr:hover td { background: #fff8f8; }

  .td-no { color: #9aa0a6; font-size: 12px; font-weight: 500; }
  .doc-title { font-weight: 400; color: #202124; line-height: 1.4; max-width: 100%; word-break: break-word; }
  .doc-nomor { font-size: 12.5px; color: #3c4043; font-family: "Inter", sans-serif; max-width: 100%; word-break: break-word; }
  .doc-perihal { font-size: 13px; color: #4d5156; max-width: 100%; line-height: 1.5; word-break: break-word; }

  .cat-badge {
    display: inline-block;
    background: #f1f3f4;
    color: #5f6368;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
  }

  .action-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; }

  .btn-restore {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    background: #e6f4ea;
    color: #137333;
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s;
  }
  .btn-restore:hover { background: #ceead6; }

  .btn-force-del {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    background: #fce8e6;
    color: #c5221f;
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s;
  }
  .btn-force-del:hover { background: #fad2cf; }

  .empty-state { padding: 50px 20px; text-align: center; }
  .empty-icon { font-size: 40px; margin-bottom: 10px; }
  .empty-title { font-size: 16px; font-weight: 600; color: #202124; margin-bottom: 4px; }
  .empty-sub { font-size: 13px; color: #70757a; }

  .pagination-wrap {
    padding: 14px 20px;
    border-top: 1px solid #e8eaed;
    display: flex;
    justify-content: flex-end;
  }

  /* ===== MOBILE CARDS LIST ===== */
  .mobile-doc-list { display: none; flex-direction: column; gap: 12px; }
  .mobile-doc-card {
    background: #fff;
    border: 1px solid #e8eaed;
    border-radius: 12px;
    padding: 16px;
  }
  .mobile-doc-top { display: flex; justify-content: space-between; gap: 10px; margin-bottom: 8px; }
  .mobile-doc-title { font-size: 14px; font-weight: 600; color: #202124; line-height: 1.35; }
  .mobile-doc-details { display: flex; flex-direction: column; gap: 4px; font-size: 12.5px; color: #5f6368; margin-bottom: 10px; }
  .mobile-doc-details span { color: #70757a; }
  .mobile-doc-actions { display: flex; align-items: center; gap: 8px; margin-top: 10px; border-top: 1px solid #f1f3f4; padding-top: 10px; }

  @media (max-width: 768px) {
    .desktop-table-card { display: none; }
    .mobile-doc-list { display: flex; }
    .search-input-group { width: 100%; }
    .btn-search { flex: 1; justify-content: center; }
  }
</style>
@endpush

@section('content')

  {{-- Page Toolbar --}}
  <div class="page-toolbar">
    <div>
      <div class="page-heading">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#d93025" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
        Tempat Sampah Dokumen (Trash)
      </div>
      <div class="page-heading-sub">Dokumen yang dihapus tersimpan di sini dan dapat dipulihkan atau dihapus permanen</div>
    </div>
    <a href="{{ route('documents.search') }}" class="btn-reset" style="background:#fff">
      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
      Kembali ke Pencarian
    </a>
  </div>

  @if(session('success'))
    <div style="background:#e6f4ea;border:1px solid #ceead6;color:#137333;padding:12px 16px;border-radius:10px;margin-bottom:16px;font-size:13.5px;display:flex;align-items:center;gap:8px">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      {{ session('success') }}
    </div>
  @endif

  {{-- Search Bar --}}
  <div class="search-bar-wrap">
    <form action="{{ route('documents.trash') }}" method="GET" style="display:flex;gap:12px;width:100%;align-items:center;flex-wrap:wrap">
      <div class="search-input-group">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari dokumen yang terhapus di sampah...">
      </div>

      <button type="submit" class="btn-search">Cari</button>

      @if($q)
        <a href="{{ route('documents.trash') }}" class="btn-reset">Reset</a>
      @endif
    </form>
  </div>

  <div class="result-meta">
    <span>Terdapat</span>
    <span class="result-badge">{{ $documents->total() }} dokumen</span>
    <span>di Tempat Sampah</span>
  </div>

  {{-- Desktop Table Card --}}
  <div class="table-card desktop-table-card">
    <div class="table-scroll-wrap">
      <table class="doc-table">
        <thead>
          <tr>
            <th class="center" style="width:46px">No</th>
            <th style="min-width:180px">Judul</th>
            <th style="min-width:340px">Nomor, Tanggal & Perihal</th>
            <th style="min-width:110px">Kategori</th>
            <th style="min-width:140px">Pengupload</th>
            <th class="center" style="min-width:120px">Tanggal Dihapus</th>
            <th class="center" style="min-width:150px">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($documents as $index => $doc)
            <tr>
              <td class="center td-no">{{ $documents->firstItem() + $index }}</td>

              <td>
                <div class="doc-title">{{ $doc->title }}</div>
              </td>

              <td>
                <div class="doc-nomor">{{ $doc->nomor_surat ?: '-' }}</div>
                @if($doc->tanggal_surat)
                  <div class="doc-date" style="font-size:12px;color:#70757a;margin-top:2px;display:flex;align-items:center;gap:4px">
                    📅 {{ $doc->tanggal_surat->format('d M Y') }}
                  </div>
                @endif
                @if($doc->perihal)
                  <div class="doc-perihal" style="font-size:12.5px;color:#70757a;margin-top:3px;line-height:1.4">{{ Str::limit($doc->perihal, 140) }}</div>
                @endif
              </td>

              <td>
                <span class="cat-badge">{{ $doc->category->name ?? '-' }}</span>
              </td>

              <td>
                <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#5f6368">
                  <span style="min-width:22px;padding:0 4px;height:22px;border-radius:11px;background:#f1f3f4;color:#5f6368;display:inline-flex;align-items:center;justify-content:center;font-weight:600;font-size:9.5px;flex-shrink:0">
                    {{ $doc->uploader->initials ?? 'US' }}
                  </span>
                  <span>{{ $doc->uploader->name ?? '-' }}</span>
                </div>
              </td>

              <td class="center" style="font-size:12px;color:#d93025;font-weight:500">
                {{ $doc->deleted_at ? $doc->deleted_at->format('d M Y H:i') : '-' }}
              </td>

              <td class="center">
                <div class="action-wrap">
                  {{-- Restore --}}
                  <form action="{{ route('documents.restore', $doc->id) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-restore" title="Pulihkan Dokumen" onclick="return confirm('Pulihkan dokumen ini dari Tempat Sampah?')">
                      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                      Pulihkan
                    </button>
                  </form>

                  {{-- Force Delete --}}
                  <form action="{{ route('documents.forceDelete', $doc->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-force-del" title="Hapus Permanen" onclick="return confirm('⚠️ PERINGATAN: Menghapus permanen akan menghapus file fisik dokumen & seluruh lampirannya dari server!\n\nYakin hapus permanen?')">
                      <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                      Hapus Permanen
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7">
                <div class="empty-state">
                  <div class="empty-icon">🗑️</div>
                  <div class="empty-title">Tempat Sampah Kosong</div>
                  <div class="empty-sub">Tidak ada dokumen yang terhapus saat ini.</div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($documents->hasPages())
      <div class="pagination-wrap">
        {{ $documents->onEachSide(1)->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>

  {{-- Mobile Document Cards --}}
  <div class="mobile-doc-list">
    @forelse($documents as $doc)
      <div class="mobile-doc-card">
        <div class="mobile-doc-top">
          <div class="mobile-doc-title">{{ $doc->title }}</div>
          <span style="background:#fce8e6;color:#d93025;font-size:11px;font-weight:600;padding:2px 8px;border-radius:12px;height:fit-content">Terhapus</span>
        </div>

        <div class="mobile-doc-details">
          <div><span>Nomor:</span> <strong>{{ $doc->nomor_surat ?: '-' }}</strong></div>
          <div><span>Kategori:</span> <strong>{{ $doc->category->name ?? '-' }}</strong></div>
          <div><span>Pengupload:</span> <strong>{{ $doc->uploader->name ?? '-' }}</strong></div>
          <div><span>Dihapus Pada:</span> <strong style="color:#d93025">{{ $doc->deleted_at ? $doc->deleted_at->format('d M Y H:i') : '-' }}</strong></div>
        </div>

        @if($doc->perihal)
          <div style="font-size:12.5px;color:#70757a;margin-bottom:8px">{{ Str::limit($doc->perihal, 100) }}</div>
        @endif

        <div class="mobile-doc-actions">
          <form action="{{ route('documents.restore', $doc->id) }}" method="POST" style="flex:1">
            @csrf
            <button type="submit" class="btn-restore" style="width:100%" onclick="return confirm('Pulihkan dokumen ini?')">
              Pulihkan
            </button>
          </form>

          <form action="{{ route('documents.forceDelete', $doc->id) }}" method="POST" style="flex:1">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-force-del" style="width:100%" onclick="return confirm('Hapus permanen dokumen ini beserta file servernya?')">
              Hapus Permanen
            </button>
          </form>
        </div>
      </div>
    @empty
      <div class="table-card" style="padding:40px 20px;text-align:center">
        <div class="empty-icon">🗑️</div>
        <div class="empty-title">Tempat Sampah Kosong</div>
        <div class="empty-sub">Tidak ada dokumen yang terhapus.</div>
      </div>
    @endforelse

    @if($documents->hasPages())
      <div class="pagination-wrap" style="background:#fff;border-radius:12px;border:1px solid #e8eaed;margin-top:4px">
        {{ $documents->onEachSide(1)->withQueryString()->links('pagination::bootstrap-5') }}
      </div>
    @endif
  </div>

@endsection
