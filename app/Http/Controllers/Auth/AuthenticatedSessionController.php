<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Jika mitra belum aktivasi, logout otomatis
            if ($user->hasRole('mitra') && !$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda belum aktif. Silakan aktivasi terlebih dahulu.',
                ]);
            }

            // Redirect berdasarkan role
            return $user->hasRole('admin') ? redirect()->route('admin.dashboard') :
                ($user->hasRole('mitra') ? redirect()->route('mitra.dashboard') :
                    redirect()->route('user.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }


    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function activateAccount()
    {
        return view('auth.activate');
    }

    public function activate(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('mitra') && !$user->is_active) {
            $user->is_active = true;
            $user->save();

            return redirect()->route('mitra.dashboard')->with('success', 'Akun berhasil diaktifkan!');
        }

        return redirect()->route('login')->withErrors(['email' => 'Anda tidak berhak melakukan aktivasi.']);
    }

}
