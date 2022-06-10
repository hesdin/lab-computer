@extends('layouts.akunSaya')

@section('title', 'Slip Pembayaran Praktikum')

@section('content')
    <div class="mb-4">
        <h5 class="d-inline-block">
            Upload Slip Pembayaran Praktikum
        </h5>
    </div>
    <form action="/myaccount/slip/{{ $matakuliah->id }}/tambah" method="POST" enctype="multipart/form-data" id="slipForm">
        @csrf
        <div class="form-group">
            <label for="matakuliah">Nama Mata Kuliah</label>
            <input type="text" class="form-control" name="matakuliah" id="matakuliah" value="{{ $matakuliah->matakuliah }}" autocomplete="off" required disabled>
        </div>
        <div class="form-row">
            <div class="form-group col-sm">
                <label for="pembayaran">Jumlah yang dibayar <span class="text-danger">*</span></label>
                <input type="text" name="pembayaran" id="pembayaran" pattern="[0-9]+" onkeypress="return onlyNumber(event)" class="form-control" placeholder="Rp. 0,00" autocomplete="off" required>
                <small class="text-danger">* Contoh: 200000</small>
            </div>
            <div class="form-group col-sm">
                <label for="tanggal">Tanggal Pembayaran <span class="text-danger">*</span></label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                <small class="text-danger">* Sesuaikan dengan tanggal slip pembayaran</small>
            </div>
        </div>
        <div class="form-group">
            <label for="upload">Upload Slip Pembayaran <span class="text-danger">*</span></label>
            <input type="file" name="upload" id="upload" class="form-control" accept=".jpg, .jpeg, .png" required>
            <small class="text-danger">* Gambar harus berbentuk landscape</small>
        </div>
        <div class="mt-4 mb-2">
            <button class="btn btn-success btn-block" type="submit">Upload</button>
            <button class="btn btn-outline-info btn-block" type="button" onclick="document.location.href = '/myaccount/slip'">Kembali</button>
        </div>
    </form>
@endsection

@push('script')
    <script>
        $("#slipForm").on('submit', function() {
            $('#waiting').css('visibility', 'visible');
        });

        var _URL = window.URL || window.webkitURL;
        $("#upload").change(function(e) {
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();
                img.onload = function() {
                    if (this.width <= this.height) {
                        swal({ text: "Gambar harus berbentuk landscape!", icon: "error", dangerMode: true});
                        document.getElementById('upload').value=null;
                    }
                };
                img.onerror = function() {
                    swal({ text: "Tipe file tidak didukung: " + file.type, icon: "error", dangerMode: true });
                    document.getElementById('upload').value=null;
                };
                img.src = _URL.createObjectURL(file);
            }
        });

        function onlyNumber(e) {
            var inputCode = (e.which) ? e.which : e.keyCode;
            if (inputCode > 31 && (inputCode < 48 || inputCode > 57)) {
                return false;
            }
            return true;
        }

        // Set Minimum dan Maksimal Tanggal
        document.getElementById("tanggal").min = "2018-01-01";

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
        dd = '0' + dd;
        }

        if (mm < 10) {
        mm = '0' + mm;
        }

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("tanggal").setAttribute("max", today);

    </script>
@endpush
