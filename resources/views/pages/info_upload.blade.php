@extends('layouts.default')

@push('css')
    <style>
        body {
            background-color: #DDD;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="card my-5">
            <div class="card-body text-center">
                <span class="text-muted"><b style="color: rgb(71, 67, 67)">Detail Mata Kuliah</b></span>
                <p><small>Ketik atau tulis nama mata kuliah praktikum yang di program pada bukti slip praktikum <b style="color: red">Transfer Bank, Mobil Banking atau Bank Mega UIM</b> seperti berikut:
                </small></p>
                <img style="width: 280px; height: 170px" src="{{asset('./img/foto/RIDWAN_Edit.jpg')}}" alt=""/></br></br>
                <img style="width: 280px; height: 170px" src="{{asset('./img/foto/Mobil.jpg')}}" alt=""/></br></br>
                <img style="width: 280px; height: 170px" src="{{asset('./img/foto/Alif_Anugrah.jpg')}}" alt=""/></br></br>
                <button class="btn btn-outline-info btn-block" type="button" onclick="document.location.href = '/myaccount'">Kembali</button>
            </div>
        </div>
    </div>
@endsection
