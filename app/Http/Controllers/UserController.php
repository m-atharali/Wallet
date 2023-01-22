<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use DB;

class UserController extends Controller
{
    //
    public function index()
    {
       $user = User::all();
       return response($user, 200);
    }
    public function getUser()
    {
       $user = User::all();
       return response($user, 200);
    }

    // public function index()
    // {
        // $this->table();
        // $this->GetWallet_id('sundaymatt703@gmail.com');
    // }
    public function GetWallet_info(Request $request)
    {   
        // $tranc = new Transaction;
        // $wallet = New Wallet;
        
        $email = $request->email;
        $wallet_id = \DB::table('users')
        ->where('email', $email)
        ->get();
        return response($wallet_id, 200);
    }
    public function GetTotalBalance(Request $request)
    {
        $email = $request->email;
        $wallet = new Wallet;
        $wallet_id = $wallet->GetWallet_id($email);
        $balance = $wallet->GetTotalBalance($wallet_id);
        return response()->json(['balance' => $balance]);
        //  response(,200);
        // return with currency
        // $balance = \DB::table('users')->select('wallet_id')
        // ->where('email', $email)
        // ->get()
        // ->pluck('wallet_id');
        // // echo dd($wallet_id);
        // // return $wallet_id[0];
        // return $balance;
    }

    public function GetTransactions(Request $request){
        $email = $request->email;
        $trans = new Transaction;
        $wallet = new Wallet;
        $wallet_id = $wallet->GetWallet_id($email);
        $transactions = $trans->GetTransaction($wallet_id);
        return response($transactions, 200);
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
    
    public function create(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $currency   = $request->currency;
        $user = $request->user_type;
        $request = $name .  $email . $currency;
        $wallet = $this->generateWalletID($request);
        // DB::insert('insert into wallet(wallet_id, user_type, currency) values(?,?,?)', [$wallet, $user, $currency]);
        DB::table('wallet')->insert(
            ['wallet_id' => $wallet, 'user_type' => $user, 'currency' => $currency]
        );
        // DB::table('wallet')->
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'wallet_id' => $wallet,
        ]);
    }

    public function UserDeposit(Request $request)
    {
        $email = $request->email;
        $type = 'credit';
        $Doc_name = '';
        $amount = $request->amount;
        // return $amount;
        // $user = User::all();
        // return response($user, 200);
        $tranc = new Transaction;
        $transactions = $tranc->Transaction($type, $amount, $Doc_name, $email);
        //return response($transactions, 200);
        // return $this->index($request);
        // return redirect('/home');
    }
    // public function example(){

    //     $displays=User::get();

    //     return view('display.h')->with(compact("displays"));
    // }
}
