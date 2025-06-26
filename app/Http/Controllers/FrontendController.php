<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Kontak;
use App\Models\Slider;
use App\Models\Layanan;
use App\Models\Kategori;
use App\Models\Workshop;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use App\Models\WorkshopRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $slider_all = Slider::where('status', 1)->orderBy('queue')->get();
        $workshop_all = Workshop::where('status', 1)->latest()->limit(6)->get();
        return view('frontend.welcome', compact('slider_all', 'workshop_all'));
    }

    public function workshop(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string',
            'status' => 'nullable|in:1,2,3',
            'fee' => 'nullable|in:free,paid',

        ]);

        $search = $request->search;
        $status = $request->status;
        $fee = $request->fee;

        $query = Workshop::with([
            'registrations' => function ($q) {
                $q->where('user_id', auth()->id());
            }
        ]);

        // Filter berdasarkan pencarian
        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan status
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Filter fee
        if (!empty($fee)) {
            if ($fee === 'free') {
                $query->where('fee', 0);
            } elseif ($fee === 'paid') {
                $query->where('fee', '>', 0);
            }
        }

        // Ambil hasil
        try {
            $workshop_all = $query->latest()->paginate(15);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }

        // Tampilkan view dengan data
        return view('frontend.workshop', compact('workshop_all', 'search', 'status', 'fee'));
    }

    public function workshop_detail($id)
    {

        $data = Workshop::where('id', $id)->first();
        $banks = \App\Models\Bank::all();

        if (empty($data)) {
            return redirect()->back()->with('error', 'data not found');
        }
        $data_related = Workshop::where('status', 1)->where('id', '!=', $id)->inRandomOrder()->limit(4)->get();
        return view('frontend.workshop_detail', compact('data', 'data_related', 'banks'));
    }

    public function send_workshop_registration(Request $request)
    {
        if (!Auth::user()->hasVerifyEmail()) {
            return redirect()->back()->with('error', 'Silakan verifikasi email terlebih dahulu sebelum mendaftar workshop.');
        }

        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'workshop_id' => 'required|exists:workshops,id',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $layanan = Workshop::find($request->workshop_id);
        if (!$layanan) {
            return redirect()->back()->with('error', 'Workshop not found.');
        }

        $send = new WorkshopRegistration();
        $send->workshop_id = $request->workshop_id;
        $send->user_id = Auth::user()->id;
        $send->nominal = $layanan->harga_member + rand(100, 999);
        $send->time = $dateTime;
        $send->transfer_proof = $dateTime;
        $send->status_pembayaran = 1;
        $send->status_order = 1;
        $send->save();

        return redirect('data/workshop_registration/' . $send->id . '/success_order')->with('success', 'order berhasil di buat');
    }

    public function my_workshop(Request $request)
    {
        // Validasi input
        $request->validate([
            'search' => 'nullable|string',
            'status' => 'nullable|in:1,2,3',
            'fee' => 'nullable|in:free,paid',
        ]);

        $search = $request->search;
        $status = $request->status;
        $fee = $request->fee;

        $userId = auth()->id();

        // Query Registrasi user, relasi dengan workshop
        $query = WorkshopRegistration::with('workshop')
            ->where('user_id', $userId)
            ->whereHas('workshop', function ($q) use ($search, $status, $fee) {
                if (!empty($search)) {
                    $q->where('title', 'like', '%' . $search . '%');
                }

                if (!empty($status)) {
                    $q->where('status', $status);
                }

                if (!empty($fee)) {
                    if ($fee === 'free') {
                        $q->where('fee', 0);
                    } elseif ($fee === 'paid') {
                        $q->where('fee', '>', 0);
                    }
                }
            });

        try {
            $registrations = $query->latest()->paginate(12);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }

        return view('frontend.my_workshop', compact('registrations', 'search', 'status', 'fee'));
    }

    public function result(Request $request)
    {

        // Query untuk mengambil data registrasi dengan status=5
        $query = WorkshopRegistration::with([
            'workshop', // Relasi ke table workshops
            'scores',   // Relasi ke table scores
            'certificate' // Relasi ke table certificates
        ])
            ->where('user_id', auth()->id())
            ->where('status', 5);

        // Ambil hasil dengan pagination
        try {
            $registrations = $query->latest()->paginate(15);

            // Hitung rata-rata skor untuk setiap registrasi
            foreach ($registrations as $registration) {
                $totalScore = $registration->scores->sum('score');
                $countScores = $registration->scores->count();
                $registration->average_score = $countScores > 0 ? round($totalScore / $countScores, 2) : 0;
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data.');
        }

        // Tampilkan view dengan data
        return view('frontend.result', compact('registrations'));
    }

    public function downloadCertificate($registration_id)
    {
        $registration = WorkshopRegistration::with([
            'workshop',
            'certificate'
        ])->where('id', $registration_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$registration || !$registration->certificate) {
            return redirect()->back()->with('error', 'Certificate not found.');
        }

        return response()->download(storage_path('app/certificates/' . $registration->certificate->file_path));
    }

}
