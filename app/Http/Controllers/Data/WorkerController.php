<?php

namespace App\Http\Controllers\Data;

use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\WorkerDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\WorkerProof; // Tambahkan ini

class WorkerController extends Controller
{
    public function index(WorkerDataTable $dataTable)
    {
        return $dataTable->render('data.user.worker.index');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'Data gagal disimpan');
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
        $data->kategori_id = $request->kategori_id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            Storage::putFileAs('public/worker', $file, $fileName);
            $data->avatar = $fileName;
        }

        $data->save();
        $data->assignRole('worker');

        Session::flash('success', 'Worker berhasil disimpan');
        return redirect()->route('worker.index');
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('data.user.worker.create', compact('kategoris'));
    }

    public function show($id)
    {
        // Find the user by ID
        $user = User::findOrFail($id);

        // Return a view for displaying user details
        return view('data.user.worker.show', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telp' => 'required',
            'status' => 'required',
            'arrival_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'work_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'satisfaction_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        if ($validated->fails()) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput()
                ->with('warning', 'Data gagal diupdate');
        }

        $data = User::findOrFail($id);

        // Update data user
        $data->update([
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'status' => $request->status,
            'password' => $request->password ? bcrypt($request->password) : $data->password,
            'kategori_id' => $request->kategori_id,
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/user/' . $data->avatar);
            $fileimageName = date('dHis') . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/user', $fileimageName);
            $data->avatar = $fileimageName;
            $data->save();
        }

        // Hapus bukti lama dan upload yang baru
        $this->handleProofs($data, $request);

        Session::flash('success', 'Data berhasil diupdate');
        return redirect()->route('worker.index');
    }
    private function handleProofs(User $user, Request $request)
    {
        // Hapus semua bukti lama
        $user->proofs()->each(function ($proof) {
            Storage::delete('public/proofs/' . $proof->image_path);
            $proof->delete();
        });

        // Upload bukti baru
        $this->uploadProof($user, 'arrival', $request->file('arrival_proof'));
        $this->uploadProof($user, 'work', $request->file('work_proof'));
        $this->uploadProof($user, 'satisfaction', $request->file('satisfaction_proof'));
    }

    private function uploadProof(User $user, string $type, $file)
    {
        $filename = 'proof_' . $type . '_' . date('YmdHis') . '.' . $file->getClientOriginalExtension();

        $file->storeAs('public/proofs', $filename);

        WorkerProof::create([
            'user_id' => $user->id,
            'type' => $type,
            'image_path' => $filename
        ]);
    }

    public function destroy($id)
    {
        $data = User::findOrFail($id);

        // Hapus semua bukti
        $data->proofs()->each(function ($proof) {
            Storage::delete('public/proofs/' . $proof->image_path);
            $proof->delete();
        });

        $data->delete();
        return response()->json(['success' => 'hapus data berhasil']);
    }
}
