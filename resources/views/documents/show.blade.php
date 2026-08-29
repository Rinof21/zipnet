@extends('layouts.app2')

@section('content')
  <div class="container-fluid">
    <h4 class="mb-4">{{ $document->title }}</h4>

    <iframe src="{{ route('documents.preview', $document->id) }}" width="100%" height="650px"></iframe>
  </div>
@endsection
