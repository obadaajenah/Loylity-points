<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public static function transfer($sender_account_id , $receiver_account_id ,$amount){
        if($amount > 0){
            $sender_account = Account::findOrFail($sender_account_id);
            $receiver_account = Account::findOrFail($receiver_account_id);
            $receiver_account->update(['balance' => $receiver_account->balance + $amount]);
            $sender_account->update(['balance' => $sender_account->balance - $amount]);
            return response()->json(['message'=>'transfer done successfully!'],200);
        }else{
            return response()->json(['message'=>'Wrong amount !'],422);
        }
    }
}
