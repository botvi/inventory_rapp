<?php

namespace App\Http\Controllers\asisten;

use App\Models\BarangKeluar;
use App\Models\Supplier;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barang_keluars = BarangKeluar::with('user', 'barang')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pageasisten.barang_keluar.index', compact('barang_keluars'));
    }

    public function create()
    {
        $barangs = Barang::get();
        return view('pageasisten.barang_keluar.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'tanggal_keluar' => 'required|date',
                'jumlah' => 'required|integer|min:1',
                'tujuan' => 'required|string',  
            ], [
                'barang_id.required' => 'Barang harus dipilih',
                'tanggal_keluar.required' => 'Tanggal keluar harus diisi',
                'jumlah.required' => 'Jumlah harus diisi',
                'jumlah.min' => 'Jumlah minimal 1',
                'tujuan.required' => 'Tujuan harus diisi',
            ]);

            // Validasi stok barang
            $barang = Barang::findOrFail($request->barang_id);
            if ($barang->stok_barang < $request->jumlah) {
                throw new \Exception('Stok barang tidak mencukupi. Stok tersedia: ' . $barang->stok_barang);
            }

            // Buat data barang keluar
            $barang_keluar = BarangKeluar::create([
                'user_id' => Auth::user()->id,
                'barang_id' => $request->barang_id,
                'tanggal_keluar' => $request->tanggal_keluar,
                'jumlah' => $request->jumlah,
                'tujuan' => $request->tujuan,
                'yang_mengambil' => "Store Kiper",
            ]);

            // Update stok barang
            $barang = Barang::findOrFail($request->barang_id);
            $barang->stok_barang -= $request->jumlah;
            $barang->save();

            DB::commit();
            Alert::toast('Barang Keluar berhasil ditambahkan!', 'success')->position('top-end');
            return redirect()->route('barang-keluar.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::get();
        return view('pageasisten.barang_keluar.edit', compact('barangKeluar', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $barang_keluar = BarangKeluar::findOrFail($id);
            
            $request->validate([
                'barang_id' => 'required|exists:barangs,id',
                'tanggal_keluar' => 'required|date',
                'jumlah' => 'required|integer|min:1',
                'tujuan' => 'required|string',
            ], [
                'barang_id.required' => 'Barang harus dipilih',
                'tanggal_keluar.required' => 'Tanggal keluar harus diisi',
                'jumlah.required' => 'Jumlah harus diisi',
                'jumlah.min' => 'Jumlah minimal 1',
                'tujuan.required' => 'Tujuan harus diisi',
            ]);

            // Update stok barang
            $barang_lama = Barang::findOrFail($barang_keluar->barang_id);
            $barang_baru = Barang::findOrFail($request->barang_id);

            // Kembalikan stok barang lama dengan jumlah sebelum diedit
            $barang_lama->stok_barang += $barang_keluar->jumlah;
            $barang_lama->save();

            // Validasi stok barang baru
            if ($barang_baru->stok_barang < $request->jumlah) {
                throw new \Exception('Stok barang tidak mencukupi. Stok tersedia: ' . $barang_baru->stok_barang);
            }

            // Kurangi stok barang baru dengan jumlah yang baru
            $barang_baru->stok_barang -= $request->jumlah;
            $barang_baru->save();

            $barang_keluar->update([
                'user_id' => Auth::user()->id,
                'barang_id' => $request->barang_id,
                'tanggal_keluar' => $request->tanggal_keluar,
                'jumlah' => $request->jumlah,
                'tujuan' => $request->tujuan,
            ]);

            DB::commit();
            Alert::toast('Barang Keluar berhasil diperbarui!', 'success')->position('top-end');
            return redirect()->route('barang-keluar.index');
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
            
            $barang_keluar = BarangKeluar::findOrFail($id);
            
            // Update stok barang
            $barang = Barang::findOrFail($barang_keluar->barang_id);
            $barang->stok_barang += $barang_keluar->jumlah;
            $barang->save();
            
            $barang_keluar->delete();
            
            DB::commit();
            Alert::toast('Barang Keluar berhasil dihapus!', 'success')->position('top-end');
            return redirect()->route('barang-keluar.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error('Error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
