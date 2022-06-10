@extends('layouts.operator')

@push('css')
    <style>
        tbody tr:hover {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Slip Pembayaran</h4>
            <div class="card rounded p-4">
                <div class="card-header">
                    <h6>Daftar Mata Kuliah Praktikum</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr class="d-flex">
                                <th scope="col" class="col-1">#</th>
                                <th scope="col" class="col-5">Nama Mata Kuliah</th>
                                <th scope="col" class="col-3">Mahasiswa</th>
                                <th scope="col" class="col-3">Jumlah Slip Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() > 0)
                                @foreach ($data as $matakuliah)
                                    @php
                                        $totalProgram = \App\Models\Program::where('id_matakuliah', $matakuliah->id)->get()->count();
                                        $totalSlip = \App\Models\Slip::where('id_matakuliah', $matakuliah->id)->get()->count();
                                    @endphp
                                    <tr class="d-flex" onclick="document.location.href = '{{ Request::url().'/'.$matakuliah->id }}'">
                                        <th scope="row" class="col-1">{{ $loop->iteration }}</th>
                                        <td class="col-5">{{ $matakuliah->matakuliah }}</td>
                                        <td class="col-3">{{ $totalProgram }}</td>
                                        <td class="col-3">{{ $totalSlip }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="d-flex">
                                    <td colspan="5" class="col-12 text-center text-muted"><i>Tidak ada data</i></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
