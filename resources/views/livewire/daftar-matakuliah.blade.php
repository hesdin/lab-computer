<div>
    <div class="mb-3">
        <div class="form-inline">
            <input wire:model="search" class="form-control" placeholder="Cari Mata Kuliah">
            <button class="btn btn-primary btn-sm ml-auto" type="button" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus-circle mr-2"></i>Tambah Mata Kuliah</button>
        </div>
    </div>
    <table class="table table-hover table-responsive-sm">
        <thead>
            <tr class="d-flex">
                <th scope="col" class="col-1">#</th>
                <th scope="col" class="col-4">Nama Mata Kuliah</th>
                <th scope="col" class="col-2">Semester</th>
                <th scope="col" class="col-2">Kategori</th>
                <th scope="col" class="col-3 text-center">Opsi</th>
            </tr>
        </thead>
        <tbody>
            @if ($daftarMatakuliah->count() > 0)
                @foreach ($daftarMatakuliah as $matakuliah)
                    <tr class="d-flex">
                        <th scope="row" class="col-1">{{ $loop->iteration }}</th>
                        <td class="col-4">{{ $matakuliah->matakuliah }}</td>
                        <td class="col-2">{{ $matakuliah->semester }}</td>
                        <td class="col-2">{{ ucwords($matakuliah->jenis) }}</td>
                        <td class="col-3 text-center">
                            <button class="btn btn-info btn-sm"><i class="fas fa-edit mr-2"></i>Edit</button>
                            <button class="btn btn-outline-danger btn-sm" onclick="hapus({{ $matakuliah->id }})"><i class="fas fa-trash mr-2"></i>Hapus</button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="d-flex">
                    <td colspan="5" class="col-12 text-center text-muted"><i>Tidak ada data</i></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
