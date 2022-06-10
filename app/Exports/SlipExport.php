<?php

namespace App\Exports;

use App\Models\Slip;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Blade;
use Maatwebsite\Excel\Concerns\FromView;

class SlipExport implements FromView
{
    use Exportable;

    private $id;
    private $tanggal_bayar;
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($id)
    {
        $this->id = $id;
        $this->tanggal_bayar;
    }

    public function view(): View
    {
        return view('printexcel.slipExcel', [
            'daftarSlipExcel' => Slip::where('id_matakuliah', $this->id)
            ->join('users', 'users.id', 'slip.id_mahasiswa')
            ->select('tanggal_bayar', 'users.username', 'users.nama', 'nominal')
            ->orderBy('tanggal_bayar')->orderBy('username')->get()]); 
    }

    public function headings(): array
    {
        return [
            'TANGGAL BAYAR',
            'NIM',
            'NAMA',
            'NOMINAL',
        ];
    }
}




