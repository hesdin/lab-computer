<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use File;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;

class UserController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function verifyLogin(Request $req)
    {
        $user = User::where('username', $req->username)->first();
        if ($user && $user->status == '0') {
            return redirect('/login')->with('error', 'Akun Anda belum aktif');
        }

        if (Auth::attempt(['username' => $req->username, 'password' => $req->password, 'status' => '1'])) {
            if (auth()->user()->level == "user") {
                Log::insert([
                    'log' => auth()->user()->nama.' login ke sistem',
                    'waktu' => now(),
                ]);
            }
            return redirect('/');
        }
        return redirect('/login')->with('error', 'Username atau Password Anda salah!');
    }

    public function daftarAkun(Request $req)
    {
        $nama = strtolower($req->nama);
        try {
            $foto = $req->file('foto');

            $user = new User();
            $user->nama = ucwords($nama);
            $user->username = $req->nim;
            $user->password = bcrypt($req->password);
            $user->level = 'user';
            $user->status = '0';
            $user->foto = 'foto'.'.'.$foto->getClientOriginalExtension();
            $user->save();

            $foto->move(public_path('img/users/'.$req->nim), 'foto'.'.'.$foto->getClientOriginalExtension());
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if($errorCode == '1062'){
                return redirect('/')->with('error', 'NIM sudah terdaftar');
            }
        }

        return redirect('/')->with('sukses', 'Berhasil Mendaftar');
    }

    public function gantiPassword(Request $req)
    {
        $data = User::where('id', auth()->user()->id)->first();
        if (Hash::check($req->oldPass, $data->password)) {
            if ($req->newPass != $req->conPass) {
                return redirect('/')->with('password', 'Konfirmasi Password Anda sesuai');
            }
            User::where('id', auth()->user()->id)->update([
                'password' => bcrypt($req->newPass)
            ]);
            Auth::logout();
            return redirect('/login');
        }
        return redirect('/')->with('password', 'Password Anda salah!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
