<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sigma sigma boy')</title> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100  antialiased">

    @include('layouts.header')


    <main id="main-content" class="min-h-screen">
        @yield('content')
    </main>
    
    @include('layouts.footer')


    @yield('scripts')

</body>
</html>