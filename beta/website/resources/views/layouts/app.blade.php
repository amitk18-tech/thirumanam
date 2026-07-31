<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Thirumanam') }} - @yield('title')</title>
	<link rel="icon" type="image/png" href="/favicon.png">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8B1A1A',
                        rose: '#F24570',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('styles')
</head>
<body class="bg-white text-gray-800">

    <!-- Navigation -->
    @include('layouts.navbar')

    <!-- Notification Ticker -->
    @include('layouts.ticker')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Mobile bottom nav spacer -->
    <div class="md:hidden h-14"></div>

    <!-- Footer -->
    @include('layouts.footer')

    @stack('scripts')
<script>
  document.addEventListener("contextmenu", e => e.preventDefault());
  document.addEventListener("selectstart", e => e.preventDefault());
  document.addEventListener("copy", e => e.preventDefault());
  document.addEventListener("keydown", e => {
    if ((e.ctrlKey || e.metaKey) && ["c","u","s","a"].includes(e.key.toLowerCase())) e.preventDefault();
    if (e.key === "F12" || (e.ctrlKey && e.shiftKey && ["i","j"].includes(e.key.toLowerCase()))) e.preventDefault();
  });
</script>
</body>
</html>
