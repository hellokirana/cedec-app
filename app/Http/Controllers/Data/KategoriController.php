<?php

namespace App\Http\Controllers\Data;

use App\DataTables\KategoriDataTable;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('data.kategori.index');
    }

    public function create()
    {
        return view('data.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'no_urut' => 'required',
            'title' => 'required',
            'status' => 'required',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new Kategori();
        $data->no_urut = $request->no_urut;
        $data->title = $request->title;
        $data->status = $request->status;
        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/kategori',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->save();
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('kategori.index');
    }

    public function edit($id)
    {
        $data = Kategori::findOrFail($id);
        return view('data.kategori.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_urut' => 'required|integer',
            'title' => 'required|string',
            'status' => 'required',
        ]);

        $data = Kategori::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->no_urut = $request->no_urut;
        $data->title = $request->title;
        $data->status = $request->status;

        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/kategori',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('data/kategori');
    }

    public function destroy($id)
    {
        $data = Kategori::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
