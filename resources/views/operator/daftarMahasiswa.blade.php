@extends('layouts.operator')

@section('content')

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Mahasiswa</h4>
            <div class="card rounded p-4">
                <div class="card-header">
                    @php
                        $matkul = \App\Models\Dosen::where('id_dosen', auth()->user()->id)
                        ->join('matakuliah', 'dosen.id_matakuliah', 'matakuliah.id')
                        ->select('matakuliah.id', 'matakuliah.matakuliah', 'matakuliah.semester')->get();
                    @endphp
                    @if ($matkul->count() > 1)
                        <button class="btn btn-primary btn-sm mr-3" onclick="document.location.href = '/o/dashboard/mahasiswa'"><i class="fas fa-arrow-left"></i></button>
                    @endif
                    <h6 class="d-inline-block">Daftar Mahasiswa {{ $matakuliah }}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-responsive-sm">
                        <thead>
                            <tr class="d-flex">
                                <th scope="col" class="col-1">#</th>
                                <th scope="col" class="col-2">NIM</th>
                                <th scope="col" class="col-3">Nama</th>
                                <th scope="col" class="col-2">Status</th>
                                <th scope="col" class="col-4 text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->count() > 0)
                            @foreach ($data as $mahasiswa)
                            <tr class="d-flex">
                                <th scope="row" class="col-1">{{ ($data->currentpage()-1) * $data->perpage() + $loop->index + 1 }}</th>
                                <td class="col-2">{{ $mahasiswa->username }}</td>
                                <td class="col-3"><a href="{{ Request::url().'/'.$mahasiswa->username }}" style="text-decoration: none">{{ $mahasiswa->nama }}</a></td>
                                <td class="col-2">{!! ($mahasiswa->status == '1') ? '<div class="text-success">Terverifikasi</div>' : '<div class="text-danger">Pending</div>' !!}</td>
                                <td class="text-center col-4">
                                    <button class="btn btn-outline-primary btn-sm" onclick="document.location.href='{{ Request::url().'/'.$mahasiswa->username }}'"><i class="fas fa-eye mr-2"></i>Lihat</button>
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
                    <small class="text-danger">* Mahasiswa diurutkan berdasarkan NIM</small>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        {!! $data->onEachSide(1)->links() !!}
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
