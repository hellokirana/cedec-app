<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'g-recaptcha-response' => 'required', // Validasi reCAPTCHA
        ]);
    }

    public function register(Request $request)
    {
        // Validasi input
        $this->validator($request->all())->validate();

        // Validasi reCAPTCHA
        $response = $request->input('g-recaptcha-response');
        $secret = env('RECAPTCHA_SECRET_KEY');

        // Kirim permintaan ke Google untuk memverifikasi reCAPTCHA
        $captchaResponse = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => $secret,
            'response' => $response,
        ]);

        $captchaData = $captchaResponse->json();

        // Cek apakah reCAPTCHA valid
        if (!$captchaData['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'CAPTCHA verification failed.']);
        }

        // Jika validasi berhasil, buat pengguna baru
        $user = $this->create($request->all());

        // Login pengguna setelah pendaftaran
        auth()->login($user);

        return redirect($this->redirectTo);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Jika Anda menggunakan sistem peran, pastikan ini sesuai dengan implementasi Anda
        $user->assignRole('member'); // Pastikan Anda memiliki metode assignRole di model User

        return $user;
    }
}
