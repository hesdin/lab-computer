<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/icon/logo.ico') }}">
    {{-- bootstrap --}}
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    {{-- font-awesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    {{-- preloader css --}}
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">
    <style>
        html, body {
            width: 100%;
            height: 100vh;
            margin: 0px;
            padding: 0px;
            overflow-x: hidden; 
            scroll-behavior: smooth;
        }

        .image {
            background-color: #DDD;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            min-height: 100vh;
        }

        .image img {
            width: 450px;
        }

        @media only screen and (max-width: 1024px) {
            .image {
                display: none;
            }

            .loginBox {
                padding: 80px;
            }
        }

        .loginBox input {
            background-color: #F8F8F8;
        }
    </style>
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
    <div id="page">
        <div class="row">
            <div class="col-sm image">
                <img src="{{ asset('img/icon/logo.png') }}" alt="">
            </div>
            <div class="col-sm loginBox">
                <div class="row">
                    <div class="col-md-7 mx-auto mt-sm-2 pt-sm-2 mt-lg-5 pt-lg-5">
                        <h2 class="font-weight-bold text-center my-5">Selamat Datang</h2>
                        <form action="/login/verify" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control rounded-pill px-4" id="username" placeholder="Username / NIM" name="username" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control rounded-pill px-4" id="password" placeholder="Password" name="password">
                            </div>
                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible py-2 fade show" role="alert">
                                    {{ Session::get('error') }}
                                    <button type="button" class="close py-1 my-1" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="px-5 my-4">
                                <button type="submit" class="btn btn-primary btn-block rounded-pill">Login</button>
                            </div>
                            <p class="text-muted text-center">Belum punya akun? <a href="/" class="text-decoration-none">Daftar</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <script src="{{ asset('bootstrap/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        if (sessionStorage.getItem('preloaderDashboard') == null){
            $('#preloader').css('visibility', 'visible');
            $(document).ready(function() {
                $('#preloader').delay(300).fadeOut(500, 0);
            });
            sessionStorage.clear();
            sessionStorage.setItem('preloaderDashboard', 'true');
        }
        $('#page').css('visibility', 'visible');
    </script>
</body>
</html>