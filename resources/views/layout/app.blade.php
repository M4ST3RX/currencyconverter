<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Currency Converter</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>
    <body class="antialiased">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('favourites-and-history')) ? 'active' : '' }}" id="navFav" href="{{ route('favourites-and-history') }}">
                                Favourites & History
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="app">
            @yield("content")
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
