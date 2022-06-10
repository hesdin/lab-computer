<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Jurusan;

class DaftarProdi extends Component
{
    public $fakultas;
    public $prodi;
    public $found;
    public $dataFakultas;
    public $dataProdi;


    public function mount()
    {
        $this->fakultas = $this->dataFakultas;
        $this->prodi = $this->dataProdi;
    }

    public function render()
    {
        if ($this->found) {
            return view('livewire.daftar-prodi', [
                'daftarProdi' => Jurusan::where('fakultas', $this->fakultas)->orderBy('prodi')->get(),
                'found' => $this->found,
                'dataFakultas' => $this->dataFakultas,
                'dataProdi' => $this->dataProdi,
            ]);
        } else {
            return view('livewire.daftar-prodi', [
                'daftarProdi' => Jurusan::where('fakultas', $this->fakultas)->orderBy('prodi')->get(),
            ]);
        }
    }
}
