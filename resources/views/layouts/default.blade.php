<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config("app.name") }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/icon/logo.ico') }}">
    {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    {{-- font-awesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    {{-- custom css --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    {{-- preloader css --}}
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">
    {{-- waiting animation css --}}
    <link rel="stylesheet" href="{{ asset('css/waiting.css') }}">
    <style>
        body {
            background: #FFF;
        }

        .navbar-nav .dropdown button i {
            width: 30px;
        }
    </style>
    @stack('css')
    @livewireStyles
</head>
<body>
    <div id="preloader">
        <div class="loadAnimation">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="waiting">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>

    @include('inc.navbar')
    @yield('content')

    <script src="{{ asset('bootstrap/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    @stack('script')
    <script>
        if (sessionStorage.getItem('preloaderDefault') == null){
            $('#preloader').css('visibility', 'visible');
            $(document).ready(function() {
                $('#preloader').delay(300).fadeOut(500, 0);
            });
            sessionStorage.clear();
            sessionStorage.setItem('preloaderDefault', 'true');
        }
        $('html').css('visibility', 'visible');
    </script>
    @livewireScripts
</body>
</html>
