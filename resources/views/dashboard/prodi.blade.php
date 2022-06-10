@extends('layouts.dashboard')

@section('content')

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Daftar Program Studi</h4>
            <div class="card rounded p-4">
                <div class="card-body">
                    @if (Session::has('gagal'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ Session::get('gagal') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div>
                        <div class="float-right mb-3">
                            <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#prodi"><i class="fas fa-plus-circle mr-2"></i>Tambah Prodi</button>
                        </div>
                        <div class="clearfix"></div>
                        <table class="table table-hover table-responsive-sm">
                            <thead>
                                <tr class="d-flex">
                                    <th scope="col" class="col-1">#</th>
                                    <th scope="col" class="col-5">Program Studi</th>
                                    <th scope="col" class="col-3">Fakultas</th>
                                    <th scope="col" class="col-3 text-center">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($daftarProdi) > 0)
                                    @foreach ($daftarProdi as $prodi)
                                        <tr class="d-flex">
                                            <th scope="row" class="col-1">{{ ($daftarProdi->currentpage()-1) * $daftarProdi->perpage() + $loop->index + 1 }}</th>
                                            <td class="col-5">{{ $prodi->prodi }}</td>
                                            <td class="col-3">{{ ($prodi->fakultas == "teknik") ? ucfirst($prodi->fakultas) : strtoupper($prodi->fakultas) }}</td>
                                            <td class="col-3 text-center">
                                                <button class="btn btn-outline-danger btn-sm" onclick="hapus({{ $prodi->id }})"><i class="fas fa-trash mr-2"></i>Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="d-flex">
                                        <td colspan="4" class="col-12 text-center text-muted"><i>Tidak ada data</i></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- Modal -->
<div class="modal fade" id="prodi" tabindex="-1" aria-labelledby="prodiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prodiLabel">Tambah Mata Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/dashboard/master/prodi/tambah" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="prodi">Program Studi</label>
                        <input type="text" class="form-control" name="prodi" id="prodi" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Fakultas</label>
                        <select class="form-control" data-live-search="true" title="- Pilih -" name="fakultas" id="fakultas" required>
                            <option value="" hidden selected>- Pilih -</option>
                            <option value="fisip">Fakultas Ilmu Sosial Politik</option>
                            <option value="fkip">Fakutlas Keguruan dan Ilmu Pendidikan</option>
                            <option value="mipa">Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                            <option value="teknik">Fakultas Teknik</option>
                        </select>
                    </div>
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
        function hapus(id) {
            swal({
                title: "Ingin menghapus ini?",
                icon: "warning",
                buttons: [
                    'Batal',
                    'Hapus'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    document.location.href = '/dashboard/master/prodi/'+id+'/hapus';
                }
            });
        }
    </script>
@endpush