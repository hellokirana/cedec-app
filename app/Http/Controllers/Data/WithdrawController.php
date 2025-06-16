<?php

namespace App\Http\Controllers\Data;

use App\DataTables\WithdrawDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\DataTables;

class WithdrawController extends Controller
{
    public function index(WithdrawDataTable $dataTable)
    {
        return $dataTable->render('data.withdraw.index');
    }


    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'nominal' => 'required',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'data gagal di simpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $data = new Withdraw();
        $data->worker_id = Auth::user()->id;
        $data->nominal = $request->nominal;
        $data->bank = $request->bank;
        $data->nama = $request->nama;
        $data->no_rekening = $request->no_rekening;
        $data->status = 1;
        $data->save();
        Session::flash('success', 'data berhasil di simpan');
        return redirect()->route('withdraw.index');
    }

    public function diproses($id)
    {
        $data = Withdraw::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status = 2;
        $data->update();
        return redirect()->back()->with('success', 'berhasil proses data');

    }

    public function selesai($id)
    {
        $data = Withdraw::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status = 3;
        $data->update();

        $user = User::where('id',$data->worker_id)->first();
        $user->wallet = $user->wallet - $data->nominal;
        $user->update();

        $wallet = new UserWallet();
        $wallet->user_id = $data->worker_id;
        $wallet->type = 1;
        $wallet->nominal = $data->nominal;
        $wallet->save();

        return redirect()->back()->with('success', 'berhasil proses data');

    }

    public function tolak($id)
    {
        $data = Withdraw::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->status = 4;
        $data->update();
        return redirect()->back()->with('success', 'berhasil proses data');

    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'no_urut' => 'required|integer',
            'nama' => 'required|string',
            'status' => 'required',
        ]);

        $data = Withdraw::where('id', $id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->no_urut = $request->no_urut;
        $data->nama = $request->nama;
        $data->no_rekening = $request->no_rekening;
        $data->withdraw = $request->withdraw;
        $data->status = $request->status;


        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('data/withdraw');
    }

    public function destroy($id)
    {
        $data = Withdraw::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
