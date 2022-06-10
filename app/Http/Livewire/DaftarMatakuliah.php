<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MataKuliah;

class DaftarMatakuliah extends Component
{
    public $search;

    public function render()
    {
        return view('livewire.daftar-matakuliah', [
            'daftarMatakuliah' => $this->search === null ? MataKuliah::orderBy('matakuliah')->get() : MataKuliah::where('matakuliah', 'like', '%' . $this->search . '%')->orderBy('matakuliah')->get()
        ]);
    }
}
