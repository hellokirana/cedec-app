<?php

namespace App\Http\Controllers\Data;

use App\DataTables\TestimoniDataTable;
use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class TestimoniController extends Controller
{
    public function index(TestimoniDataTable $dataTable)
    {
        return $dataTable->render('data.testimoni.index');
    }

    public function create()
    {
        return view('data.testimoni.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'no_urut' => 'required',
            'nama' => 'required',
            'status' => 'required',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new Testimoni();
        $data->no_urut = $request->no_urut;
        $data->nama = $request->nama;
        $data->rating = $request->rating;
        $data->konten = $request->konten;
        $data->status = $request->status;
        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/testimoni',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->save();
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('testimoni.index');
    }

    public function edit($id)
    {
        $data = Testimoni::findOrFail($id);
        return view('data.testimoni.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_urut' => 'required|integer',
            'nama' => 'required|string',
            'status' => 'required',
        ]);

        $data = Testimoni::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->no_urut = $request->no_urut;
        $data->nama = $request->nama;
        $data->rating = $request->rating;
        $data->konten = $request->konten;
        $data->status = $request->status;

        $fileimage       = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName   = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/testimoni',
                $fileimage,
                $fileimageName
            );

            $data->image = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('data/testimoni');
    }

    public function destroy($id)
    {
        $data = Testimoni::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
