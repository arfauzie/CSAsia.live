<!DOCTYPE html>
<html lang="id" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CSAsia.live - Live Score CS2 Komunitas Asia')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset("images/logo.png") }}">
    @livewireStyles
</head>

<body class="bg-[#0b0f17] text-slate-100 min-h-screen flex flex-col font-sans">

    <!-- Global Header / Navbar -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    @livewireScripts
</body>

</html>