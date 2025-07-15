<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Order;
use App\Models\Layanan;
use App\Models\Workshop;
use Illuminate\Http\Request;
use App\DataTables\KontakDataTable;
use App\DataTables\MemberDataTable;
use Laravolt\Indonesia\Models\City;
use App\Models\WorkshopRegistration;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Total workshops
        $totalWorkshops = Workshop::count();

        // Total participants (registered users)
        $totalParticipants = WorkshopRegistration::distinct('user_id')->count();

        // Ongoing workshops (currently running)
        $ongoingWorkshops = Workshop::where('status', 2)->count();

        // Chart data - workshops with participant counts
        $workshopChart = Workshop::select('id', 'title')
            ->withCount([
                'registrations' => function ($query) {
                    $query;
                }
            ])
            ->orderBy('registrations_count', 'desc')
            ->take(10)
            ->get()
            ->map(function ($workshop) {
                return [
                    'id' => $workshop->id,
                    'title' => $workshop->title,
                    'registrations_count' => $workshop->registrations_count ?? 0
                ];
            });

        // Recent workshops with additional details
        $recentWorkshops = Workshop::select(
            'id',
            'title',
            'workshop_start_date',
            'workshop_end_date',
            'quota',
            'status',
            'registration_start_date',
            'registration_end_date'
        )
            ->withCount([
                'registrations' => function ($query) {
                    $query->where('status', 1);
                }
            ])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Additional statistics
        $completedWorkshops = Workshop::where('status', 3)
            ->count();

        $upcomingWorkshops = Workshop::where('status', 1)
            ->count();

        // Registration statistics
        $pendingRegistrations = WorkshopRegistration::where('payment_status', 1)->count();
        $confirmedRegistrations = WorkshopRegistration::where('status', 1)->count();

        // Monthly registration trend (last 6 months)
        $monthlyRegistrations = WorkshopRegistration::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Registration status chart data
        $registrationStatusData = [
            'pending' => $pendingRegistrations,
            'confirmed' => $confirmedRegistrations,
            'total' => $pendingRegistrations + $confirmedRegistrations
        ];

        return view('home', compact(
            'totalWorkshops',
            'totalParticipants',
            'ongoingWorkshops',
            'recentWorkshops',
            'completedWorkshops',
            'upcomingWorkshops',
            'pendingRegistrations',
            'confirmedRegistrations',
            'monthlyRegistrations'
        ))->with([
                    'chartData' => [
                        'labels' => $workshopChart->pluck('title'),
                        'participants' => $workshopChart->pluck('registrations_count'),
                    ],
                    'registrationStatusData' => $registrationStatusData
                ]);
    }

    private function generateChartData()
    {
        $workshops = Workshop::withCount('registrations')->get();

        return [
            'labels' => $workshops->pluck('title'),
            'participants' => $workshops->pluck('registrations_count'),
        ];
    }

    public function profil()
    {
        $data = Auth::user();
        return view('frontend.profil', compact('data'));
    }

    // public function update_profil(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string',
    //         'no_rekening' => 'nullable|string|unique:users,no_rekening,' . Auth::user()->id,
    //         'password' => 'nullable|min:6',
    //         'image' => 'nullable|image|max:2048',
    //         'no_telp' => 'nullable|string',
    //         'email' => 'nullable|email',
    //     ]);

    //     $data = User::where('id', Auth::user()->id)->first();
    //     if (empty($data)) {
    //         return redirect()->back()->with('error', 'Data not found');
    //     }

    //     $data->name = $request->name;
    //     $data->email = $request->email;

    //     if (!empty($request->password)) {
    //         $data->password = bcrypt($request->password);
    //     }

    //     $data->no_telp = $request->no_telp;
    //     $data->province_code = $request->province_code;
    //     $data->city_code = $request->city_code;
    //     $data->district_code = $request->district_code;
    //     $data->village_code = $request->village_code;
    //     $data->alamat = $request->alamat;
    //     $data->rt = $request->rt;
    //     $data->rw = $request->rw;

    //     if ($request->no_rekening !== $data->no_rekening) {
    //         $data->no_rekening = $request->no_rekening;
    //     }

    //     $fileimage = $request->file('image');
    //     if (!empty($fileimage)) {
    //         // Delete old image if exists
    //         if ($data->avatar) {
    //             Storage::delete('public/user/' . $data->avatar);
    //         }

    //         $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
    //         Storage::putFileAs('public/user', $fileimage, $fileimageName);
    //         $data->avatar = $fileimageName;
    //     }

    //     $data->update();
    //     Session::flash('success', 'Profile updated successfully');
    //     return redirect('profil');
    // }
}