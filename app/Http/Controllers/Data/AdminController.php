<?php

namespace App\Http\Controllers\Data;

use App\DataTables\AdminDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function index(AdminDataTable $dataTable)
    {
        return $dataTable->render('data.user.admin.index');
    }

    public function create()
    {
        return view('data.user.admin.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($request->password);
        $data->no_telp = $request->no_telp;
        $data->alamat = $request->alamat;
        $data->status = $request->status;
        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/user',
                $fileimage,
                $fileimageName
            );

            $data->avatar = $fileimageName;
        }
        $data->save();
        $data->assignRole('superadmin');
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('admin.index');
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        return view('data.user.admin.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'status' => 'required',
        ]);

        $data = User::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->name = $request->name;
        $data->email = $request->email;
        if (!empty($request->password)) {
            $data->password = bcrypt($request->password);
        }
        $data->no_telp = $request->no_telp;
        $data->alamat = $request->alamat;
        $data->status = $request->status;
        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/user',
                $fileimage,
                $fileimageName
            );

            $data->avatar = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('data/admin');
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
