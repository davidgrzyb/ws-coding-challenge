<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>
        <meta name="description" content="">

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
        <style>
            .body-bg {
                background-color: #8BC6EC;
                background-image: linear-gradient(135deg, #8BC6EC 0%, #9599E2 100%);
            }
        </style>
    </head>
    <body class="body-bg min-h-screen pt-10 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
        <div id="app">
            <app></app>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
