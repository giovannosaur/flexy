{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Flexy Absensi')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/style2.css') }}" />

  @stack('head')
</head>
<body>

  {{-- NAVBAR INCLUDE --}}
  @include('partials.navbar')

  {{-- CONTENT --}}
  <div class="main">
    @yield('content')
  </div>

  {{-- FOOTER INCLUDE --}}
  @include('partials.footer')

  @stack('scripts')
</body>
</html>
