<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Task List App</title>

    @vite('resources/css/app.css')
    @yield('styles')
</head>

<body>
    <h1>@yield('title')</h1>

    <div>
        @if (session('success'))
            <p class="success-message">{{ session('success') }}</p>
        @endif

        @yield('content')
    </div>
</body>

</html>
