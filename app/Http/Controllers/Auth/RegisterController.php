<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * @param  array  $data
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
    public function generateWalletID($request)
    {

        // HMAC Hex to byte
        $secret     = 'waveWallet@1';

        // Concat infos
        // $string     = $request;

        // generate SIGN
        $sign       = hash_hmac('sha256', $request, $secret);
        return $sign;
    }
// public function wallet_id($request)
    // {
        
        // $username   = $request->name;
        // $email      = $request->email;
        // $this->generateWalletID($request);
    // }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $name = $data['name'];
        $email = $data['email'];
        $currency   = 'NGN';
        $user = 'own';
        $request = $name .  $email . $currency;
        $wallet = $this->generateWalletID($request);
        // DB::insert('insert into wallet(wallet_id, user_type, currency) values(?,?,?)', [$wallet, $user, $currency]);
        \DB::table('wallet')->insert(
            ['wallet_id' => $wallet, 'user_type' => $user, 'currency' => $currency]
        );
        // DB::table('wallet')->
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($data['password']),
            'wallet_id' => $wallet,
        ]);
    }
}
