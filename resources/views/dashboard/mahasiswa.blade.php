@extends('layouts.dashboard')

@section('content')


<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Mahasiswa</h4>
            <div class="card rounded p-4">
                <div class="card-title">
                    Daftar Akun Mahasiswa
                </div>
                <div class="card-body">
                    @if (Session::has('sukses'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('sukses') }}
                        </div>
                    @endif
                    <table id="table_id" class="table table-striped table-bordered" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($data as $mahasiswa)
                                    <tr>
                                        <td>{{ $loop->iteration }}</th>
                                        <td>{{ $mahasiswa->username }}</td>
                                        <td><a href="/dashboard/mahasiswa/{{ $mahasiswa->id }}" style="text-decoration: none">{{ $mahasiswa->nama }}</a></td>
                                        <td>{!! ($mahasiswa->status == '1') ? '<div class="text-success">Terverifikasi</div>' : '<div class="text-danger">Pending</div>' !!}</td>
                                        <td class="text-center">
                                            @if ($mahasiswa->status == '1')
                                                @if (auth()->user()->level == 'admin' || auth()->user()->level == 'koasisten')
                                                    <button class="btn btn-outline-success btn-sm" onclick="document.location.href='{{ Request::url().'/'.$mahasiswa->id.'/edit' }}'"><i class="fas fa-edit mr-2"></i>Edit</button>
                                                    @if ($mahasiswa->id != auth()->user()->id)
                                                        <button class="btn btn-outline-danger btn-sm" onclick="hapusAkun({{ $mahasiswa->id }})"><i class="fas fa-trash mr-2"></i>Hapus</button>
                                                    @endif
                                                @else
                                                    <button class="btn btn-outline-success btn-sm" onclick="document.location.href='{{ Request::url().'/'.$mahasiswa->id.'/edit' }}'"><i class="fas fa-edit mr-2"></i>Edit</button>
                                                @endif
                                            @else
                                                <button class="btn btn-success btn-sm" onclick="document.location.href='/dashboard/mahasiswa/{{ $mahasiswa->id }}'"><i class="far fa-check-square mr-2"></i>Periksa Data</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        $(document).ready( function () {
            $('#table_id').DataTable({
                ordering:  false,
                responsive: true
            });
        } );
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
