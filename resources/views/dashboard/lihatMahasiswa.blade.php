@extends('layouts.dashboard')

@push('css')
    <style>
        .pp {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        table {
            margin-bottom: 20px;
        }
        table td:nth-child(2) {
            padding: 10px 15px;
        }
        table tr td:first-child {
            padding-top: unset;
        }
    </style>
@endpush

@section('content')

@php
    $bio = \App\Models\Biodata::where('id_mahasiswa', $data->id)->first();
@endphp

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">{{ $data->nama }}</h4>
            <div class="card rounded p-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <table>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $data->nama }}</td>
                                </tr>
                                <tr>
                                    <td>NIM</td>
                                    <td>:</td>
                                    <td>{{ $data->username }}</td>
                                </tr>
                                <tr>
                                    <td>Fakultas</td>
                                    <td>:</td>
                                    <td>{{ ($bio) ? ($bio->fakultas == "teknik") ? ucwords($bio->fakultas) : strtoupper($bio->fakultas) : '-' }}</td>
                                </tr>
                                <tr>
                                    @php
                                        if ($bio) {
                                            $prodi = \App\Models\Jurusan::where('id', $bio->id_prodi)->first()->prodi;
                                        }
                                    @endphp
                                    <td>Program Studi</td>
                                    <td>:</td>
                                    <td>{{ ($bio) ? $prodi : '-' }}</td>
                                </tr>
                                <tr>
                                    <td>No. HP</td>
                                    <td>:</td>
                                    <td>{{ ($bio) ? '0'.substr($bio->no_hp, 3) : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm text-center">
                            <img class="pp" src="{{ asset('img/users/'.$data->username.'/'.$data->foto) }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-sm" onclick="window.history.back()">Kembali</button>
                    <div class="float-right">
                        @if ($data->status == '1')
                            @if (auth()->user()->level == 'admin' || auth()->user()->level == 'koasisten')
                                <button class="btn btn-success btn-sm" onclick="document.location.href='{{ Request::url().'/edit' }}'">Edit</button>
                                @if ($data->id != auth()->user()->id)
                                    <button class="btn btn-outline-danger btn-sm" onclick="hapusAkun({{ $data->id }})">Hapus</button>
                                @endif
                            @else
                                <button class="btn btn-outline-success btn-sm" onclick="document.location.href='{{ Request::url().'/'.$data->id.'/edit' }}'"><i class="fas fa-edit mr-2"></i>Edit</button>
                            @endif
                        @else
                            <button class="btn btn-success btn-sm" onclick="verifikasiAkun({{ $data->id }})"><i class="fas fa-check mr-2"></i>Verifikasi</button>
                            <button class="btn btn-outline-danger btn-sm" onclick="tolakAkun({{ $data->id }})"><i class="fas fa-times mr-2"></i>Tolak</button>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        function verifikasiAkun (id) {
            swal({
                title: "Verifikasi akun ini?",
                icon: "warning",
                buttons: [
                    'Batal',
                    'Verifikasi'
                ],
            }).then(function(isConfirm) {
                if (isConfirm) {
                    document.location.href = '/dashboard/mahasiswa/'+id+'/verifikasi';
                }
            });
        }

        function tolakAkun (id) {
            swal({
                title: "Tolak akun ini?",
                text: "Akun akan terhapus dari database!",
                icon: "warning",
                buttons: [
                    'Batal',
                    'Lanjutkan'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    document.location.href = '/dashboard/mahasiswa/'+id+'/hapus';
                }
            });
        }

        function hapusAkun (id) {
            swal({
                title: "Ingin menghapus akun ini?",
                icon: "warning",
                buttons: [
                    'Batal',
                    'Hapus'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    document.location.href = '/dashboard/mahasiswa/'+id+'/hapus';
                }
            });
        }
    </script>
@endpush
