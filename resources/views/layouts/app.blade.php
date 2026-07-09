<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', config('app.name'))</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased bg-bg text-text flex flex-col min-h-screen">
    @include('components.navbar')

    <main id="app" class="flex-1">
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>
</html>

