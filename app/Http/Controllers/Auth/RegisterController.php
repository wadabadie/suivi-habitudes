<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use PragmaRX\Google2faQRCode\Google2FA;

class RegisterController extends Controller
{
    use RegistersUsers{
        register as registration;
    }

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name'             => $data['name'],
            'email'            => $data['email'],
            'password'         => Hash::make($data['password']),
            'google2fa_secret' => $data['google2fa_secret'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $google2fa  = app('pragmarx.google2fa');
        $secret     = $google2fa->generateSecretKey();

        $registrationData = [
            'name'             => $request->name,
            'email'            => $request->email,
            'password'         => $request->password,
            'google2fa_secret' => $secret,
        ];

        $request->session()->put('registration_data', $registrationData);
        $request->session()->save();

        $cacheKey = 'reg_' . md5($request->email);
        Cache::put($cacheKey, $registrationData, now()->addMinutes(30));

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $request->email,
            $secret
        );

        return view('google2fa.register', compact('QR_Image', 'secret'));
    }

    public function showVerify2FA(Request $request)
    {
        $registrationData = session('registration_data');
        if (!$registrationData) {
            return redirect('/register')->withErrors([
                'session' => 'Session expirée. Veuillez vous réinscrire.'
            ]);
        }
        return view('google2fa.verify');
    }

    public function completeRegistration(Request $request)
    {
        $registrationData = session('registration_data');

        if (!$registrationData) {
            return redirect('/register')->withErrors([
                'session' => 'Session expirée. Veuillez vous réinscrire.'
            ]);
        }

        $otp = $request->input('otp');
        if (!$otp) {
            return back()->withErrors(['otp' => 'Code OTP requis.']);
        }

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($registrationData['google2fa_secret'], $otp);

        if (!$valid) {
            return back()->withErrors(['otp' => 'Code OTP invalide. Réessaie.']);
        }

        $user = $this->create($registrationData);

        $request->session()->forget('registration_data');

        Auth::login($user);
        session(['google2fa_passed' => true]);

        return redirect()->route('habitudes.index');
    }

    public function showQrCode()
    {
        $registrationData = session('registration_data');
        if (!$registrationData) {
            return redirect('/register');
        }

        $google2fa = app('pragmarx.google2fa');
        $QR_Image  = $google2fa->getQRCodeInline(
            config('app.name'),
            $registrationData['email'],
            $registrationData['google2fa_secret']
        );
        $secret = $registrationData['google2fa_secret'];

        return view('google2fa.register', compact('QR_Image', 'secret'));
    }
}
