@extends('layouts.dashboard')

@section('content')

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Pengaturan</h4>
            <div class="card rounded p-4">
                <form action="/dashboard/pengaturan/simpan" method="POST">
                    @csrf
                    <div class="card-body">
                        <h5>Operasional</h5>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group row">
                                    <label for="semester" class="col-sm-7 col-form-label">Semester aktif</label>
                                    <div class="col-sm-5">
                                        <select name="semester" id="semester" class="custom-select" required>
                                            <option value="" hidden>- Pilih -</option>
                                            <option value="ganjil" {{ ($semester == 'ganjil') ? 'selected' : '' }}>Ganjil</option>
                                            <option value="genap" {{ ($semester == 'genap') ? 'selected' : '' }}>Genap</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="upload" class="col-sm-7 col-form-label">Upload slip pembayaran</label>
                                    <div class="col-sm-5">
                                        <select name="upload" id="upload" class="custom-select" required>
                                            <option value="" hidden>- Pilih -</option>
                                            <option value="buka" {{ ($upload == 'buka') ? 'selected' : '' }}>Terbuka</option>
                                            <option value="tutup" {{ ($upload == 'tutup') ? 'selected' : '' }}>Tertutup</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">

                            </div>
                        </div>
                        <hr>
                        <h5>Reset Data</h5>
                        <div class="row">
                            <div class="col-sm">
                                <div class="form-group row">
                                    <label class="col-sm-8 col-form-label">Hapus semua data</label>
                                    <button class="btn btn-outline-danger col-sm-4" type="button" onclick="hapusData('semua')"><i class="fas fa-eraser mr-2"></i>Hapus</button>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-8 col-form-label">Hapus data slip praktikum</label>
                                    <button class="btn btn-outline-danger col-sm-4" type="button" onclick="hapusData('slip')"><i class="fas fa-eraser mr-2"></i>Hapus</button>
                                </div>
                            </div>
                            <div class="col-sm">

                            </div>
                        </div>
                        <hr>
                        <h5>Pengumuman</h5>
                        <div class="form-group">
                            <label for="judul">Judul Pengumuman</label>
                            <input type="text" class="form-control" id="judul" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="isiPengumuman">Konten</label>
                            <textarea class="form-control" id="isiPengumuman" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <button class="btn btn-info"><i class="fas fa-save mr-3"></i>Simpan</button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    @if (Session::has('berhasil'))
        <script>
            swal("Berhasil", "{{ Session::get('berhasil') }}", "success");
        </script>
    @endif
    <script>
        function hapusData(aksi) {
            if (aksi == "semua") {
                swal({
                    title: "Anda yakin ingin melanjutkan?",
                    text: "Semua data dosen, mahasiswa, dan slip akan hilang",
                    icon: "warning",
                    buttons: [
                        'Batal',
                        'Lanjut'
                    ],
                    dangerMode: true,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = '/dashboard/pengaturan/hapus/data';
                    }
                });
            } else if (aksi == "slip") {
                swal({
                    title: "Anda yakin ingin melanjutkan?",
                    text: "Semua data slip praktikum akan hilang",
                    icon: "warning",
                    buttons: [
                        'Batal',
                        'Lanjut'
                    ],
                    dangerMode: true,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        document.location.href = '/dashboard/pengaturan/hapus/slip';
                    }
                });
            }
        }
    </script>
@endpush
