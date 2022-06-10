@extends('layouts.operator')

@push('css')
    <style>
        hr {
            margin: 30px 0px;
        }
    </style>
@endpush

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Bantuan</h4>
            <div class="card rounded p-4">
                <div class="card-body">
                    <section id="navigasi">
                        <h6>Mahasiswa & Slip Praktikum</h6>
                        <p>Untuk melihat daftar mahasiswa atau slip pembayaran, silahkan klik menu navigasi yang berada disebelah kiri website.</p>
                    </section>
                    <hr>
                    <section id="mhs">
                        <h6>Mahasiswa sudah mendaftar tapi belum tampil</h6>
                        <p>Data mahasiswa baru bisa tampil di <b>halaman mahasiswa</b> apabila mahasiswa yang bersangkutan sudah menambah mata kuliah yang Anda tangani.</p>
                    </section>
                    <hr>
                    <section id="notfound">
                        <h6>Tidak ada data ditemukan</h6>
                        <p>Jika tidak ada data yang tampil pada menu mahasiswa atau slip pembayaran, kemungkinan <b>Admin</b> belum menambahkan mata kuliah Anda. Jika Anda mengalami masalah ini, silahkan hubungi <b>Admin</b> agar bisa menambahkan mata kuliah Anda.</p>
                    </section>
                    <hr>
                    <section id="contact">
                        <h6>Punya masalah lain?</h6>
                        <p>Jika masalah Anda tidak ada di atas atau terdapat kendala lain, silahkan hubungi <b>Admin</b> atau <b>Asisten</b> Lab Komputer.</p>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
