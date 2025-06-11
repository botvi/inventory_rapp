<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class DashboardController extends Controller
{
  public function index()
  {
    $barang = Barang::select('nama_barang', 'stok_barang')->get();
    $labels = $barang->pluck('nama_barang');
    $stok = $barang->pluck('stok_barang');
    
    return view('pageadmin.dashboard.index', compact('barang', 'labels', 'stok'));
  }
}
