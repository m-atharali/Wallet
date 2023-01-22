<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Wallet extends Model
{
    use HasFactory;

    public function table($email)
    {//is working
        $users = DB::table('users')
            ->join('wallet', 'users.wallet_id', '=', 'wallet.wallet_id')
            // ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'wallet.currency', 'wallet.total_balance')
            ->where('email', $email)
            ->get();
            // $users[0]->name
        return $users;
    }
    public function GetWallet_id($email)
    {//is working
        $wallet_id = \DB::table('users')->select('wallet_id')
        ->where('email', $email)
        ->get()
        ->pluck('wallet_id');
        // echo dd($wallet_id);
        return $wallet_id[0];
    }
    public function GetTotalBalance($wallet_id)
    {//is working
        // return with currency
        $balance = \DB::table('wallet')->select('total_balance')
        ->where('wallet_id', $wallet_id)
        ->get()
        ->pluck('total_balance');
        // echo dd($wallet_id);
        return $balance[0];
        // return $balance;
    }
    public function IncrementBalance($wallet_id, $amount)
    {//is working
        $initial_balance = $this->GetTotalBalance($wallet_id);
        $new_balance = $initial_balance + $amount;
        $this->UpdateTotalBalance($wallet_id, $new_balance);
        return $this->GetTotalBalance($wallet_id);
    }

    public function DecrementBalance($wallet_id, $amount)
    {//is working
        $initial_balance = $this->GetTotalBalance($wallet_id);
        $new_balance = $initial_balance - $amount;
        if($new_balance < 0)
        {
            return 'Insufficient balance';
        }
        $this->UpdateTotalBalance($wallet_id, $new_balance);
        return $this->GetTotalBalance($wallet_id);
    }

    public function UpdateTotalBalance($wallet_id, $amount)
    {//is working
        DB::table('wallet')
        ->where('wallet_id',$wallet_id)
        ->update(['total_balance' => $amount]);
        //update wallet amount
    }

    //to check
    // public function bal()
    // {
        // $amount = 43800;
        // $email = 'sundaymatt703@gmail.com';
        // $wallet_id = $this->GetWallet_id($email);
        // $this->GetTotalBalance($email);
    // }
}
