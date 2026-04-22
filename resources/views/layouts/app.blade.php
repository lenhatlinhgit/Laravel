<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=DM+Sans:wght@400;500;700&display=swap"
        rel="stylesheet">
</head>
<body>
    <div class="container">
    @include('layouts.header')

    @yield('content')

    @include('layouts.footer')
    </div>
</body>
<script src="{{ asset('javascript/script.js') }}" defer></script>
</html>