<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{  config('app.name') }}</title>

        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
        />
    </head>
    <body class="antialiased">
        <div id="root"></div>
        @vite('resources/js/index.jsx')
    </body>
</html>
