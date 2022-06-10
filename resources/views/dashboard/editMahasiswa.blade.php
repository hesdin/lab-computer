@extends('layouts.dashboard')

@section('content')


<div class="main-panel">
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Edit Data Mahasiswa</h4>
            <div class="card rounded p-4">
                <div class="card-title">
                    Isi Data
                </div>
                <div class="card-body py-3 px-lg-5">
                    <form action="{{ Request::url().'/simpan' }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="{{ $data->nama }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" name="nim" id="nim" value="{{ $data->username }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" value="" id="password">
                            <small class="text-danger">Kosongkan apabila tidak ingin mengganti password.</small>
                        </div>
                        @if (auth()->user()->level == 'admin')
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="level">Level</label>
                                        @php
                                            $checkKoas = \App\Models\User::where('level', 'koasisten')->first();
                                        @endphp
                                        <select class="form-control"  name="level" id="level" required>
                                            <option value="user" {{ ($data->level == "user") ? 'selected' : '' }}>Mahasiswa</option>
                                            @if (!$checkKoas || $data->level == "koasisten")
                                                <option value="koasisten" {{ ($data->level == "koasisten") ? 'selected' : '' }}>Koordinator Asisten</option>
                                            @endif
                                            <option value="asisten" {{ ($data->level == "asisten") ? 'selected' : '' }}>Asisten</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control"  name="status" id="status" required>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary btn-block mt-5">Update</button>
                        <button type="button" class="btn btn-outline-secondary btn-block" onclick="window.history.back()">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
