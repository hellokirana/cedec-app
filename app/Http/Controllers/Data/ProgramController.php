<?php

namespace App\Http\Controllers\Data;

use App\DataTables\ProgramDataTable;
use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{
    public function index(ProgramDataTable $dataTable)
    {
        return $dataTable->render('data.program.index');
    }

    public function create()
    {
        return view('data.program.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string',
            'status' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'Data gagal disimpan');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $program = new Program();
        $program->title = $request->title;
        $program->status = $request->status;
        $program->save();

        Session::flash('success', 'Data berhasil disimpan');
        return redirect()->route('program.index');
    }

    public function edit($id)
    {
        $data = Program::findOrFail($id);
        return view('data.program.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string',
            'status' => 'required|boolean',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'Data gagal diperbarui');
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $program = Program::findOrFail($id);
        $program->title = $request->title;
        $program->status = $request->status;
        $program->save();

        Session::flash('success', 'Data berhasil diperbarui');
        return redirect()->route('program.index');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return response()->json(['success' => 'Delete data successfully']);
    }
}
