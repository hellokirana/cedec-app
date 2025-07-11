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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\WorkshopRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
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
        $request->validate([
            'workshop_id' => 'required|exists:workshops,id',
            'transfer_proof' => ($request->has('workshop_id') && Workshop::find($request->workshop_id)?->fee > 0)
                ? 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                : 'nullable',
        ]);

        $workshop = Workshop::findOrFail($request->workshop_id);
        $user = Auth::user();

        // 🔒 Pastikan status workshop masih terbuka (status = 1)
        if ($workshop->status != 1) {
            return back()->with('error', 'Registration is closed for this workshop.');
        }

        // 🔄 Cek apakah user sudah pernah mendaftar
        $existing = WorkshopRegistration::where('user_id', $user->id)
            ->where('workshop_id', $workshop->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already registered for this workshop.');
        }

        $data = [
            'user_id' => $user->id,
            'workshop_id' => $workshop->id,
            'time' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if ($workshop->fee == 0) {
            // Free Workshop
            $data['payment_status'] = 2; // Completed langsung
            $data['status'] = 2;          // Registered
            $data['transfer_proof'] = null;
        } else {
            // Paid Workshop
            $data['payment_status'] = 1; // Under Review
            $data['status'] = 1;         // Not Registered

            if ($request->hasFile('transfer_proof')) {
                $filename = $request->file('transfer_proof')->store('transfer_proofs', 'public');
                $data['transfer_proof'] = $filename;
            }
        }

        WorkshopRegistration::create($data);

        return redirect()->back()->with('success', 'Registration successful!');
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

    public function result()
    {
        try {
            // Get current authenticated user
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Please login first');
            }

            // Get workshop registrations using Eloquent with relationships
            $registrations = WorkshopRegistration::with([
                'workshop:id,title',
                'score:id,registration_id,score,created_at',
                'certificate:id,registration_id,certificate'
            ])
                ->where('user_id', $user->id)
                ->where('status', '4')
                ->where('payment_status', '2')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('frontend.result', compact('registrations'));

        } catch (\Exception $e) {
            // Log error for debugging
            logger('Result page error: ' . $e->getMessage());

            // Return empty paginated collection to prevent blade errors
            $registrations = WorkshopRegistration::where('id', 0)->paginate(10);

            return view('frontend.result', compact('registrations'))
                ->with('error', 'Unable to load results at this time.');
        }
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

    public function showStudentProfile()
    {
        $user = Auth::user();
        return view('frontend.profile', compact('user'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Hapus avatar lama jika ada
        if ($user->avatar && Storage::disk('public')->exists('avatars/' . $user->avatar)) {
            Storage::disk('public')->delete('avatars/' . $user->avatar);
        }

        // Simpan avatar baru
        $avatarName = uniqid() . '.' . $request->avatar->extension();
        $request->avatar->storeAs('avatars', $avatarName, 'public');

        // Update ke database
        $user->avatar = $avatarName;
        $user->save();

        return back()->with('success', 'Profile picture updated successfully!');
    }

}
