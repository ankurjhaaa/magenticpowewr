<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Magnetic Power Battery'))</title>
    <meta name="description" content="@yield('meta_description', 'Magnetic Power Battery — professional Lithium-ion Battery Manufacturer specializing in LFP and NMC battery technologies for electric mobility and energy storage.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-neutral-950 text-neutral-100 antialiased">
    @include('partials.public-header')

    <main>
        @yield('content')
    </main>

    @include('partials.public-footer')
</body>
</html>
