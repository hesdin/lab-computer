@extends('layouts.operator')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Dashboard</h4>
            <div class="card rounded p-4 text-center">
                <div class="card-body">
                    <h5 class="card-title my-2">Selamat Datang, {{ auth()->user()->nama }}</h5>
                    <div class="card-text px-5">
                        <p>Ini adalah halaman dashboard khusus operator. Disini Anda dapat melihat daftar mahasiswa dan slip pembayaran praktikum dari mata kuliah yang sudah terupload di sistem. Segala sesuatu yang terkait tentang operasional website dapat Anda lihat di halaman bantuan.</p>
                    </div>
                    <a href="/o/dashboard/bantuan" class="btn btn-primary"><i class="far fa-question-circle mr-2"></i>Bantuan</a>
                </div>
                <div class="card-footer text-muted">
                    @php
                        $wasMade = 2020;
                        $thisYear = date('Y');
                    @endphp
                    Copyright © {{ ($thisYear <= $wasMade) ? $wasMade : $wasMade.' - '.$thisYear }} | Lab Komputer UIM
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
