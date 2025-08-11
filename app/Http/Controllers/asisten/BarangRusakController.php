<?php

namespace App\Http\Controllers\asisten;

use App\Models\BarangRusak;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangRusakController extends Controller
{
    public function index()
    {
        $barang_rusaks = BarangRusak::with('user', 'barang')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pageasisten.barang_rusak.index', compact('barang_rusaks'));
    }

    public function create()
    {
        $barangs = BarangMasuk::where('jumlah', '>', 0)->get();
        return view('pageasisten.barang_rusak.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'jumlah_rusak' => 'required|integer|min:1',
                'keterangan' => 'required|string',  
            ], [
                'barang_id.required' => 'Barang harus dipilih',
                'jumlah_rusak.required' => 'Jumlah rusak harus diisi',
                'jumlah_rusak.min' => 'Jumlah rusak minimal 1',
                'keterangan.required' => 'Keterangan harus diisi',
            ]);

            // Validasi stok barang
            $barang = BarangMasuk::findOrFail($request->barang_id);
            if ($barang->jumlah < $request->jumlah_rusak) {
                throw new \Exception('Stok barang tidak mencukupi. Stok tersedia: ' . $barang->jumlah);
            }

            // Buat data barang rusak
            $barang_rusak = BarangRusak::create([
                'user_id' => Auth::user()->id,
                'barang_id' => $request->barang_id,
                'jumlah_rusak' => $request->jumlah_rusak,
                'keterangan' => $request->keterangan,
            ]);

            // Update stok barang
            $barang->jumlah -= $request->jumlah_rusak;
            $barang->save();

            DB::commit();
            Alert::toast('Barang Rusak berhasil ditambahkan!', 'success')->position('top-end');
            return redirect()->route('barang-rusak.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $barangRusak = BarangRusak::findOrFail($id);
        $barangs = BarangMasuk::where('jumlah', '>', 0)->get();
        return view('pageasisten.barang_rusak.edit', compact('barangRusak', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $barang_rusak = BarangRusak::findOrFail($id);
            
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'jumlah_rusak' => 'required|integer|min:1',
                'keterangan' => 'required|string',
            ], [
                'barang_id.required' => 'Barang harus dipilih',
                'jumlah_rusak.required' => 'Jumlah rusak harus diisi',
                'jumlah_rusak.min' => 'Jumlah rusak minimal 1',
                'keterangan.required' => 'Keterangan harus diisi',
            ]);

            // Update stok barang
            $barang_lama = BarangMasuk::findOrFail($barang_rusak->barang_id);
            $barang_baru = BarangMasuk::findOrFail($request->barang_id);

            // Kembalikan stok barang lama dengan jumlah sebelum diedit
            $barang_lama->jumlah += $barang_rusak->jumlah_rusak;
            $barang_lama->save();

            // Validasi stok barang baru
            if ($barang_baru->jumlah < $request->jumlah_rusak) {
                throw new \Exception('Stok barang tidak mencukupi. Stok tersedia: ' . $barang_baru->jumlah);
            }

            // Kurangi stok barang baru dengan jumlah yang baru
            $barang_baru->jumlah -= $request->jumlah_rusak;
            $barang_baru->save();

            $barang_rusak->update([
                'user_id' => Auth::user()->id,
                'barang_id' => $request->barang_id,
                'jumlah_rusak' => $request->jumlah_rusak,
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();
            Alert::toast('Barang Rusak berhasil diperbarui!', 'success')->position('top-end');
            return redirect()->route('barang-rusak.index');
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
            
            $barang_rusak = BarangRusak::findOrFail($id);
            
            // Update stok barang
            $barang = BarangMasuk::findOrFail($barang_rusak->barang_id);
            $barang->jumlah += $barang_rusak->jumlah_rusak;
            $barang->save();
            
            $barang_rusak->delete();
            
            DB::commit();
            Alert::toast('Barang Rusak berhasil dihapus!', 'success')->position('top-end');
            return redirect()->route('barang-rusak.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
