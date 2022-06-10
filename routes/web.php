<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::post('/login/verify', [UserController::class, 'verifyLogin']);
Route::post('/register', [UserController::class, 'daftarAkun']);
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/password', [UserController::class, 'gantiPassword']);

Route::get('/', [PagesController::class, 'index']);
Route::get('/informasi', [PagesController::class, 'informasi']);
Route::get('/bantuan', [PagesController::class, 'bantuan']);

Route::get('/myaccount', [MyAccountController::class, 'index']);
Route::post('/myaccount/save', [MyAccountController::class, 'saveBio']);
Route::post('/myaccount/update', [MyAccountController::class, 'updateBio']);
Route::get('/myaccount/slip', [MyAccountController::class, 'slipPraktikum']);
Route::post('/myaccount/slip/tambah', [MyAccountController::class, 'tambahMatakuliah']);
Route::get('/myaccount/slip/{id}', [MyAccountController::class, 'uploadSlip']);
Route::post('/myaccount/slip/{id}/tambah', [MyAccountController::class, 'kirimSlip']);
Route::get('/myaccount/slip/{id}/{aksi}', [MyAccountController::class, 'aksiMatakuliah']);
Route::get('/myaccount/info_upload', [MyAccountController::class, 'info_upload']);
Route::get('/myaccount/pesan', [MyAccountController::class, 'pesan']);

Route::get('/o/dashboard', [OperatorController::class, 'index']);
Route::get('/o/dashboard/mahasiswa', [OperatorController::class, 'mahasiswa']);
Route::get('/o/dashboard/mahasiswa/{id}/{nim?}', [OperatorController::class, 'dataMahasiswa']);
Route::get('/o/dashboard/slip', [OperatorController::class, 'slip']);
Route::get('/o/dashboard/slip/{id}', [OperatorController::class, 'lihatSlip']);
Route::get('/o/dashboard/slip/{id}/print', [OperatorController::class, 'downloadSlipPDF']);
Route::get('/o/dashboard/slip/{id}/printexcel', [OperatorController::class, 'downloadSlipExcel']);
Route::get('/o/dashboard/bantuan', [OperatorController::class, 'bantuan']);

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa']);
Route::get('/dashboard/mahasiswa/{id}', [DashboardController::class, 'lihatMahasiswa']);
Route::post('/dashboard/mahasiswa/{id}/edit/simpan', [DashboardController::class, 'updateMahasiswa']);
Route::get('/dashboard/mahasiswa/{id}/{aksi}', [DashboardController::class, 'aksiMahasiswa']);
Route::get('/dashboard/dosen', [DashboardController::class, 'operator']);
Route::post('/dashboard/dosen/tambah', [DashboardController::class, 'tambahOperator']);
Route::get('/dashboard/dosen/{id1}/{id2}/hapus', [DashboardController::class, 'operatorHapusMatakuliah']);
Route::post('/dashboard/dosen/{id}/{aksi}', [DashboardController::class, 'simpanOperator']);
Route::get('/dashboard/dosen/{id?}/{aksi?}', [DashboardController::class, 'aksiOperator']);
Route::get('/dashboard/pembayaran', [DashboardController::class, 'slipPembayaran']);
Route::get('/dashboard/pembayaran/{id}', [DashboardController::class, 'slipPembayaranMatakuliah']);
Route::get('/dashboard/pembayaran/{id}/print', [DashboardController::class, 'downloadSlipPDF']);
Route::get('/dashboard/pembayaran/{id}/printexcel', [DashboardController::class, 'downloadSlipExcel']);
Route::get('/dashboard/master/{jenis?}', [DashboardController::class, 'masterData']);
Route::post('/dashboard/master/{jenis?}/tambah', [DashboardController::class, 'tambahMasterData']);
Route::get('/dashboard/master/{jenis?}/{id}/hapus', [DashboardController::class, 'hapusMasterData']);
Route::get('/dashboard/pengaturan', [DashboardController::class, 'pengaturan']);
Route::post('/dashboard/pengaturan/simpan', [DashboardController::class, 'simpanPengaturan']);
Route::get('/dashboard/pengaturan/hapus/{aksi}', [DashboardController::class, 'hapusData']);
