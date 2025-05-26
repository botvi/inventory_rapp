<?php

namespace App\Http\Controllers\asisten;

use App\Models\BarangMasuk;
use App\Models\Supplier;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barang_masuks = BarangMasuk::with('user', 'supplier', 'barang')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pageasisten.barang_masuk.index', compact('barang_masuks'));
    }

    public function create()
    {
        $suppliers = Supplier::get();
        $barangs = Barang::get();
        return view('pageasisten.barang_masuk.create', compact('suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'barang_id' => 'required|exists:barangs,id',
                'tanggal_masuk' => 'required|date',
                'jumlah' => 'required|integer|min:1',
            ], [
                'supplier_id.required' => 'Supplier harus dipilih',
                'barang_id.required' => 'Barang harus dipilih',
                'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
                'jumlah.required' => 'Jumlah harus diisi',
                'jumlah.min' => 'Jumlah minimal 1',
            ]);

       

            // Buat data barang masuk
            $barang_masuk = BarangMasuk::create([
                'user_id' => Auth::user()->id,
                'supplier_id' => $request->supplier_id,
                'barang_id' => $request->barang_id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'jumlah' => $request->jumlah,
            ]);

            // Update stok barang
            $barang = Barang::findOrFail($request->barang_id);
            $barang->stok_barang += $request->jumlah;
            $barang->save();

            DB::commit();
            Alert::toast('Barang Masuk berhasil ditambahkan!', 'success')->position('top-end');
            return redirect()->route('barang-masuk.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $suppliers = Supplier::get();
        $barangs = Barang::get();
        return view('pageasisten.barang_masuk.edit', compact('barangMasuk', 'suppliers', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $barang_masuk = BarangMasuk::findOrFail($id);
            
            $request->validate([
                'supplier_id' => 'required|exists:suppliers,id',
                'barang_id' => 'required|exists:barangs,id',
                'tanggal_masuk' => 'required|date',
                'jumlah' => 'required|integer|min:1',
            ], [
                'supplier_id.required' => 'Supplier harus dipilih',
                'barang_id.required' => 'Barang harus dipilih',
                'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
                'jumlah.required' => 'Jumlah harus diisi',
                'jumlah.min' => 'Jumlah minimal 1',
            ]);

          

            // Update stok barang
            $barang = Barang::findOrFail($barang_masuk->barang_id);
            $barang->stok_barang -= $barang_masuk->jumlah; // Kurangi stok lama
            $barang->stok_barang += $request->jumlah; // Tambah stok baru
            $barang->save();

            $barang_masuk->update([
                'user_id' => Auth::user()->id,
                'supplier_id' => $request->supplier_id,
                'barang_id' => $request->barang_id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();
            Alert::toast('Barang Masuk berhasil diperbarui!', 'success')->position('top-end');
            return redirect()->route('barang-masuk.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $barang_masuk = BarangMasuk::findOrFail($id);
            
            // Update stok barang
            $barang = Barang::findOrFail($barang_masuk->barang_id);
            $barang->stok_barang -= $barang_masuk->jumlah;
            $barang->save();
            
            $barang_masuk->delete();
            
            DB::commit();
            Alert::toast('Barang Masuk berhasil dihapus!', 'success')->position('top-end');
            return redirect()->route('barang-masuk.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
