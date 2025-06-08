<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
class DashboardController extends Controller
{
 public function index(){
   $barang_masuk = BarangMasuk::sum('jumlah');
   $barang_keluar = BarangKeluar::sum('jumlah');
    return view('pageadmin.dashboard.index', compact('barang_masuk', 'barang_keluar'));
 }
}
