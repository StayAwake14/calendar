<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>

    @yield('login')

    @yield('calendar')

    @yield('profile')

    @yield('absence')

    @yield('reason')

    @yield('register')

    </body>
</html>