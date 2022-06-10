<div>
    <div class="form-group">
        <label for="fakultas">Fakultas <span class="text-danger">*</span></label>
        <div wire:ignore>
            <select wire:model="fakultas" name="fakultas" id="fakultas" class="custom-select" required>
                <option value="" hidden>- Pilih -</option>
                <option value="fisip">Fakultas Ilmu Sosial Politik</option>
                <option value="fkip">Fakutlas Keguruan dan Ilmu Pendidikan</option>
                <option value="mipa">Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                <option value="teknik">Fakultas Teknik</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="prodi">Program Studi <span class="text-danger">*</span></label>
        <select wire:model="prodi" class="custom-select" name="prodi" id="prodi" {{ ($daftarProdi->count() > 0) ? 'required' : 'disabled' }}>
            <option value="" hidden selected>- Pilih -</option>
            @foreach ($daftarProdi as $prodi)
                <option value="{{ $prodi->id }}">{{ $prodi->prodi }}</option>
            @endforeach
        </select>
    </div>
</div>
