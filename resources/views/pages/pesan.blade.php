@extends('layouts.akunSaya')

@section('title', 'Pesan')

@section('content')
<table class="table table-hover my-4">
    <thead>
        <tr class="d-flex">
            <th scope="col" class="col-1">#</th>
            <th scope="col" class="col-5">Nama</th>
            <th scope="col" class="col-3">Waktu</th>
            <th scope="col" class="col-3"></th>
        </tr>
    </thead>
    <tbody>
        <tr class="d-flex">
            <td colspan="4" class="col-12 text-center text-muted">Tidak ada pesan</td>
        </tr>
    </tbody>
</table>
<button class="btn btn-outline-info btn-block" type="button" onclick="document.location.href = '/myaccount'">Kembali</button>
@endsection