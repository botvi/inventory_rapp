<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Supplier;
use App\Models\User;
use App\Models\BarangTersedia;
use App\Models\BarangRusak;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function laporanbarangmasuk()
    {
        $asisten_kiper = User::where('role', 'asisten_kiper')->first();
        $barang_masuk = BarangMasuk::with('user', 'supplier', 'barang')
            ->get();
        return view('laporan.laporanbarangmasuk', compact('barang_masuk', 'asisten_kiper'));
    }

    public function laporanbarangkeluar() 
    {
        try {
            $asisten_kiper = User::where('role', 'asisten_kiper')->first();
            $barang_keluars = BarangKeluar::with('user', 'barang')
                ->get();
            return view('laporan.laporanbarangkeluar', compact('barang_keluars', 'asisten_kiper'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal mengambil data barang keluar: ' . $e->getMessage());
            return redirect()->back();
        };
    }

    public function laporanbarangrusak()
    {
        $asisten_kiper = User::where('role', 'asisten_kiper')->first();
        $barang_rusaks = BarangRusak::with('user', 'barang')
            ->get();
        return view('laporan.laporanbarangrusak', compact('barang_rusaks', 'asisten_kiper'));
    }
}
