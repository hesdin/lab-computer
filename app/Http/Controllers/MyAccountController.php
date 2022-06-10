<?php

namespace App\Http\Controllers;

use File;

use Illuminate\Http\Request;
use App\Models\Biodata;
use App\Models\MataKuliah;
use App\Models\Pengaturan;
use App\Models\Program;
use App\Models\Slip;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'mahasiswa']);
    }

    public function index()
    {
        $data = Biodata::where('id_mahasiswa', auth()->user()->id)->first();
        if ($data) {
            $found = true;
            $bio = Biodata::where('id_mahasiswa', auth()->user()->id)->join('users', 'id_mahasiswa', 'users.id')->select('nama', 'username', 'fakultas', 'id_prodi', 'no_hp', 'bio')->first();
        } else {
            $found = false;
        }
        if ($found) {
            return view('pages.akunSaya', ['found' => $found, 'data' => $data, 'bio' => $bio]);
        } else {
            return view('pages.akunSaya', ['found' => $found, 'data' => $data]);
        }
    }

    public function saveBio(Request $req)
    {
        if (Biodata::where('id_mahasiswa', auth()->user()->id)->get()->count() > 0) {
            return redirect('/myaccount');
        }
        $req->validate([
            'fakultas' => 'required',
            'prodi' => 'required',
            'hp' => 'required',
        ]);

        if (strpos($req->hp, '-') !== false) {
            $req->hp = str_replace("-", "", $req->hp);
        }

        if (substr($req->hp, 0, 1) == "0") {
            $no_hp = substr($req->hp, 1);
        } elseif (substr($req->hp, 0, 2) == "62") {
            $no_hp = substr($req->hp, 2);
        } elseif (substr($req->hp, 0, 1) == "+62") {
            $no_hp = substr($req->hp, 3);
        } else {
            $no_hp = $req->hp;
        }
        $bio = [
            'id_mahasiswa' => auth()->user()->id,
            'fakultas' => $req->fakultas,
            'id_prodi' => $req->prodi,
            'no_hp' => '+62'.$no_hp,
            'bio' => ucfirst($req->bio)
        ];
        Biodata::insertOrIgnore($bio);

        return redirect('/myaccount')->with('saved', 'Data berhasil disimpan');
    }

    public function updateBio(Request $req)
    {
        $req->validate([
            'fakultas' => 'required',
            'prodi' => 'required',
            'hp' => 'required',
        ]);

        if (strpos($req->hp, '-') !== false) {
            $req->hp = str_replace("-", "", $req->hp);
        }

        if (substr($req->hp, 0, 1) == "0") {
            $no_hp = substr($req->hp, 1);
        } elseif (substr($req->hp, 0, 2) == "62") {
            $no_hp = substr($req->hp, 2);
        } elseif (substr($req->hp, 0, 1) == "+62") {
            $no_hp = substr($req->hp, 3);
        } else {
            $no_hp = $req->hp;
        }
        Biodata::where('id_mahasiswa', auth()->user()->id)->update([
            'fakultas' => $req->fakultas,
            'id_prodi' => $req->prodi,
            'no_hp' => '+62'.$no_hp,
            'bio' => ucfirst($req->bio),
        ]);

        return redirect('/myaccount')->with('updated', 'Data berhasil diperbaharui');
    }

    public function slipPraktikum()
    {
        $hakUpload = Pengaturan::where('jenis', 'upload')->first()->nilai;
        if ($hakUpload == "tutup") {
            return redirect('/myaccount')->with('tertutup', 'Upload slip sudah tertutup atau belum terbuka');
        }
        $data = Biodata::where('id_mahasiswa', auth()->user()->id)->first();
        if ($data) {
            $found = true;
            $bio = Biodata::where('id_mahasiswa', auth()->user()->id)->join('users', 'id_mahasiswa', 'users.id')->select('nama', 'username', 'fakultas', 'id_prodi', 'no_hp', 'bio')->first();
        } else {
            $found = false;
        }
        $semester = Pengaturan::where('jenis', 'semester')->first()->nilai;
        $matakuliah = MataKuliah::where('jenis', $semester)->orderBy('matakuliah')->get();
        $program = Program::where('id_mahasiswa', auth()->user()->id)
        ->join('matakuliah', 'id_matakuliah', 'matakuliah.id')
        ->select('program.id', 'program.id_matakuliah','matakuliah', 'semester')->orderBy('matakuliah')->get();
        // dd($program);
        if ($found) {
            return view('pages.matakuliah', [
                'found' => $found,
                'data' => $data,
                'bio' => $bio,
                'daftarMatakuliah' => $matakuliah,
                'daftarProgram' => $program,
                ]);
        } else {
            return redirect('/myaccount');
        }
    }

    public function tambahMatakuliah(Request $req)
    {
        $hakUpload = Pengaturan::where('jenis', 'upload')->first()->nilai;
        if ($hakUpload == "tutup") {
            return redirect('/myaccount')->with('tertutup', 'Upload slip sudah tertutup atau belum terbuka');
        }
        $program = [
            'id_matakuliah' => $req->matakuliah,
            'id_mahasiswa' => auth()->user()->id
        ];
        Program::insertOrIgnore($program);

        return redirect('/myaccount/slip');
    }

    public function uploadSlip($id)
    {
        $hakUpload = Pengaturan::where('jenis', 'upload')->first()->nilai;
        if ($hakUpload == "tutup") {
            return redirect('/myaccount')->with('tertutup', 'Upload slip sudah tertutup atau belum terbuka');
        }
        $data = Biodata::where('id_mahasiswa', auth()->user()->id)->first();
        if ($data) {
            $found = true;
            $bio = Biodata::where('id_mahasiswa', auth()->user()->id)->join('users', 'id_mahasiswa', 'users.id')->select('nama', 'username', 'fakultas', 'id_prodi', 'no_hp', 'bio')->first();
        } else {
            $found = false;
        }
        $matakuliah = Program::where('program.id', $id)->where('program.id_mahasiswa', auth()->user()->id)->join('matakuliah', 'id_matakuliah', 'matakuliah.id')->select('program.id', 'program.id_matakuliah','matakuliah.matakuliah')->first();

        if (empty($matakuliah)) {
            return redirect('/myaccount/slip');
        }

        $slip = Slip::where('id_matakuliah', $matakuliah->id_matakuliah)->where('id_mahasiswa', auth()->user()->id)->first();
        if ($slip) {
            return redirect('/myaccount/slip');
        }

        if ($found) {
            return view('pages.uploadSlip', ['found' => $found, 'data' => $data, 'bio' => $bio, 'matakuliah' => $matakuliah]);
        } else {
            return redirect('/myaccount');
        }
    }

    public function kirimSlip(Request $req, $id)
    {
        $hakUpload = Pengaturan::where('jenis', 'upload')->first()->nilai;
        if ($hakUpload == "tutup") {
            return redirect('/myaccount')->with('tertutup', 'Upload slip sudah tertutup atau belum terbuka');
        }
        $checkSlip = Slip::where('id_matakuliah', $id)->where('id_mahasiswa', auth()->user()->id)->get()->count();
        if ($checkSlip) {
            return redirect('/myaccount/slip');
        }

        $data = Program::where('id', $id)->where('id_mahasiswa', auth()->user()->id)->first();
        $matakuliah = MataKuliah::where('id', $data->id_matakuliah)->first();
        // dd($matakuliah);
        $foto = $req->file('upload');
        $foto->move(public_path('img/slip/'.$matakuliah->matakuliah.'/'.auth()->user()->username), auth()->user()->username.'.'.$foto->getClientOriginalExtension());

        $slip = [
            'id_mahasiswa' => auth()->user()->id,
            'id_matakuliah' => $data->id_matakuliah,
            'slip' => auth()->user()->username.'.'.$foto->getClientOriginalExtension(),
            'nominal' => $req->pembayaran,
            'tanggal_bayar' => $req->tanggal
        ];
        Slip::insertOrIgnore($slip);

        return redirect('/myaccount/slip');
    }

    public function aksiMatakuliah($id, $aksi)
    {
        $hakUpload = Pengaturan::where('jenis', 'upload')->first()->nilai;
        if ($hakUpload == "tutup") {
            return redirect('/myaccount')->with('tertutup', 'Upload slip sudah tertutup atau belum terbuka');
        }
        if ($aksi == "hapus") {
            Program::where('id', $id)->delete();
            return redirect('/myaccount/slip');
        } elseif ($aksi == "batal") {
            $slip = Slip::where('id', $id)->first();
            $matakuliah = MataKuliah::where('id', $slip->id_matakuliah)->first();
            File::deleteDirectory(public_path('img/slip/'.$matakuliah->matakuliah.'/'.auth()->user()->username));
            Slip::where('id', $id)->delete();
            return redirect('/myaccount/slip');
        }
        return redirect('/myaccount/slip');
    }

    public function pesan()
    {
        $data = Biodata::where('id_mahasiswa', auth()->user()->id)->first();
        if ($data) {
            $found = true;
            $bio = Biodata::where('id_mahasiswa', auth()->user()->id)->join('users', 'id_mahasiswa', 'users.id')->select('nama', 'username', 'fakultas', 'id_prodi', 'no_hp', 'bio')->first();
        } else {
            $found = false;
        }
        if ($found) {
            return view('pages.pesan', ['found' => $found, 'data' => $data, 'bio' => $bio]);
        } else {
            return view('pages.pesan', ['found' => $found, 'data' => $data]);
        }
    }
    
    // Info tentang upload
    public function info_upload()
    {
        $data = Biodata::where('id_mahasiswa', auth()->user()->id)->first();
        if ($data) {
            $found = true;
            $bio = Biodata::where('id_mahasiswa', auth()->user()->id)->join('users', 'id_mahasiswa', 'users.id')->select('nama', 'username', 'fakultas', 'id_prodi', 'no_hp', 'bio')->first();
        } else {
            $found = false;
        }
        if ($found) {
            return view('pages.info_upload', ['found' => $found, 'data' => $data, 'bio' => $bio]);
        } else {
            return view('pages.info_upload', ['found' => $found, 'data' => $data]);
        }
    }
}
