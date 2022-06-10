<?php

namespace App\Http\Controllers;

use PDF;
// use Excel;

use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\ProdiDosen;
use App\Models\Program;
use App\Models\Slip;
use App\Models\User;
use App\Exports\SlipExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Blade;

class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'operator']);
    }

    public function index()
    {
        return view('operator.index');
    }

    public function mahasiswa()
    {
        $data = Dosen::where('id_dosen', auth()->user()->id)
        ->join('matakuliah', 'dosen.id_matakuliah', 'matakuliah.id')
        ->select('matakuliah.id', 'matakuliah.matakuliah', 'matakuliah.semester')->get();
        if ($data->count() == 1) {
            return redirect('/o/dashboard/mahasiswa/'.$data[0]->id);
        }
        return view('operator.mahasiswa', ['data' => $data]);
    }

    public function dataMahasiswa($id, $nim = null)
    {
        if ($nim) {
            $data = User::where('username', $nim)->first();
            if (Program::where('id_matakuliah', $id)->where('id_mahasiswa', $data->id)->get()->count() > 0) {
                return view('operator.lihatMahasiswa', ['data' => $data]);
            }
            return redirect('/o/dashboard/mahasiswa');
        }
        if (Dosen::where('id_matakuliah', $id)->get()->count() > 0) {
            $data = Program::where('id_matakuliah', $id)->join('users', 'program.id_mahasiswa', 'users.id')->where('status', '1')->select('username', 'nama', 'status')->paginate(10);
            $matakuliah = MataKuliah::where('id', $id)->first()->matakuliah;
            return view('operator.daftarMahasiswa', ['data' => $data, 'matakuliah' => $matakuliah]);
        }
        return redirect('/o/dashboard/mahasiswa');
    }

    public function slip()
    {
        $data = Dosen::where('id_dosen', auth()->user()->id)
        ->join('matakuliah', 'dosen.id_matakuliah', 'matakuliah.id')
        ->select('matakuliah.id', 'matakuliah.matakuliah', 'matakuliah.semester')->get();
        if ($data->count() == 1) {
            return redirect('/o/dashboard/slip/'.$data[0]->id);
        }
        return view('operator.slipPraktikum', ['data' => $data]);
    }

    public function lihatSlip($id)
    {
        if (Dosen::where('id_matakuliah', $id)->get()->count() > 0) {
            $slip = Slip::where('id_matakuliah', $id)->join('users', 'users.id', 'slip.id_mahasiswa')->select('slip.id', 'users.username', 'users.nama', 'slip.slip', 'nominal', 'tanggal_bayar')->orderBy('tanggal_bayar')->orderBy('username')->paginate(10);
            return view('operator.lihatSlip', ['daftarSlip' => $slip, 'id_matkul' => $id]);
        }
        return redirect('/o/dashboard/slip');
    }

    public function downloadList($id)
    {
        $slip = Slip::where('id_matakuliah', $id)->join('matakuliah', 'matakuliah.id', 'slip.id_matakuliah')->join('users', 'users.id', 'slip.id_mahasiswa')->select('slip.id', 'users.username', 'users.nama')->orderBy('users.username')->get();
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('print.listPDF', ['daftarSlip' => $slip])->setPaper('Legal');

    	return $pdf->download('Daftar Nama'.'_'.date('d_n_Y'));
    }

    public function downloadListExcel($id)
    {
        $slipexcel = Slip::where('id_matakuliah', $id)->join('matakuliah', 'matakuliah.id', 'slip.id_matakuliah')->join('users', 'users.id', 'slip.id_mahasiswa')->select('slip.id', 'users.username', 'users.nama')->orderBy('users.username')->get();
        $excel = Excel::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('printexcel.listExcel', ['daftarSlipExcel' => $slipexcel])->setPaper('A4');

    	return $excel->download('Daftar Nama'.'_'.date('d_n_Y'));
    }
    
    public function downloadSlipPDF($id)
    {
        $slip = Slip::where('id_matakuliah', $id)->join('matakuliah', 'matakuliah.id', 'slip.id_matakuliah')->join('users', 'users.id', 'slip.id_mahasiswa')->select('slip.id', 'matakuliah.matakuliah', 'users.username', 'users.nama', 'slip.slip', 'tanggal_bayar', 'nominal')->orderBy('tanggal_bayar')->orderBy('username')->get();
        $namaMatakuliah = $slip[0]->matakuliah;
        $contxt = stream_context_create([
            'ssl' => [
            'verify_peer' => FALSE,
            'verify_peer_name' => FALSE,
            'allow_self_signed'=> TRUE
            ]
        ]);

        Blade::directive('nominal', function ($expression) {
            return "Rp. <?php echo number_format($expression, 0,',','.'); ?>";
        });

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('print.slipPDF', ['daftarSlip' => $slip])->setPaper('legal');
        $pdf->getDomPDF()->setHttpContext($contxt);

    	return $pdf->download($namaMatakuliah.'_'.date('d_n_Y'));
    }

    // Export Excel
    public function downloadSlipExcel($id)
    {
        $raw = MataKuliah::find($id)->matakuliah;
        $filename = str_replace('.', '', $raw);
        return Excel::download(new SlipExport($id), str_replace(' ', '-', $filename).'.xlsx');
    }

    public function bantuan()
    {
        return view('operator.bantuan');
    }
}
