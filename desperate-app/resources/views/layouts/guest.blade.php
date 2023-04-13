<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GatoFeeder</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="{{ URL::asset('/css/login.css') }}" rel="stylesheet" type="text/css" >

        <!-- Scripts -->
    </head>
    <body>
        <section class="nav"> 
        <h1 data-content="Gato">feeder</h1>
        </section>
        <div class="login-shell-case">
            <div class="login-shell">
                <div class="font-sans text-gray-900 antialiased">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
