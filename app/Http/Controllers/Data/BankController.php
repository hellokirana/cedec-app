<?php

namespace App\Http\Controllers\Data;

use App\DataTables\BankDataTable;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class BankController extends Controller
{
    public function index(BankDataTable $dataTable)
    {
        return $dataTable->render('data.bank.index');
    }

    public function create()
    {
        return view('data.bank.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'queue' => 'required',
            'name' => 'required',
            'status' => 'required',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new Bank();
        $data->queue = $request->queue;
        $data->name = $request->name;
        $data->bank_number = $request->bank_number;
        $data->bank = $request->bank;
        $data->status = $request->status;
        $data->save();
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('bank.index');
    }

    public function edit($id)
    {
        $data = Bank::findOrFail($id);
        return view('data.bank.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'queue' => 'required|integer',
            'name' => 'required|string',
            'status' => 'required',
        ]);

        $data = Bank::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->queue = $request->queue;
        $data->name = $request->name;
        $data->no_rekening = $request->bank_number;
        $data->bank = $request->bank;
        $data->status = $request->status;

        
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('data/bank');
    }

    public function destroy($id)
    {
        $data = Bank::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'delete data successfully']);
    }
}
