<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ManajemenAkunController extends Controller
{
    public function index()
    {
        $data = User::whereIn('role', ['asisten_kiper', 'karyawan'])->get();
        return view('pageadmin.manajemen_akun.index', compact('data'));
    }

    public function create()
    {
        return view('pageadmin.manajemen_akun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'nama' => 'required',
            'no_wa' => 'required',
            'alamat' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->no_wa = $request->no_wa;
        $user->role = $request->role;
        $user->alamat = $request->alamat;
        $user->password = Hash::make($request->password);
        $user->save();

        

        Alert::success('Success', 'Akun berhasil ditambahkan');
        return redirect()->route('manajemen-akun.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('pageadmin.manajemen_akun.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'nama' => 'required',
            'no_wa' => 'required',
            'alamat' => 'required',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = User::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->no_wa = $request->no_wa;
        $user->role = $request->role;
        $user->alamat = $request->alamat;

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        

        $user->save();

        Alert::success('Success', 'Akun berhasil diubah');
        return redirect()->route('manajemen-akun.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Alert::success('Success', 'Akun berhasil dihapus');
        return redirect()->route('manajemen-akun.index');
    }
}
