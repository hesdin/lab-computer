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
    {{-- select --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
    {{-- preloader css --}}
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">
    {{-- waiting animation css --}}
    <link rel="stylesheet" href="{{ asset('css/waiting.css') }}">
    <style>
        body {
            background-color: #DDD;
        }

        .profil img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }


        .profil2 img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 30%;
            margin-bottom: 40px;
        }

        .navbar-nav .dropdown button i {
            width: 30px;
        }

        .lead {
            font-size: 1.05rem;
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

    <div class="container my-5">
        <h3 class="my-4">@yield('title')</h3>
        <div class="row">
            <div class="col-sm-4">
                <div class="card mb-5">
                    <div class="card-body py-5">
                        <div class="profil text-center mb-4">
                            <img class="" src="{{ asset('img/users/'.auth()->user()->username.'/'.auth()->user()->foto) }}" alt="">
                            <h5 class="font-weight-bold mb-1">{{ auth()->user()->nama }}</h5>
                            <p class="lead">{{ ($found) ? $bio->bio : '' }}</p>
                        </div>
                        <div class="nav flex-column nav-pills px-4" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link {{ (Request::is('myaccount')) ? 'active' : '' }}" href="/myaccount">Akun saya</a>
                            <a class="nav-link {{ (Request::segment(2) == "info_upload") ? 'active' : '' }}" href="/myaccount/info_upload">Info Upload</a>
                            <a class="nav-link {{ (Request::segment(2) == "slip") ? 'active' : '' }}"  {!! (!$found) ? 'onclick="notify(event)"' : '' !!} href="/myaccount/slip">Slip Praktikum</a>
                            <a class="nav-link {{ (Request::segment(2) == "pesan") ? 'active' : '' }}" href="/myaccount/pesan">Pesan</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="card-text">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('bootstrap/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    @stack('script')
    <script>
        if (sessionStorage.getItem('preloaderMyAccount') == null){
            $('#preloader').css('visibility', 'visible');
            $(document).ready(function() {
                $('#preloader').delay(300).fadeOut(500, 0);
            });
            sessionStorage.clear();
            sessionStorage.setItem('preloaderMyAccount', 'true');
        }
        $('html').css('visibility', 'visible');

        function notify (e) {
            e.preventDefault();
            swal({ title: "Lengkapi data terlebih dahulu", icon: "error", dangerMode: true});
        }
    </script>
    @if (Session::has('tertutup'))
        <script>
            swal({ title: "{{ Session::get('tertutup') }}", icon: "error", dangerMode: true});
        </script>
    @endif
    @livewireScripts
</body>
</html>
