<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2faQRCode\Google2FA;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers{
        register as registration;
    }

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'google2fa_secret' => $data['google2fa_secret'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $google2fa = app('pragmarx.google2fa');

        $registration_data = $request->all();
        $registration_data['google2fa_secret'] = $google2fa->generateSecretKey();


        $request->session()->put('registration_data', $registration_data);


        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            $registration_data['email'],
            $registration_data['google2fa_secret']
        );

        $secret = $registration_data['google2fa_secret'];

        return view('google2fa.register', compact('QR_Image', 'secret'));

    }

    public function completeRegistration(Request $request)
    {
        $registrationData = session('registration_data');
        if (!$registrationData) {
            return redirect('/register')->withErrors(['session' => 'Session expired. Please register again.']);
        }

        // Vérifier le code OTP
        $otp = $request->input('otp');
        if (!$otp) {
            return redirect('/register/verify-2fa')->withErrors(['otp' => 'Code OTP requis.']);
        }

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($registrationData['google2fa_secret'], $otp);

        if (!$valid) {
            return back()->withErrors(['otp' => 'Code OTP invalide.']);
        }

        $request->merge($registrationData);
        $user = $this->create($request->all());
        Auth::login($user);
        return redirect('/home');
    }

    public function showVerify2FA()
    {
        if (!session('registration_data')) {
            return redirect('/register');
        }
        return view('google2fa.verify');
    }
}
