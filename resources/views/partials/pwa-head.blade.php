<!-- PWA Meta & Manifest -->
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#1a73e8">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="cariArsip">
<link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192x192.png">

<!-- Service Worker Registration -->
<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('/sw.js')
        .then(function(registration) {
          console.log('cariArsip ServiceWorker registered with scope:', registration.scope);
        })
        .catch(function(err) {
          console.error('cariArsip ServiceWorker registration failed:', err);
        });
    });
  }
</script>
