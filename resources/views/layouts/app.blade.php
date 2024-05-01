<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Name - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <h1> Teste de desenvolvimento Back-end pleno </h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        © 2024 Thomaz Souza. Todos os direitos Reservados.
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
