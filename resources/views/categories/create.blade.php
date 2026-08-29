@extends('layouts.app2')

@section('content')
  <div class="container" style="max-width:500px;">
    <h4 class="mb-4">Tambah Kategori</h4>

    <form action="{{ route('categories.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
  </div>
@endsection
