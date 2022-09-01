<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>How To Install Vue 3 in Laravel 9 with Vite</title>

  @vite('resources/scss/app.scss')
</head>
<body>
<div id="app"></div>

@vite('resources/js/app.js')
</body>
</html>