@extends('layouts.dashboard')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Dosen</h4>
            <div class="card rounded p-4">
                <div class="card-title">
                    Daftar Akun Dosen
                    <button class="btn btn-primary btn-sm float-right" type="button" data-toggle="modal" data-target="#modalDosen"><i class="fas fa-plus-circle mr-2"></i>Tambah Dosen</button>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    @if (Session::has('sukses'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('sukses') }}
                        </div>
                    @endif
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr class="d-flex">
                                <th scope="col" class="col-1">#</th>
                                <th scope="col" class="col-3">NIDN</th>
                                <th scope="col" class="col-4">Nama Lengkap</th>
                                <th scope="col" class="col-4 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() > 0)
                                @foreach ($data as $dosen)
                                    <tr class="d-flex">
                                        <th scope="row" class="col-1">{{ ($data->currentpage()-1) * $data->perpage() + $loop->index + 1 }}</th>
                                        <td class="col-3">{{ $dosen->username }}</td>
                                        <td class="col-4">{{ $dosen->nama }}</td>
                                        <td class="text-center col-4">
                                            <button class="btn btn-primary btn-sm" onclick="document.location.href = '/dashboard/dosen/{{ $dosen->id }}'"><i class="fas fa-eye mr-2"></i>Lihat</button>
                                            <button class="btn btn-outline-danger btn-sm" onclick="hapus({{ $dosen->id }})"><i class="fas fa-trash mr-2"></i>Hapus</button>
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
                    <div class="float-right">
                        {!! $data->onEachSide(1)->links() !!}
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDosen" tabindex="-1" aria-labelledby="modalDosenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDosenLabel">Tambah Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/dashboard/dosen/tambah" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="nidn">NIDN</label>
                        <input type="text" class="form-control" name="nidn" id="nidn" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="pass">Password</label>
                        <input type="password" class="form-control" name="pass" id="pass" autocomplete="off" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control selectpicker" data-live-search="true" title="- Pilih -" name="semester" id="semester" required>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        function hapus (id) {
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
                    document.location.href = '/dashboard/dosen/' + id + '/hapus';
                }
            });
        }
    </script>
@endpush
