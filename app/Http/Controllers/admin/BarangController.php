<?php

namespace App\Http\Controllers\admin;

use App\Models\Barang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        try {
            $barangs = Barang::all();
            return view('pageadmin.barang.index', compact('barangs'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat mengambil data barang');
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('pageadmin.barang.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang',
                'nama_barang' => 'required|string|max:255',
                'stok_barang' => 'required|integer|min:0',
                'gambar_barang' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $gambar_barang = $request->file('gambar_barang');
            $nama_file = time() . '_' . $gambar_barang->getClientOriginalName();
            $gambar_barang->move(public_path('gambar_barang'), $nama_file);

            $barang = new Barang();
            $barang->kode_barang = $request->kode_barang;
            $barang->nama_barang = $request->nama_barang;
            $barang->stok_barang = $request->stok_barang;
            $barang->gambar_barang = $nama_file;
            $barang->save();

            Alert::success('Berhasil', 'Data barang berhasil disimpan');
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menyimpan data barang');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            return view('pageadmin.barang.edit', compact('barang'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Data barang tidak ditemukan');
            return redirect()->route('barang.index');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $barang = Barang::findOrFail($id);
            
            $request->validate([
                'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang,' . $id,
                'nama_barang' => 'required|string|max:255',
                'stok_barang' => 'required|integer|min:0',
                'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('gambar_barang')) {
                // Hapus gambar lama
                if ($barang->gambar_barang && file_exists(public_path('gambar_barang/' . $barang->gambar_barang))) {
                    unlink(public_path('gambar_barang/' . $barang->gambar_barang));
                }

                $gambar_barang = $request->file('gambar_barang');
                $nama_file = time() . '_' . $gambar_barang->getClientOriginalName();
                $gambar_barang->move(public_path('gambar_barang'), $nama_file);
                $barang->gambar_barang = $nama_file;
            }

            $barang->kode_barang = $request->kode_barang;
            $barang->nama_barang = $request->nama_barang;
            $barang->stok_barang = $request->stok_barang;
            $barang->save();

            Alert::success('Berhasil', 'Data barang berhasil diubah');
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat mengubah data barang');
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $barang = Barang::findOrFail($id);
            
            // Hapus gambar
            if ($barang->gambar_barang && file_exists(public_path('gambar_barang/' . $barang->gambar_barang))) {
                unlink(public_path('gambar_barang/' . $barang->gambar_barang));
            }
            
            $barang->delete();

            Alert::success('Berhasil', 'Data barang berhasil dihapus');
            return redirect()->route('barang.index');
        } catch (\Exception $e) {
            Alert::error('Error', 'Terjadi kesalahan saat menghapus data barang');
            return redirect()->back();
        }
    }
}

