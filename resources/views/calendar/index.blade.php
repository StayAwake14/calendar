<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
     

        <div class="container mx-auto">
            @extends('calendar.app')
            @section('content')
            @endsection

            @extends('auth.login')
            @section('login')
            @endsection
        </div>
    </body>
</html>