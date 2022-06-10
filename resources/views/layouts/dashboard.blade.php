<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/icon/logo.ico') }}">

    {{-- font-awesome --}}
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/css/ready.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css">
    <link rel="stylesheet" href="{{ asset('dt/dataTables.bootstrap4.min.css') }}">
    {{-- preloader css --}}
    <link rel="stylesheet" href="{{ asset('css/preloader.css') }}">
    @stack('css')
    <style>
        .navbar-nav .dropdown button i {
            width: 25px;
        }

        #preloader {
            z-index: 9999;
        }

        .loadAnimation div {
            border: 6px solid #1D62F0;
            border-color: #1D62F0 transparent transparent transparent;
        }
    </style>
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

    <div class="wrapper">
        <div class="main-header">
            <div class="logo-header">
                <a href="/" class="logo" style="text-decoration: none">
                    Lab Komputer
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-sliders-h"></i>
                </button>
                <button class="topbar-toggler more"><i class="fas fa-ellipsis-v"></i></button>
            </div>
                <nav class="navbar navbar-header navbar-expand-lg">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                        </ul>
                        <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ auth()->user()->nama }}
                                </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <button class="dropdown-item text-dark" data-toggle="modal" data-target="#gantiPass"><i class="fas fa-key"></i>Ganti Password</button>
                                        <button class="dropdown-item" onclick="document.location.href = '/logout'"><i class="fas fa-sign-out-alt"></i>Logout</button>
                                    </div>
                                    <!-- /.dropdown-user -->
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="sidebar">
                <div class="scrollbar-inner sidebar-wrapper">
                    <ul class="nav">
                        <li class="nav-item {{ (Request::is('dashboard')) ? 'active' : '' }}">
                            <a href="/dashboard">
                                <i class="fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ (Request::segment(2) == 'mahasiswa') ? 'active' : '' }}">
                            <a href="/dashboard/mahasiswa">
                                <i class="fas fa-user"></i>
                                <p>Mahasiswa</p>
                            </a>
                        </li>
                        @if (auth()->user()->level == "admin")
                            <li class="nav-item {{ (Request::segment(2) == 'dosen') ? 'active' : '' }}">
                                <a href="/dashboard/dosen">
                                    <i class="fas fa-user-tie"></i>
                                    <p>Dosen</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item {{ (Request::segment(2) == 'pembayaran') ? 'active' : '' }}">
                            <a href="/dashboard/pembayaran">
                                <i class="fas fa-file"></i>
                                <p>Slip Pembayaran</p>
                            </a>
                        </li>
                        @if (auth()->user()->level == "admin")
                            <li class="nav-item {{ (Request::segment(2) == 'master') ? 'active' : '' }}">
                                <a href="/dashboard/master">
                                    <i class="fas fa-suitcase"></i>
                                    <p>Master Data</p>
                                </a>
                            </li>
                            <li class="nav-item {{ (Request::segment(2) == 'pengaturan') ? 'active' : '' }}">
                                <a href="/dashboard/pengaturan">
                                    <i class="fas fa-cog"></i>
                                    <p>Pengaturan</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <div class="modal fade" id="gantiPass" tabindex="-1" aria-labelledby="gantiPassLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gantiPassLabel">Ganti Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/password" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="oldPass">Password Lama</label>
                            <input type="password" class="form-control" id="oldPass" name="oldPass" required>
                        </div>
                        <div class="form-group">
                            <label for="newPass">Password Baru</label>
                            <input type="password" class="form-control" id="newPass" name="newPass" minlength="4" required>
                        </div>
                        <div class="form-group">
                            <label for="conPass">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="conPass" name="conPass" minlength="4" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="{{ asset('admin/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/js/ready.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js "></script>
    <script src="{{ asset('js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('dt/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dt/dataTables.bootstrap4.min.js') }}"></script>
    @stack('script')
    <script>
        if (sessionStorage.getItem('preloaderDashboard') == null){
            $('#preloader').css('visibility', 'visible');
            $(document).ready(function() {
                $('#preloader').delay(300).fadeOut(500, 0);
            });
            sessionStorage.clear();
            sessionStorage.setItem('preloaderDashboard', 'true');
        }
        $('html').css('visibility', 'visible');
    </script>
    @livewireScripts
</body>
</html>
