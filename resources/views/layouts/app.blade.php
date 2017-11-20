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
    </head>

    <body>
        <div id="app">
            <nav class="h-16 mb-4">
                <div class="container mx-auto h-full">
                    <div class="flex items-center justify-center h-16">
                        <div class="mr-6">
                            <a href="{{ url('/') }}" class="no-underline font-semibold">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>

                        <div class="flex-1 text-right">
                            @guest
                                <a class="no-underline hover:underline text-grey-darker pr-3 text-sm font-semibold" href="{{ url('/login') }}">Login</a>
                                <a class="no-underline hover:underline text-grey-darker text-sm font-semibold" href="{{ url('/register') }}">Register</a>
                            @else
                                <span class="text-grey-darker text-sm pr-4 font-semibold">{{ Auth::user()->name }}</span>

                                <a href="{{ route('logout') }}"
                                    class="no-underline hover:underline text-grey-darker text-sm font-semibold"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            @endguest
                        </div>
                    </div>
                </div>
            </nav>

            <main class="container mx-auto pb-12">
                @yield('content')
            </main>
        </div>

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
