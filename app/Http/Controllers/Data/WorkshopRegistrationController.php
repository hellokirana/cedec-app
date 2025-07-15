<?php

namespace App\Http\Controllers\Data;

use App\Models\Bank;
use App\Models\User;
use App\Models\Workshop;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\WorkshopRegistration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\DataTables\PaymentConfirmationDataTable;
use App\DataTables\WorkshopRegistrationDataTable;

class WorkshopRegistrationController extends Controller
{
    public function index()
    {
        $registrations = WorkshopRegistration::with(['user', 'workshop'])->latest()->paginate(15);
        return view('data.registration.index', compact('registrations'));
    }

    public function show($id)
    {
        $registration = WorkshopRegistration::with(['user', 'workshop'])->findOrFail($id);
        return view('data.registration.show', compact('registration'));
    }

    public function destroy($id)
    {
        $registration = WorkshopRegistration::findOrFail($id);
        $registration->delete();
        return response()->json(['success' => 'Registration deleted successfully.']);
    }

    public function showRegistrations($workshopId)
    {
        $workshop = Workshop::withCount('registrations')->findOrFail($workshopId);
        $dataTable = new WorkshopRegistrationDataTable($workshopId);

        return $dataTable->render('data.registration.index', compact('workshop'));
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
            'status' => 'required',
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
                Storage::disk('public_direct')->delete('transfer_proof/' . $registration->transfer_proof);
            }

            $file = $request->file('transfer_proof');
            $filename = date('YmdHis') . '_' . $file->getClientOriginalName();

            // Simpan ke public_html/storage/transfer_proof
            Storage::disk('public_direct')->putFileAs('transfer_proof', $file, $filename);

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
            Storage::disk('public_direct')->delete('transfer_proof/' . $registration->transfer_proof);
        }

        $registration->delete();

        return response()->json(['success' => 'Registration deleted successfully']);
    }

    public function paymentConfirmation(PaymentConfirmationDataTable $dataTable)
    {
        // Get payment statistics
        $stats = [
            'under_review' => WorkshopRegistration::whereHas('workshop', function ($query) {
                $query->where('fee', '>', 0);
            })->where('payment_status', 1)->count(),

            'completed' => WorkshopRegistration::whereHas('workshop', function ($query) {
                $query->where('fee', '>', 0);
            })->where('payment_status', 2)->count(),

            'rejected' => WorkshopRegistration::whereHas('workshop', function ($query) {
                $query->where('fee', '>', 0);
            })->where('payment_status', 3)->count(),

            'total' => WorkshopRegistration::whereHas('workshop', function ($query) {
                $query->where('fee', '>', 0);
            })->whereNotNull('transfer_proof')->count()
        ];

        return $dataTable->render('data.registration.payment-confirmation', compact('stats'));
    }

    public function confirm($id)
    {
        $data = WorkshopRegistration::findOrFail($id);
        $data->payment_status = 2;
        $data->status = 2;
        $data->save();

        return redirect()->back()->with('success', 'Payment has been confirmed');
    }

    public function reject($id)
    {
        $data = WorkshopRegistration::findOrFail($id);
        $data->payment_status = 3;
        $data->status = 1;
        $data->save();

        return redirect()->back()->with('success', 'Payment has been rejected');
    }


}
