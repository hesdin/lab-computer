@extends('layouts.akunSaya')

@section('title', 'Slip Pembayaran Praktikum')

@section('content')
    <div class="mb-4">
        <h5 class="d-inline-block">
            Praktikum yang diprogram
        </h5>
        <button class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#tambahMatakuliah"><i class="fas fa-plus-circle mr-2"></i>Tambah</button>
        <div class="clearfix"></div>
    </div>
    <table class="table table-hover table-responsive-sm">
        <thead>
            <tr class="d-flex">
                <th scope="col" class="col-1">#</th>
                <th scope="col" class="col-4">Mata Kuliah</th>
                <th scope="col" class="col-2">Semester</th>
                <th scope="col" class="col text-center">Slip Pembayaran</th>
                <th scope="col" class="col-2 text-center">Opsi</th>
            </tr>
        </thead>
        <tbody>
            @if ($daftarProgram->count() > 0)
                @foreach ($daftarProgram as $program)
                    @php
                        $slip = \App\Models\Slip::where('id_mahasiswa', auth()->user()->id)->where('id_matakuliah', $program->id_matakuliah)->first();
                    @endphp
                    <tr class="d-flex">
                        <th scope="row" class="col-1">{{ $loop->iteration }}</th>
                        <td class="col-4">{{ $program->matakuliah }}</td>
                        <td class="col-2">{{ $program->semester }}</td>
                        <td class="col text-center">
                            @if ($slip)
                                <div class="text-success">Terkirim</div>
                            @else
                                <button class="btn btn-warning btn-sm" onclick="document.location.href = '/myaccount/slip/{{ $program->id }}'"><i class="fas fa-upload mr-2"></i>Upload Slip</button>
                            @endif
                        </td>
                        <td class="col-2 text-center">
                            @if ($slip)
                                <button class="btn btn-danger btn-sm" onclick="batal({{ $slip->id }})"><i class="fas fa-times-circle mr-2"></i>Batal</button>
                            @else
                                <button class="btn btn-outline-danger btn-sm" onclick="hapus({{ $program->id }})"><i class="fas fa-trash mr-2"></i>Hapus</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="col-12 text-center text-muted" colspan="3"><i>Tidak ada data ditemukan</i></td>
                </tr>
            @endif
        </tbody>
    </table>

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
                <form action="/myaccount/slip/tambah" method="POST" id="matakuliahForm">
                    @csrf
                    <div class="modal-body px-5">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $("#matakuliahForm").on('submit', function() {
            $('#waiting').css('visibility', 'visible');
        });

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
                    document.location.href = '/myaccount/slip/'+id+'/hapus';
                }
            });
        }

        function batal(id) {
            swal({
                title: "Batalkan slip pembayaran?",
                icon: "warning",
                buttons: [
                    'Tidak',
                    'Lanjutkan'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    document.location.href = '/myaccount/slip/'+id+'/batal';
                }
            });
        }
    </script>
@endpush
