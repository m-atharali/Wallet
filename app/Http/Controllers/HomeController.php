<?php

namespace App\Http\Controllers;
use \App\Models\User;
use \App\Models\Wallet;
use \App\Models\Transaction;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function deposit(Request $request, $detail)
    {
        // echo $arr;
        // $type, $amount, $Doc_name, $email
        $email = $request->user()->email;
        $type = 'credit';
        $Doc_name = '';
        $amount = $detail;
        // echo $value;
        $tranc = new Transaction;
        $tranc->Transaction($type, $amount, $Doc_name, $email);
        // return $this->index($request);
        return redirect('/home');
        // $p = "amount";
        // $p = $request->user()->amount;
        // $p = $request->input('amount');
        // dd($request::hasfile('image'));
        // $email = $request->all();
        // $client = new\GuzzleHttp\Client();
        // $ref = uniqid();
        // $ref = "rave-".$ref;
        // $url = "https://api.flutterwave.com/v3/charges?type=card";
        // $customer_email = $request->email;
        // $amount = 120;
        // $currency = "NGN";
        // $txref = $ref;
        // $PBFPubKey = "FLWPUBK_TEST-9501425c2128614f9b53e64b8c033da3-X";
        // $redirect_url = "http://localhost:8000/api/confirm-transaction";
        // try
        // {
        //     $response = $client->request("POST",$url,[
        //         "headers" => [
        //             "content-type: application/json",
        //             "cache-control: no-cache"
        //         ],
        //         "form_params" => [
        //             'amount'=>$amount,
        //             'customer_email'=>$customer_email,
        //             'currency'=>$currency,
        //             'txref'=>$txref,
        //             'PBFPubKey'=>$PBFPubKey,
        //             'redirect_url'=>$redirect_url
        //         ]
        //     ]);
        //         $response = json_decode($response->getBody()->getContents(),true);
        //         return $response;
        // }
        // catch(GuzzleHttp\Exception\BadResponseException $e)
        // {
        //     $response = $e->getResponse();
        //     $responseBodyAsString = $response->getBody()->getContents();
        //     return $responseBodyAsString;
        // }

        // return 'look at me ooo';
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $email = $request->user()->email;
        // echo dd($email);
        // return $email;
        $tranc = new Transaction;
        $wallet = New Wallet;
        // $user = User::all();//0
        // $email = $user[0]->email;//1
        $amount = $wallet->table($email)[0]->total_balance;//2
        $currency = $wallet->table($email)[0]->currency;//3
        $transaction = $tranc->GetTransaction($email);
        // return $wallet->bal();
        // return $tranc->test();
        $wallet_id = $wallet->GetWallet_id($email);
        $transaction = $tranc->GetTransaction($wallet_id);
        return view('home', ['amount'=>$amount, 'currency'=>$currency, 'transaction' => $transaction]);
        // ->with('t_bal', $bal)->with('currency', $currency);
    }
}
