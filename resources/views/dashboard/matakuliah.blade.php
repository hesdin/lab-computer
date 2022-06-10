@extends('layouts.dashboard')

@section('content')

<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Daftar Mata Kuliah Praktikum</h4>
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
                    @livewire('daftar-matakuliah')
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Mata Kuliah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/dashboard/master/matakuliah/tambah" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="matakuliah">Nama mata kuliah</label>
                        <input type="text" class="form-control" name="matakuliah" id="matakuliah" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control selectpicker" data-live-search="true" title="- Pilih -" name="semester" id="semester" required>
                            @for ($i = 1; $i <= 8; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
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
                    document.location.href = '/dashboard/master/matakuliah/'+id+'/hapus';
                }
            });
        }
    </script>
@endpush