@extends('layouts.dashboard')

@push('css')
    <style>
        .slip img {
            width: 100%;
        }
    </style>
@endpush

@section('content')

@php
    function tanggal($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    $matakuliah = \App\Models\MataKuliah::where('id', $id_matkul)->first();
@endphp


<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Slip Praktikum {{ $matakuliah->matakuliah }}</h4>
            <div class="card rounded p-4">
                <div class="card-body">
                    <button class="btn btn-primary btn-sm" onclick="document.location.href = '/dashboard/pembayaran'"><i class="fas fa-chevron-left mr-2"></i>Kembali</button>
                    <div class="float-right">
                        <button class="btn btn-danger btn-sm" {!! ($daftarSlip->count()) ? 'onclick="document.location.href = \''.Request::url().'/print\'"' : 'disabled' !!}><i class="fas fa-file-pdf mr-2"></i>Download PDF</button>
                        <button class="btn btn-success btn-sm" {!! ($daftarSlip->count()) ? 'onclick="document.location.href = \''.Request::url().'/printexcel\'"' : 'disabled' !!}><i class="fas fa-file-excel mr-2"></i>Download Excel</button>
                    </div>
                    <table class="table table-hover table-responsive-sm mt-3">
                        <thead>
                            <tr class="d-flex">
                                <th scope="col" class="col-1">#</th>
                                <th scope="col" class="col-2">NIM</th>
                                <th scope="col" class="col-3">Nama</th>
                                <th scope="col" class="col-2">Nominal</th>
                                <th scope="col" class="col-2">Tanggal Pembayaran</th>
                                <th scope="col" class="col-2 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($daftarSlip->count() > 0)
                                @foreach ($daftarSlip as $slip)
                                    <tr class="d-flex">
                                        <th scope="row" class="col-1">{{ ($daftarSlip->currentpage()-1) * $daftarSlip->perpage() + $loop->index + 1 }}</th>
                                        <td class="col-2">{{ $slip->username }}</td>
                                        <td class="col-3">{{ $slip->nama }}</td>
                                        <td class="col-2">Rp. {{ number_format($slip->nominal) }}</td>
                                        <td class="col-2">{{ tanggal($slip->tanggal_bayar) }}</td>
                                        <td class="col-2 text-center">
                                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#slip{{ $slip->id }}"><i class="far fa-eye mr-2"></i>Lihat</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="d-flex">
                                    <td colspan="5" class="col-12 text-center text-muted"><i>Tidak ada data</i></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $daftarSlip->onEachSide(1)->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach ($daftarSlip as $slip)
    <!-- Modal -->
    <div class="modal fade" id="slip{{ $slip->id }}" tabindex="-1" aria-labelledby="slip{{ $slip->id }}Label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="slip{{ $slip->id }}Label">Foto Slip Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="slip">
                        <img src="{{ asset('/img/slip/'.$matakuliah->matakuliah.'/'.$slip->username.'/'.$slip->slip )}}" style="border-radius: 15px">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach


@endsection
