<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function createMitra()
    {
        return view('admin.create-mitra');
    }

    public function storeMitra(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'alamat' => 'required|string',
            'kode_pos' => 'required|string|max:10',
            'kelurahan' => 'required|string',
            'kecamatan' => 'required|string',
        ]);

        $mitra = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'kode_pos' => $request->kode_pos,
            'kelurahan' => $request->kelurahan,
            'kecamatan' => $request->kecamatan,
            'is_active' => false, // Mitra belum aktif
        ]);

        $mitra->assignRole('mitra');

        return redirect()->route('admin.dashboard')->with('success', 'Mitra berhasil ditambahkan. Mitra harus mengaktifkan akunnya.');
    }
}
