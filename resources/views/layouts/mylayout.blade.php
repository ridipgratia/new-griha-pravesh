<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Griha-Pravesh</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
        @yield('extracss')
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-success px-5">
                <img style="height:60px;margin-right:20px" src="https://pnrdassam.org/special-initiative/index_page/img/govtLogo.png" />
                <a class="navbar-brand text-white" href="{{ url('/') }}"><h2 class="">PMAY-G Griha-Pravesh</h2></a>
                <ul class="navbar-nav" style="margin-left:auto;">
                @if (Route::has('login'))
                    @auth
                    <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/dashboard') }}"><div class="btn btn-light">Dashboard</div></a>
                    </li>
                    @else
                    <li class="nav-item active">
                    <a class="nav-link" href="{{ route('login') }}"><div class="btn btn-primary">Login</div></a>
                    </li>
                    @if (Route::has('register'))
                    <!-- <li class="nav-item active">
                    <a class="nav-link" href="{{ route('register') }}">Register <span class="sr-only"></span></a>
                    </li> -->
                    @endif
                    @endauth
                @endif
                </ul>
        </nav>
        @yield('content')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
        @yield('extrajs')
    </body>
</html>
