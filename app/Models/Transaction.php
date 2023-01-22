<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;
use App\Models\Wallet;
use DB;

class Transaction extends Model
{
    use HasFactory;

    
    // public function tst()
    // {
    //     $type = 'debit';
    //     $amount = 50000;
    //     $Doc_name = 'Matthew';
    //     $email = 'sundaymatt703@gmail.com';
    //     $this->GetTransaction($email);
    // }
    
    public function GetTransaction($wallet_id)
    {
        // $wallet = new Wallet;
        // $wallet_id = $wallet->GetWallet_id($email);
        $balance = \DB::table('wallet_ledger')->select('id','transaction_id','transaction_type','description','amount','balance','created_at')
        ->orderBy('id', 'desc')
        ->where('wallet_id', $wallet_id)
        ->get();
        //output transaction type, desc, amount, balance, date/time
        // dd($balance);
        return $balance;
    }

    public function UpdateTransaction($wallet_id, $transaction_type, $description, $transaction_id, $amount, $balance)
    {//is working
        date_default_timezone_set('Africa/Lagos');
        $date = date('y-m-d h:i:s');
        DB::table('wallet_ledger')->insert(
            ['wallet_id' => $wallet_id, 'transaction_type' => $transaction_type, 'description' => $description,'transaction_id' => $transaction_id,'amount' => $amount,'balance' => $balance, 'created_at'=>$date]
        );
    }

    public function Transaction($type, $amount, $Doc_name, $email)
    {//is working
        $wallet = new Wallet;
        $wallet_id = $wallet->GetWallet_id($email);
        //type is gotten from button
        //desc with regards type
        // update wallet_ledger
        $transaction_id = Uuid::generate(4);
            // dd($uuid->time);  - this extracts the time the id was created
        if ($type == 'credit')
        {
            $desc = 'your account was credited';
            $newBalance = $wallet->IncrementBalance($wallet_id, $amount);
            $wallet->UpdateTotalBalance($wallet_id, $newBalance);
            // echo '<h1>' . 'account credited successfully'  . '</h1>';
        }
        else
        {
            $desc = 'your account was debited for section with ' . $Doc_name;
            $newBalance = $wallet->DecrementBalance($wallet_id, $amount);
            if ($newBalance == 'Insufficient balance')
            {
                echo '<h1>' . $newBalance  . '</h1>';
                return;
            }
            $wallet->UpdateTotalBalance($wallet_id, $newBalance);
            // echo '<h1>' . 'account debited successfully'  . '</h1>';
        }  

        $balance = $wallet->GetTotalBalance($wallet_id);
        //collect new balance from wallet
        //update transaction table with values
        $this->UpdateTransaction($wallet_id, $type, $desc, $transaction_id, $amount, $newBalance);
    }
}
