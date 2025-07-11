<?php
namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $workshops = Workshop::orderBy('title')->get();
        $selectedWorkshop = $request->get('workshop_id');
        $registrations = [];

        if ($selectedWorkshop) {
            $registrations = WorkshopRegistration::with(['user', 'certificate'])
                ->where('workshop_id', $selectedWorkshop)
                ->where('payment_status', 2)
                ->whereIn('status', [2, 4])
                ->get();
        }

        return view('data.certificate.index', compact('workshops', 'registrations', 'selectedWorkshop'));
    }

    public function upload(Request $request, $registrationId)
    {
        $request->validate([
            'certificate' => 'required|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $registration = WorkshopRegistration::findOrFail($registrationId);

        $filename = time() . '_' . $registration->user->name . '.' . $request->certificate->getClientOriginalExtension();
        $path = $request->file('certificate')->storeAs('certificates', $filename, 'public');

        // update or create certificate
        Certificate::updateOrCreate(
            ['registration_id' => $registration->id],
            [
                'user_id' => $registration->user_id,
                'certificate' => $filename
            ]
        );

        // update registration status to Completed (4)
        $registration->update(['status' => 4]);

        return back()->with('success', 'Certificate uploaded successfully.');
    }


    public function edit($registrationId)
    {
        $registration = WorkshopRegistration::with('user', 'certificate')->findOrFail($registrationId);

        // Validasi hanya yang boleh mendapat sertifikat
        if ($registration->payment_status != 2 || !in_array($registration->status, [2, 4])) {
            abort(403, 'Unauthorized to access this certificate.');
        }
        return view('data.certificate.edit', compact('registration'));
    }

    public function update(Request $request, $registrationId)
    {
        $request->validate([
            'certificate' => 'required|file|mimes:pdf|max:2048',
        ]);

        $registration = WorkshopRegistration::with('certificate')->findOrFail($registrationId);

        if ($registration->payment_status != 2 || !in_array($registration->status, [2, 4])) {
            return redirect()->back()->with('error', 'Only approved & paid participants can be updated.');
        }
        $file = $request->file('certificate');
        $fileName = time() . '_' . $registration->user_id . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/certificates', $fileName);

        $certificate = Certificate::firstOrNew(['registration_id' => $registration->id]);
        $certificate->user_id = $registration->user_id;
        $certificate->certificate = $fileName;
        $certificate->save();

        // update status to Completed (4)
        $registration->update(['status' => 4]);

        return redirect()->route('certificate.index', ['workshop_id' => $registration->workshop_id])
            ->with('success', 'Certificate updated successfully.');
    }

}
