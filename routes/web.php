<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    DashboardController,
    LoginController,
    ProfilController,
    LaporanController,
};

use App\Http\Controllers\admin\{
    ManajemenAkunController,
    SupplierController,
    BarangController,
};


use App\Http\Controllers\asisten\{
    BarangMasukController,
    BarangKeluarController,
};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/run-admin', function () {
    Artisan::call('db:seed', [
        '--class' => 'SuperAdminSeeder'
    ]);

    return "AdminSeeder has been create successfully!";
});
Route::get('/', [LoginController::class, 'showLoginForm'])->name('formlogin');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('manajemen-akun', ManajemenAkunController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('barang', BarangController::class);
});

Route::group(['middleware' => ['role:asisten_kiper']], function () {
    Route::resource('barang-masuk', BarangMasukController::class);
    Route::resource('barang-keluar', BarangKeluarController::class);
});

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/laporan/barang-masuk', [LaporanController::class, 'laporanbarangmasuk'])->name('laporan.barang-masuk');
Route::get('/laporan/barang-keluar', [LaporanController::class, 'laporanbarangkeluar'])->name('laporan.barang-keluar');






