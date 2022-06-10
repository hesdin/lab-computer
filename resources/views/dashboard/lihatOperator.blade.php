@extends('layouts.dashboard')

@push('css')
    <style>
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
                                    <td>NIDN</td>
                                    <td>:</td>
                                    <td>{{ $data->username }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>
                        Mata Kuliah
                        <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#tambahMatakuliah"><i class="fas fa-plus-circle mr-2"></i>Tambah</button>
                        <div class="clearfix"></div>
                    </h5>
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr class="d-flex">
                                <th scope="col" class="col-1">#</th>
                                <th scope="col" class="col-5">Nama Matakuliah</th>
                                <th scope="col" class="col-2">Jumlah Mahasiswa</th>
                                <th scope="col" class="col-4 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data_matkul->count() > 0)
                                @foreach ($data_matkul as $matkul)
                                    <tr class="d-flex">
                                        @php
                                            $totalProgram = \App\Models\Program::where('id_matakuliah', $matkul->id_matakuliah)->get()->count();
                                        @endphp
                                        <th scope="row" class="col-1">{{ $loop->iteration }}</th>
                                        <td class="col-5">{{ $matkul->matakuliah }}</td>
                                        <td class="col-2">{{ $totalProgram }}</td>
                                        <td class="col-4 text-center">
                                            <button class="btn btn-danger btn-sm" onclick="hapus({{ $matkul->id }})"><i class="fas fa-trash mr-2"></i>Hapus</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="d-flex">
                                    <td class="col-12 text-center text-muted" colspan="5"><i>Belum ada data</i></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-sm" onclick="window.history.back()">Kembali</button>
                    <div class="float-right">
                        <button class="btn btn-outline-danger btn-sm" onclick="hapus({{ $data->id }})">Hapus Akun</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tambahMatakuliah" tabindex="-1" aria-labelledby="tambahMatakuliahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahMatakuliahLabel">Tambah Praktikum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5">
                <form action="/dashboard/dosen/{{ $data->id }}/simpan" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="matakuliah">Mata Kuliah</label>
                        <select class="form-control selectpicker" data-live-search="true" title="- Pilih -" id="matakuliah" name="matakuliah" required>
                            @foreach ($daftarMatakuliah as $matakuliah)
                                <option value="{{ $matakuliah->id }}">{{ $matakuliah->matakuliah }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script>
        function hapus (id) {
            swal({
                title: "Ingin menghapus mata kuliah ini?",
                icon: "warning",
                buttons: [
                    'Batal',
                    'Hapus'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    document.location.href = '{{ Request::url() }}'+ '/' + id + '/hapus';
                }
            });
        }
    </script>
@endpush
