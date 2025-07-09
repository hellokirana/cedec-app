<?php

namespace App\Http\Controllers\Data;

use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\DataTables\WorkshopDataTable;
use App\DataTables\WorkshopRegistrationDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WorkshopController extends Controller
{
    public function index(WorkshopDataTable $dataTable)
    {
        return $dataTable->render('data.workshop.index');
    }

    public function create()
    {
        return view('data.workshop.create');
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'workshop_start_date' => 'required|date',
            'workshop_end_date' => 'required|date|after_or_equal:workshop_start_date',
            'time' => 'nullable|string',
            'place' => 'nullable|string',
            'fee' => 'nullable|numeric',
            'quota' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'registration_start_date' => 'nullable|date',
            'registration_end_date' => 'nullable|date|after_or_equal:registration_start_date',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'Data gagal disimpan');
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = new Workshop();
        $data->fill($request->only([
            'title',
            'description',
            'workshop_start_date',
            'workshop_end_date',
            'time',
            'place',
            'fee',
            'quota',
            'status',
            'registration_start_date',
            'registration_end_date'
        ]));

        if ($request->hasFile('image')) {
            $fileimage = $request->file('image');
            $filename = date('YmdHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs('public/workshop', $fileimage, $filename);
            $data->image = $filename;
        }

        $data->save();

        Session::flash('success', 'Data berhasil disimpan');
        return redirect()->route('workshop.index');
    }

    public function edit($id)
    {
        $data = Workshop::findOrFail($id);
        return view('data.workshop.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'workshop_start_date' => 'required|date',
            'workshop_end_date' => 'required|date|after_or_equal:workshop_start_date',
            'time' => 'nullable|string',
            'place' => 'nullable|string',
            'fee' => 'nullable|numeric',
            'quota' => 'nullable|integer',
            'status' => 'required|in:0,1',
            'registration_start_date' => 'nullable|date',
            'registration_end_date' => 'nullable|date|after_or_equal:registration_start_date',
        ]);

        $data = Workshop::findOrFail($id);
        $data->fill($request->only([
            'title',
            'description',
            'workshop_start_date',
            'workshop_end_date',
            'time',
            'place',
            'fee',
            'quota',
            'status',
            'registration_start_date',
            'registration_end_date'
        ]));

        if ($request->hasFile('image')) {
            $fileimage = $request->file('image');
            $filename = date('YmdHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs('public/workshop', $fileimage, $filename);
            $data->image = $filename;
        }

        $data->save();

        Session::flash('success', 'Data updated successfully');
        return redirect()->route('workshop.index');
    }

    public function destroy($id)
    {
        $data = Workshop::findOrFail($id);
        $data->delete();
        return response()->json(['success' => 'delete data successfully']);
    }

    // Method untuk menampilkan workshop registrations
    public function showRegistrations($workshopId)
    {
        $workshop = Workshop::withCount('registrations')->findOrFail($workshopId);
        $dataTable = new WorkshopRegistrationDataTable($workshopId);

        return $dataTable->render('data.workshop.registration', compact('workshop'));
    }

    // Method untuk edit registration
    public function editRegistration($workshopId, $registrationId)
    {
        $workshop = Workshop::findOrFail($workshopId);
        $registration = WorkshopRegistration::with('user')->findOrFail($registrationId);

        return view('data.workshop.edit-registration', compact('workshop', 'registration'));
    }

    // Method untuk update registration
    public function updateRegistration(Request $request, $workshopId, $registrationId)
    {
        $validated = Validator::make($request->all(), [
            'time' => 'nullable|string',
            'payment_status' => 'required|in:pending,paid,unpaid',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validated->fails()) {
            Session::flash('warning', 'Data gagal diupdate');
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $registration = WorkshopRegistration::findOrFail($registrationId);
        $registration->fill($request->only([
            'time',
            'payment_status',
            'status'
        ]));

        // Handle transfer proof upload
        if ($request->hasFile('transfer_proof')) {
            // Delete old file if exists
            if ($registration->transfer_proof) {
                Storage::delete('public/transfer_proof/' . $registration->transfer_proof);
            }

            $file = $request->file('transfer_proof');
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();
            Storage::putFileAs('public/transfer_proof', $file, $filename);
            $registration->transfer_proof = $filename;
        }

        $registration->save();

        Session::flash('success', 'Data registration berhasil diupdate');
        return redirect()->route('workshop.registrations', $workshopId);
    }

    // Method untuk delete registration
    public function destroyRegistration($workshopId, $registrationId)
    {
        $registration = WorkshopRegistration::findOrFail($registrationId);

        // Delete transfer proof file if exists
        if ($registration->transfer_proof) {
            Storage::delete('public/transfer_proof/' . $registration->transfer_proof);
        }

        $registration->delete();

        return response()->json(['success' => 'Registration deleted successfully']);
    }
}