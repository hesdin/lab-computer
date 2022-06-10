@extends('layouts.akunSaya')

@section('title', 'Profil')

@section('content')

    <div class="container pb-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Gagal menyimpan, harap periksa data Anda.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (Session::has('saved'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('saved') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif (Session::has('updated'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('updated') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <form action="{{ ($found) ? '/myaccount/update' : '/myaccount/save' }}" method="POST" id="biodataForm">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="{{ auth()->user()->nama }}" disabled>
                </div>
                <div class="form-group col-md-6">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" name="nim" id="nim" value="{{ auth()->user()->username }}" disabled>
                </div>
            </div>
            @if ($found)
                @livewire('daftar-prodi', ['found' => $found, 'dataFakultas' => $data->fakultas, 'dataProdi' => $data->id_prodi])
            @else
                @livewire('daftar-prodi')
            @endif
            <div class="form-group">
                <label for="hp">No. HP <span class="text-danger">*</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">+62</span>
                    </div>
                    <input type="text" name="hp" id="hp" class="form-control" value="{{ ($found) ? substr($data->no_hp, 3) : '' }}" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" class="form-control" rows="5">{{ ($found) ? $data->bio : '' }}</textarea>
            </div>
            @if ($found)
                <button class="btn btn-success btn-block" type="submit">Update</button>
            @else
                <button class="btn btn-primary btn-block" type="submit">Simpan</button>
            @endif
        </form>
    </div>
@endsection

@push('script')
    <script>
        $("#biodataForm").on('submit', function() {
            $('#waiting').css('visibility', 'visible');
        });
    </script>
@endpush
