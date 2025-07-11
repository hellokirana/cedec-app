<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\Order;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\DataTables\KontakDataTable;
use App\DataTables\MemberDataTable;
use Laravolt\Indonesia\Models\City;
use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Illuminate\Support\Facades\Validator;

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
        return view('home');
    }

    public function profil()
    {
        $data = Auth::user();
        return view('frontend.profil', compact('data'));
    }


    public function update_profil(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'no_rekening' => 'nullable|string|unique:users,no_rekening,' . Auth::user()->id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|max:2048',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $data = User::where('id', Auth::user()->id)->first();
        if (empty($data)) {
            return redirect()->back()->with('error', 'data tidak ditemukan');
        }
        $data->name = $request->name;
        $data->email = $request->email;
        if (!empty($request->password)) {
            $data->password = bcrypt($request->password);
        }
        $data->no_telp = $request->no_telp;
        $data->province_code = $request->province_code;
        $data->city_code = $request->city_code;
        $data->district_code = $request->district_code;
        $data->village_code = $request->village_code;
        $data->alamat = $request->alamat;
        $data->rt = $request->rt;
        $data->rw = $request->rw;

        if ($request->no_rekening !== $data->no_rekening) {
            $data->no_rekening = $request->no_rekening;
        }

        $fileimage = $request->file('image');
        if (!empty($fileimage)) {
            $fileimageName = date('dHis') . '.' . $fileimage->getClientOriginalExtension();
            Storage::putFileAs(
                'public/user',
                $fileimage,
                $fileimageName
            );

            $data->avatar = $fileimageName;
        }
        $data->update();
        Session::flash('success', 'data berhasil di simpan');
        return redirect('profil');
    }
    public function getCities($province_code)
    {
        try {
            $cities = City::where('province_code', $province_code)->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getDistricts($city_code)
    {
        try {
            $districts = District::where('city_code', $city_code)->get();
            return response()->json($districts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getVillages($district_code)
    {
        try {
            $villages = Village::where('district_code', $district_code)->get();
            return response()->json($villages);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
