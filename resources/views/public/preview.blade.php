<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preview Dokumen - {{ $document->title }}</title>
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
  <iframe src="{{ route('public.preview', ['document' => $document->id, 'stream' => 1]) }}"></iframe>
</body>

</html>
