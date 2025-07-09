<?php

namespace App\Http\Controllers\Data;

use App\Models\Workshop;
use App\Models\User;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\WorkshopRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

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

    // === Payment Confirmation Flow ===
    public function successOrder($id)
    {
        $registration = WorkshopRegistration::with(['workshop', 'user'])->findOrFail($id);
        $banks = Bank::where('status', 1)->orderBy('no_urut')->get();

        return view('data.registration.success_order', compact('registration', 'banks'));
    }

    public function showConfirmationForm($id)
    {
        $registration = WorkshopRegistration::with(['workshop', 'user'])->findOrFail($id);
        $banks = Bank::where('status', 1)->orderBy('no_urut')->get();

        return view('data.registration.confirmation', compact('registration', 'banks'));
    }

    public function submitConfirmation(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'transfer_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_status' => 'required|in:pending,paid,failed',
            'g-recaptcha-response' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // reCAPTCHA validation
        $response = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'CAPTCHA verification failed.']);
        }

        $registration = WorkshopRegistration::findOrFail($id);

        if ($request->hasFile('transfer_proof')) {
            $file = $request->file('transfer_proof');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/transfer_proofs', $filename);
            $registration->transfer_proof = $filename;
        }

        $registration->payment_status = $request->payment_status;
        $registration->save();

        return redirect('/data/registration')->with('success', 'Payment confirmation submitted.');
    }

    public function approvePayment($id)
    {
        $registration = WorkshopRegistration::findOrFail($id);
        $registration->payment_status = 'paid';
        $registration->status = 'approved';
        $registration->save();

        return redirect('/data/registration')->with('success', 'Payment marked as approved.');
    }

    public function rejectPayment($id)
    {
        $registration = WorkshopRegistration::findOrFail($id);
        $registration->payment_status = 'failed';
        $registration->status = 'rejected';
        $registration->save();

        return redirect('/data/registration')->with('success', 'Payment marked as rejected.');
    }

    // === Participant View per Workshop ===
    public function viewParticipants(Workshop $workshop)
    {
        return view('data.participant.show', compact('workshop'));
    }

    public function getParticipantsData(Workshop $workshop)
    {
        $data = WorkshopRegistration::with('user')
            ->where('workshop_id', $workshop->id)
            ->latest();

        return DataTables::of($data)
            ->addColumn('name', fn ($row) => $row->user->name ?? '-')
            ->addColumn('email', fn ($row) => $row->user->email ?? '-')
            ->editColumn('created_at', fn ($row) => $row->created_at->format('d-m-Y H:i'))
            ->addColumn('action', fn ($row) => '<a href="/data/registration/' . $row->id . '" class="btn btn-primary btn-sm">Detail</a>')
            ->rawColumns(['action'])
            ->make(true);
    }
}
