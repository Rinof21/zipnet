<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Preview Dokumen</title>
  @include('partials.pwa-head')
  <style>
    body {
      margin: 0;
      padding: 0;
      overflow: hidden;
      background: #000;
    }

    iframe {
      border: none;
      width: 100vw;
      height: 100vh;
    }
  </style>
</head>

<body>
  <iframe src="{{ asset('storage/' . $document->file_path) }}"></iframe>
</body>

</html>
