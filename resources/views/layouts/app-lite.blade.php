<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="apple-touch-icon" sizes="192x192" href="{{ url('/images/app/192x192.png') }}">
        <link rel="icon" type="image/png" href="{{ url('/images/app/64x64.png') }}" sizes="64x64">
        <link rel="manifest" href="{{ url('/manifest.json') }}">
        <link rel="mask-icon" href="{{ url('/images/app/192x192.png') }}" color="#FE5F55">
        <link rel="shortcut icon" href="{{ url('/favicon.png') }}">
        <meta name="theme-color" content="#FE5F55">
    </head>

    <body>
        <div id="app" v-cloak>
            @yield('content')
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
