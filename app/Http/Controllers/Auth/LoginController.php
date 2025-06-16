<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required', // Validasi reCAPTCHA
        ]);

        // Validasi reCAPTCHA
        $response = $request->input('g-recaptcha-response');
        $secret = env('RECAPTCHA_SECRET_KEY');

        $captchaResponse = Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify", [
            'secret' => $secret,
            'response' => $response,
        ]);

        $captchaData = $captchaResponse->json();

        if (!$captchaData['success']) {
            return back()->withErrors(['g-recaptcha-response' => 'CAPTCHA validation failed.']);
        }

        // Jika validasi CAPTCHA berhasil, lanjutkan dengan login
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // Jika login gagal, kembalikan ke form dengan error
        return $this->sendFailedLoginResponse($request);
    }
}
