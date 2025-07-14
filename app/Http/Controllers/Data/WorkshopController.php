<?php

namespace App\Http\Controllers\Data;

use App\Models\Workshop;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\WorkshopRegistration;
use App\DataTables\WorkshopDataTable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PaymentConfirmationDataTable;
use App\DataTables\WorkshopRegistrationDataTable;

class WorkshopController extends Controller
{
    public function index(WorkshopDataTable $dataTable)
    {
        $this->updateWorkshopStatuses();
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
            'status' => 'required',
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
        $workshop = Workshop::findOrFail($id);
        return view('data.workshop.edit', compact('workshop'));
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

        return $dataTable->render('data.registration.index', compact('workshop'));
    }

    private function updateWorkshopStatuses()
    {
        $now = now();

        // UPCOMING
        Workshop::whereDate('registration_start_date', '>', $now)
            ->update(['status' => 4]);

        // REGISTRATION OPEN
        Workshop::whereDate('registration_start_date', '<=', $now)
            ->whereDate('registration_end_date', '>=', $now)
            ->update(['status' => 1]);

        // ONGOING
        Workshop::whereDate('workshop_start_date', '<=', $now)
            ->whereDate('workshop_end_date', '>=', $now)
            ->whereDate('registration_end_date', '<', $now)
            ->update(['status' => 2]);

        // COMPLETED
        Workshop::whereDate('workshop_end_date', '<', $now)
            ->update(['status' => 3]);
    }

}