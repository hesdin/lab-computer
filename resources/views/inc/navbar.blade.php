<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm" id="nav">
    <div class="container">
    <a class="navbar-brand" href="/">Lab Komputer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item {{ (Request::is('/')) ? 'active' : '' }}">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/#faq">FAQ</a>
            </li>
            <li class="nav-item {{ (Request::is('informasi')) ? 'active' : '' }}">
                <a class="nav-link" href="/informasi">Informasi</a>
            </li>
            <li class="nav-item {{ (Request::is('bantuan')) ? 'active' : '' }}">
                <a class="nav-link" href="/bantuan">Bantuan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="https://www.youtube.com/watch?v=_M62F6pjIw8" target="_blank">Tutorial</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @if (Auth::guest())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Login
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <button class="dropdown-item" onclick="document.location.href = '/login'"><i class="fas fa-sign-in-alt"></i>Login</button>
                        <button class="dropdown-item" data-toggle="modal" data-target="#register"><i class="fas fa-user-plus"></i>Register</button>
                    </div>
                </li>
            @else
                <li class="nav-item">
                    <a href="#" class="nav-link mr-3"></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->nama }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if (auth()->user()->level == "admin" || auth()->user()->level == "koasisten" || auth()->user()->level == "asisten")
                            @if (auth()->user()->level == "koasisten" || auth()->user()->level == "asisten")
                                <button class="dropdown-item" onclick="document.location.href = '/myaccount'"><i class="far fa-user"></i>Akun Saya</button>
                            @endif
                            <button class="dropdown-item" onclick="document.location.href = '/dashboard'" id="#dashboard">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tachometer-alt"></i>
                                    Dashboard
                                    @php
                                        $jumlahPending = \App\Models\User::where('status', '0')->get()->count();
                                    @endphp
                                    @if ($jumlahPending > 0)
                                        <div class="ml-auto bd-highlight align-self-center pl-3">
                                            <span class="badge badge-danger rounded-pill">{{ $jumlahPending }}</span>
                                        </div>
                                    @endif
                                </div>
                            </button>
                            <button class="dropdown-item" data-toggle="modal" data-target="#gantiPass"><i class="fas fa-key"></i>Ganti Password</button>
                        @elseif (auth()->user()->level == "operator")
                            <button class="dropdown-item" onclick="document.location.href = '/o/dashboard'" id="#dashboard"><i class="fas fa-tachometer-alt"></i>Dashboard</button>
                            <button class="dropdown-item" data-toggle="modal" data-target="#gantiPass"><i class="fas fa-key"></i>Ganti Password</button>
                        @else
                            <button class="dropdown-item" onclick="document.location.href = '/myaccount'"><i class="far fa-user"></i>Akun Saya</button>
                            <button class="dropdown-item" data-toggle="modal" data-target="#gantiPass"><i class="fas fa-key"></i>Ganti Password</button>
                        @endif
                        <div class="dropdown-divider"></div>
                        <button class="dropdown-item" onclick="document.location.href = '/logout'"><i class="fas fa-sign-out-alt"></i>Logout</button>
                    </div>
                </li>
            @endif
        </ul>
    </div>
    </div>
</nav>

@if (Auth::guest())
<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" aria-labelledby="registerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerLabel">Silahkan Lengkapi Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/register" method="POST" enctype="multipart/form-data" id="registerForm">
                @csrf
                <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class=text-danger>*</span></label>
                            <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="nim">NIM <span class=text-danger>*</span></label>
                            <input type="text" class="form-control" name="nim" id="nim" autocomplete="off" minlength="11" maxlength="11" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class=text-danger>*</span></label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="form-group">
                            <label for="foto">Upload Foto Diri <span class=text-danger>*</span></label>
                            <input type="file" class="form-control" accept=".jpg, .png, .jpeg" name="foto" id="foto" required>
                            <small class="form-text text-danger">* Wajib menggunakan foto asli untuk verifikasi</small>
                            <small class="form-text text-danger">* Foto tidak boleh lebih dari 2 MB</small>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@else
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
                        <input type="password" class="form-control" id="newPass" name="newPass" required>
                    </div>
                    <div class="form-group">
                        <label for="conPass">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="conPass" name="conPass" required>
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
@endif

@push('script')
    <script>
        $("#registerForm").on('submit', function() {
            $('#waiting').css('visibility', 'visible');
        });


        var _URL = window.URL || window.webkitURL;
        $("#foto").change(function(e) {
            var file, img;
            if (this.files[0].size > 2097152) {
                swal({ title: "Ukuran file terlalu besar", icon: "error", dangerMode: true });
                document.getElementById('foto').value=null;
            }
            if ((file = this.files[0])) {
                img = new Image();
                img.onerror = function() {
                    swal({ text: "Tipe file tidak didukung: " + file.type, icon: "error", dangerMode: true });
                    document.getElementById('foto').value=null;
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        var url = "{{ Request::url() }}";
        setInterval(function()
        {
            $("#dashboard").load(url+" #dashboard");
        }, 5000);
    </script>
@endpush
