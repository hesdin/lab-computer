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
            <h4 class="page-title">Mahasiswa</h4>
            <div class="card rounded p-4">
                <div class="card-header">
                    <h6>Daftar Mata Kuliah Praktikum</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr class="d-flex">
                                <th scope="col" class="col-1">#</th>
                                <th scope="col" class="col-6">Nama Mata Kuliah</th>
                                <th scope="col" class="col-4">Jumlah Mahasiswa</th>
                                <th scope="col" class="col-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() > 0)
                                @foreach ($data as $matakuliah)
                                    @php
                                        $totalProgram = \App\Models\Program::where('id_matakuliah', $matakuliah->id)->get()->count();
                                    @endphp
                                    <tr class="d-flex" onclick="document.location.href = '{{ Request::url().'/'.$matakuliah->id }}'">
                                        <th scope="row" class="col-1">{{ $loop->iteration }}</th>
                                        <td class="col-6">{{ $matakuliah->matakuliah }}</td>
                                        <td class="col-4">{{ $totalProgram }}</td>
                                        <th class="col-1"><i class="fas fa-chevron-right"></i></th>
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
