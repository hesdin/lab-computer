@extends('layouts.default')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .carousel {
            display: none;
        }

        body {
            background-color: #FFF;
        }

        #contact {
            background: rgb(160,104,173);
            background: linear-gradient(37deg, rgba(160,104,173,1) 0%, rgba(32,20,87,1) 100%);
        }

        .contact p {
            margin: 0px;
        }

        .loadAnimation div {
            border: 6px solid #440099;
            border-color: #4400AA transparent transparent transparent;
        }
    </style>
@endpush

@section('content')
    <div id="carouselHome" class="carousel slide d-md-block" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselHome" data-slide-to="0" class="active"></li>
            <li data-target="#carouselHome" data-slide-to="1"></li>
            <li data-target="#carouselHome" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/carousel/1.jpg') }}" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/carousel/2.jpg') }}" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('img/carousel/3.jpg') }}" class="d-block w-100">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselHome" role="button" data-slide="prev">
            <div class="rounded border border-light">
                <span class="fas fa-chevron-left m-3" aria-hidden="true"></span>
            </div>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselHome" role="button" data-slide="next">
            <div class="rounded border border-light">
                <span class="fas fa-chevron-right m-3" aria-hidden="true"></span>
            </div>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <section id="welcome" class="text-center p-4 mb-5">
        <div class="container">
            <h5 class="text-primary">WELCOME</h5>
            <h3><strong>Selamat Datang</strong></h3>
            <hr>
            <h5>Laboratorium Komputer UIM</h5>
            <p class="lead px-sm-2 px-lg-5">
                Sekarang Lab Komputer dapat diakses dimana saja. Disini Anda dapat melakukan pengumpulan slip pembayaran praktikum tanpa harus tatap muka{!! (Auth::guest()) ? ', jika Anda belum punya akun silahkan mendaftar dengan cara klik <a data-toggle="modal" href="#register" data-target="#register">disini</a>.' : '.' !!}
            </p>
        </div>
    </section>

    <section id="pengumuman">
        <div class="jumbotron jumbotron-fluid">
            <div class="container text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-primary">ANNOUNCEMENT</h5>
                        <h3><strong>Pengumuman</strong></h3>
                        <hr>
                        <div class="py-3">
                            <p class="text-muted"><i>Tidak ada pengumuman terbaru</i></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="p-4 mb-3 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <img src="{{ asset('img/faq.jpg') }}" alt="faq" style="
                    object-fit: cover;
                    width: 100%;
                    border-radius: 15px;
                    margin-bottom: 20px;">
                </div>
                <div class="col-sm-6">
                    <h5 class="text-primary">FREQUENTLY ASKED QUESTIONS</h5>
                    <h3><strong>Pertanyaan yang sering ditanya</strong></h3>
                    <hr class="text-left mx-0 px-0">

                    <div class="accordion" id="questions">
                        {{-- pertanyaan 1 --}}
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left text-decoration-none text-dark font-weight-bold d-flex" type="button" data-toggle="collapse" data-target="#pertanyaan1" aria-expanded="true" aria-controls="pertanyaan1">
                                Bagaimana cara melakukan pendaftaran?
                                <div class="ml-auto bd-highlight align-self-center pl-3"><i class="fa fa-chevron-down"></i></div>
                            </button>
                        </h2>
                        <div id="pertanyaan1" class="collapse collapsed" aria-labelledby="headingOne" data-parent="#questions">
                            <div class="card-body">
                                <p>Jika menggunakan Komputer/Laptop, silahkan klik tombol <b>Login</b> kemudian pilih <b>Register</b> yang ada diatas kanan.</p>
                                <p>Jika menggunakan HP, silahkan menekan tombol <i class="fas fa-bars mx-2"></i> yang ada diatas kanan kemudian pilih <b>Login</b> lalu <b>Register</b>.</p>
                            </div>
                        </div>
                        {{-- pertanyaan 2 --}}
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left text-decoration-none text-dark font-weight-bold d-flex" type="button" data-toggle="collapse" data-target="#pertanyaan2" aria-expanded="true" aria-controls="pertanyaan2">
                                Apa yang harus dilakukan apabila salah input form pendaftaran?
                                <div class="ml-auto bd-highlight align-self-center pl-3"><i class="fa fa-chevron-down"></i></div>
                            </button>
                        </h2>
                        <div id="pertanyaan2" class="collapse collapsed" aria-labelledby="headingTwo" data-parent="#questions">
                            <div class="card-body">
                                Silahkan menghubungi <b>admin</b> atau <b>asisten</b>.
                            </div>
                        </div>
                        {{-- pertanyaan 3 --}}
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left text-decoration-none text-dark font-weight-bold d-flex" type="button" data-toggle="collapse" data-target="#pertanyaan3" aria-expanded="true" aria-controls="pertanyaan3">
                                Saya sudah mendaftar tapi kenapa belum bisa login?
                                <div class="ml-auto bd-highlight align-self-center pl-3"><i class="fa fa-chevron-down"></i></div>
                            </button>
                        </h2>
                        <div id="pertanyaan3" class="collapse collapsed" aria-labelledby="headingThree" data-parent="#questions">
                            <div class="card-body">
                                Anda baru bisa login setelah diverifikasi oleh <b>admin</b> atau <b>asisten</b>.
                            </div>
                        </div>
                        {{-- pertanyaan 4 --}}
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left text-decoration-none text-dark font-weight-bold d-flex" type="button" data-toggle="collapse" data-target="#pertanyaan4" aria-expanded="true" aria-controls="pertanyaan4">
                                Apa yang harus dilakukan jika lupa password?
                                <div class="ml-auto bd-highlight align-self-center pl-3"><i class="fa fa-chevron-down"></i></div>
                            </button>
                        </h2>
                        <div id="pertanyaan4" class="collapse collapsed" aria-labelledby="headingFour" data-parent="#questions">
                            <div class="card-body">
                                Silahkan menghubungi <b>admin</b> atau <b>asisten</b>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="text-center py-5">
        <div class="container">
            <div class="card my-3 py-4">
                <div class="card-body">
                    <h5 class="text-primary">CONTACT</h5>
                    <h3><strong>Hubungi Kami</strong></h3>
                    <hr>
                    <div class="row">
                        <div class="col-lg text-center">
                            <h5 class="py-2">Asisten Lab</h5>
                            <div class="contact">
                                <p><i class="fab fa-whatsapp"></i> : +6282393227030</p>
                                <p><i class="far fa-envelope"></i> : syahrun42@gmail.com</p>
                            </div>
                            <button class="btn btn-outline-info my-3" onclick="whatsApp(6282393227030)"><i class="fab fa-whatsapp mr-2"></i>Chat</button>
                        </div>
                        <div class="col-lg text-center">
                            <h5 class="py-2">Kepala Lab Komputer</h5>
                            <div class="contact">
                                <p><i class="fab fa-whatsapp"></i> : +6285299687087</p>
                                <p><i class="far fa-envelope"></i> : sukirman.dty@uim-makassar.ac.id</p>
                            </div>
                            <button class="btn btn-outline-info my-3" onclick="whatsApp(6285299687087)"><i class="fab fa-whatsapp mr-2"></i>Chat</button>
                        </div>
                        <div class="col-lg text-center">
                            <h5 class="py-2">Asisten Lab</h5>
                            <div class="contact">
                                <p><i class="fab fa-whatsapp"></i> : +6289636642888</p>
                                <p><i class="far fa-envelope"></i> : nyandere3@gmail.com</p>
                            </div>
                            <button class="btn btn-outline-info my-3" onclick="whatsApp(6289636642888)"><i class="fab fa-whatsapp mr-2"></i>Chat</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="about" class="text-center my-5">
        <div class="row">
            <div class="col-sm-4 text-white py-4">
                <i class="fas fa-network-wired fa-3x bg-info rounded-circle pt-4 mb-2" style="width: 100px; height: 100px"></i>
                <h5 class="text-dark">Networking</h5>
                <div class="text-muted">Networking Setup, IP Address</div>
            </div>
            <div class="col-sm-4 text-white py-4">
                <i class="fas fa-robot fa-3x bg-info rounded-circle pt-4 mb-2" style="width: 100px; height: 100px"></i>
                <h5 class="text-dark">Robotics</h5>
                <div class="text-muted">Robot Drone, Humanoid, Maze, dll</div>
            </div>
            <div class="col-sm-4 text-white py-4">
                <i class="fas fa-code fa-3x bg-info rounded-circle pt-4 mb-2" style="width: 100px; height: 100px"></i>
                <h5 class="text-dark">Software Development</h5>
                <div class="text-muted">Desktop, Mobile, dan Web Programming</div>
            </div>
        </div>
    </section>

    @php
        $wasMade = 2020;
        $thisYear = date('Y');
    @endphp

    <section class="text-center py-4" id="footer">
        <div class="text-muted">Copyright © {{ ($thisYear <= $wasMade) ? $wasMade : $wasMade.' - '.$thisYear }} | Lab Komputer UIM</div>
    </section>
@endsection

@push('script')
    @if (Session::has('sukses'))
        <script>
            swal("Berhasil Mendaftar!", "Anda dapat login setelah diverifikasi oleh Admin atau Asisten");
        </script>
    @elseif (Session::has('password'))
        <script>
            swal("Password Error", "{{ Session::get('password') }}", "error");
        </script>
    @elseif (Session::has('error'))
        @if (Session::get('error') == 'NIM sudah terdaftar')
            <script>
                swal("Gagal Mendaftar!", "NIM tersebut sudah terdaftar!", "error");
            </script>
        @else
            <script>
                swal("Gagal Mendaftar!", "Akun Anda gagal terdaftar!", "error");
            </script>
        @endif
    @endif
    <script>
        function whatsApp(nomor) {
            window.open("https://wa.me/"+nomor, "_blank")
        }
    </script>
@endpush
