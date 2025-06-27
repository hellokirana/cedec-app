<?php

namespace App\Http\Controllers\Data;

use App\DataTables\StudentDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Tampilkan daftar student dengan datatable.
     */
    public function index(StudentDataTable $dataTable)
    {
        return $dataTable->render('data.user.student.index');
    }

    /**
     * Tampilkan detail student.
     */
    public function show($id)
    {
        $this->middleware('verified');

        try {
            $data = User::role('student')->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        return view('data.user.student.show', compact('data'));
    }

    /**
     * Simpan student baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email:rfc,dns|unique:users',
            'name' => 'required|string|max:255',
            'npm' => 'required|unique:users',
            'program_id' => 'required|exists:programs,id',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'npm' => $request->npm,
            'program_id' => $request->program_id,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('student');
        $user->sendEmailVerificationNotification();

        return redirect()->route('students.index')->with('success', 'Student berhasil ditambahkan');
    }

    /**
     * Hapus student.
     */
    public function destroy($id)
    {
        $data = User::role('student')->where('id', $id)->first();

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data->delete();

        return response()->json(['success' => 'Hapus data berhasil']);
    }
}
