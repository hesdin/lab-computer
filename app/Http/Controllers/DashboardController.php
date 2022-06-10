<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use File;
use PDF;
//use Excel;

use App\DataTables\MahasiswaDataTable;

use App\Models\Biodata;
use App\Models\Dosen;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Log;
use App\Models\MataKuliah;
use App\Models\Pengaturan;
use App\Models\Program;
use App\Models\Slip;
use App\Exports\SlipExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'dashboard']);
    }

    public function index()
    {
        return view('dashboard.index');
    }

    public function mahasiswa()
    {
        $data = User::where('level', '!=', 'admin')->where('level', '!=', 'operator')->orderBy('status', 'ASC')->orderBy('username', 'ASC')->get();
        return view('dashboard.mahasiswa', ['data' => $data]);
    }

    public function lihatMahasiswa($id)
    {
        $data = User::where('id', $id)->first();
        if ($data->level == "admin") {
            return redirect('/dashboard/mahasiswa');
        }
        return view('dashboard.lihatMahasiswa', ['data' => $data]);
    }

    public function aksiMahasiswa($id, $aksi)
    {
        if ($aksi == 'verifikasi') {
            User::where('id', $id)->update([
                'status' => '1'
            ]);
            return redirect('/dashboard/mahasiswa')->with('sukses', 'Mahasiswa berhasil diverifikasi');
        } elseif ($aksi == 'hapus') {
            if ($id == auth()->user()->id) {
                return redirect('/dashboard/mahasiswa');
            }
            $akun = User::where('id', $id)->first();
            if ($akun->level == "admin") {
                return redirect('/dashboard/mahasiswa');
            }

            File::deleteDirectory(public_path('img/users/'.$akun->username));

            Biodata::where('id_mahasiswa', $id)->delete();
            Program::where('id_mahasiswa', $id)->delete();
            Slip::where('id_mahasiswa', $id)->delete();
            User::where('id', $id)->delete();
            return redirect('/dashboard/mahasiswa')->with('sukses', 'Data telah dihapus');
        } elseif ($aksi == 'edit') {
            $data = User::where('id', $id)->first();
            return view('dashboard.editMahasiswa', ['data' => $data]);
        }
        return redirect('/dashboard/mahasiswa');
    }

    public function updateMahasiswa(Request $req, $id)
    {
        if (auth()->user()->level == 'admin') {
            if ($req->password) {
                User::where('id', $id)->update([
                    'nama' => $req->nama,
                    'username' => $req->nim,
                    'password' => bcrypt($req->password),
                    'level' => $req->level,
                    'status' => $req->status
                ]);
            } else {
                User::where('id', $id)->update([
                    'nama' => $req->nama,
                    'username' => $req->nim,
                    'level' => $req->level,
                    'status' => $req->status
                ]);
            }
        } else {
            if ($req->password) {
                User::where('id', $id)->update([
                    'nama' => $req->nama,
                    'username' => $req->nim,
                    'password' => bcrypt($req->password)
                ]);
            } else {
                User::where('id', $id)->update([
                    'nama' => $req->nama,
                    'username' => $req->nim
                ]);
            }
        }
        return redirect('/dashboard/mahasiswa')->with('sukses', 'Data berhasil diubah');
    }

    public function operator()
    {
        $data = User::where('level', 'operator')->paginate(10);
        return view('dashboard.operator', ['data' => $data]);
    }

    public function tambahOperator(Request $req)
    {
        try {
            $tambah = new User();
            $tambah->username = $req->nidn;
            $tambah->nama = ucwords($req->nama);
            $tambah->password = bcrypt($req->pass);
            $tambah->level = 'operator';
            $tambah->status = '1';
            $tambah->save();
        } catch(\Illuminate\Database\QueryException $e){
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return redirect('/dashboard/dosen')->with('gagal', 'NIDN tersebut sudah terdaftar');
            }
            return redirect('/dashboard/dosen')->with('gagal', 'Akun dosen gagal ditambah');
        }
        return redirect('/dashboard/dosen')->with('sukses', 'Dosen berhasil ditambah');
    }

    public function operatorHapusMatakuliah($id, $id2)
    {
        Dosen::where('id', $id2)->delete();
        return redirect('/dashboard/dosen/'.$id);
    }

    public function aksiOperator($id = null, $aksi = null)
    {
        if ($aksi == 'hapus') {
            User::where('id', $id)->delete();
            return redirect('/dashboard/dosen')->with('sukses', 'Dosen berhasil dihapus');
        } elseif ($aksi == null) {
            $semester = Pengaturan::where('jenis', 'semester')->first()->nilai;
            $data = User::where('id', $id)->first();
            $data_matkul = Dosen::where('id_dosen', $id)->join('matakuliah', 'id_matakuliah', 'matakuliah.id')->select('dosen.id', 'dosen.id_matakuliah', 'matakuliah.matakuliah')->get();
            $matakuliah = MataKuliah::where('jenis', $semester)->orderBy('matakuliah')->get();
            return view('dashboard.lihatOperator', ['data' => $data, 'data_matkul' => $data_matkul, 'daftarMatakuliah' =>$matakuliah]);
        }
    }

    public function simpanOperator(Request $req, $id, $aksi)
    {
        if ($aksi == 'edit') {
            return redirect('/dashboard/dosen');
        } elseif ($aksi == 'simpan') {
            $simpan = new Dosen();
            $simpan->id_dosen = $id;
            $simpan->id_matakuliah = $req->matakuliah;
            $simpan->save();
            return redirect('/dashboard/dosen/'.$id);
        }
    }

    public function slipPembayaran()
    {
        $semester = Pengaturan::where('jenis', 'semester')->first()->nilai;

        $matakuliah = MataKuliah::where('jenis', $semester)->orderBy('matakuliah')->get();

        return view('dashboard.slipPembayaran', ['daftarMatakuliah' => $matakuliah]);
    }

    public function slipPembayaranMatakuliah($id)
    {
        $slip = Slip::where('id_matakuliah', $id)->join('users', 'users.id', 'slip.id_mahasiswa')->select('slip.id', 'users.username', 'users.nama', 'slip.slip', 'nominal', 'tanggal_bayar')->orderBy('tanggal_bayar')->orderBy('username')->paginate(10);
        return view('dashboard.slipMatakuliah', ['daftarSlip' => $slip, 'id_matkul' => $id]);
    }

    // Export PDF
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

        Blade::directive('nominal', function ($expression ) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        });

        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])->loadview('print.slipPDF', ['daftarSlip' => $slip])->setPaper('legal');
        $pdf->getDomPDF()->setHttpContext($contxt);

    	return $pdf->download($namaMatakuliah.'_'.date('d_n_Y'));
    }

    // Export Excel
    public function downloadSlipExcel($id)
    {
        /* Blade::directive('nominal', function ($expression ) {
            return "Rp. <?php echo number_format($expression,0,',','.'); ?>";
        }); */
        // $tanggal_bayar = Carbon::parse()->isoFormat('D MMMM Y');
        $raw = MataKuliah::find($id)->matakuliah;

        $filename = str_replace('.', '', $raw);
        return Excel::download(new SlipExport($id), str_replace(' ', '-', $filename).'.xlsx');
    }
    public function masterData($jenis = null)
    {
        if (auth()->user()->level != "admin") {
            return redirect('/dashboard');
        }
        if ($jenis == "matakuliah") {
            return view('dashboard.matakuliah');
        } elseif ($jenis == "prodi") {
            $prodi = Jurusan::orderBy('fakultas')->paginate(10);
            return view('dashboard.prodi', ['daftarProdi' => $prodi]);
        }
        return view('dashboard.master');
    }

    public function tambahMasterData(Request $req, $jenis)
    {
        if ($jenis == "matakuliah") {
            if ($req->semester % 2 == 0) {
                $kategori = "genap";
            } else {
                $kategori = "ganjil";
            }
            try {
                $insert = new MataKuliah();
                $insert->matakuliah = ucwords($req->matakuliah);
                $insert->semester = $req->semester;
                $insert->jenis = $kategori;
                $insert->save();
            } catch(\Illuminate\Database\QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == '1062'){
                    return redirect('/dashboard/master/matakuliah')->with('gagal', 'Mata Kuliah tersebut sudah ada sebelumnya');
                }
                return redirect('/dashboard/master/matakuliah')->with('gagal', 'Mata Kuliah gagal ditambah');
            }
            return redirect('/dashboard/master/matakuliah');
        } elseif ($jenis == "prodi") {
            try {
                $insert = new Jurusan();
                $insert->prodi = ucwords($req->prodi);
                $insert->fakultas = $req->fakultas;
                $insert->save();
            } catch(\Illuminate\Database\QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == '1062'){
                    return redirect('/dashboard/master/matakuliah')->with('gagal', 'Prodi tersebut sudah ada sebelumnya');
                }
                return redirect('/dashboard/master/matakuliah')->with('gagal', 'Prodi gagal ditambah');
            }
            return redirect('/dashboard/master/prodi');
        }

        return redirect('/dashboard/master/matakuliah');
    }

    public function hapusMasterData($jenis, $id)
    {
        if (auth()->user()->level != "admin") {
            return redirect('/dashboard');
        }
        if ($jenis == "matakuliah") {
            $matkul = MataKuliah::where('id', $id)->first();
            File::deleteDirectory(public_path('img/slip/'.$matkul->matakuliah));

            MataKuliah::where('id', $id)->delete();
            Program::where('id_matakuliah', $id)->delete();
            Slip::where('id_matakuliah', $id)->delete();
            return redirect('/dashboard/master/matakuliah');
        } elseif ($jenis == "jurusan") {
            return redirect('/dashboard/master/prodi');
        }
        return redirect('/dashboard/master/matakuliah');
    }

    public function pengaturan()
    {
        if (auth()->user()->level != "admin") {
            return redirect('/dashboard');
        }
        $semester = Pengaturan::where('jenis', 'semester')->first()->nilai;
        $upload = Pengaturan::where('jenis', 'upload')->first()->nilai;
        return view('dashboard.pengaturan', ['semester' => $semester, 'upload' => $upload]);
    }

    public function simpanPengaturan(Request $req)
    {
        Pengaturan::where('jenis', 'semester')->update([
            'nilai'=> $req->semester,
        ]);
        Pengaturan::where('jenis', 'upload')->update([
            'nilai'=> $req->upload,
        ]);

        return redirect('/dashboard/pengaturan')->with('berhasil', 'Pengaturan berhasil disimpan');
    }

    public function hapusData($aksi)
    {
        if (auth()->user()->level != "admin") {
            return redirect('/dashboard');
        }
        if ($aksi == "data") {
            User::where('level', '!=', 'admin')->delete();
            Dosen::truncate();
            Biodata::truncate();
            Program::truncate();
            Slip::truncate();

            File::deleteDirectory(public_path('img/users/'));
            File::deleteDirectory(public_path('img/slip/'));

            return redirect('/dashboard/pengaturan')->with('berhasil', 'Semua data berhasil dihapus');
        } elseif ($aksi == "slip") {
            Slip::truncate();
            Program::truncate();
            File::deleteDirectory(public_path('img/slip/'));

            return redirect('/dashboard/pengaturan')->with('berhasil', 'Semua slip praktikum berhasil dihapus');
        }
        return redirect('/dashboard/pengaturan');
    }

    public function getMahasiswa(MahasiswaDataTable $datatable)
    {
        return $datatable->render('test');
    }
}
