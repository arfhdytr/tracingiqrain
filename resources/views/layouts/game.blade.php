<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracing Game</title>
    
    {{-- Ini memuat CSS dari public/game/style.css --}}
    <link rel="stylesheet" href="{{ asset('game/style.css') }}">
    
</head>
<body>

    {{-- Ini adalah tempat 'index.blade.php' akan memuat HTML-nya --}}
    @yield('content')

    {{-- Ini memuat JavaScript dari public/game/app.js (LOGIKA GAME-NYA) --}}
    <script src="{{ asset('game/app.js') }}"></script>
    
</body>
</html>