<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class CardController extends Controller
{
    public static function checkout(Request $request , $amount){
        $request->validate([
            'card_number' => ['required','string'],
            'secret_key' => ['required','string']
        ]);
        $card = Card::firstWhere('card_number',$request->card_number);
        
        if(Hash::check($request->secret_key, $card->secret_key)){
            $account = Account::findOrFail($card->account_id);
            
            #check if user has enough money to checkout
            if($account->balance >= $amount){
                $res = AccountController::transfer($card->account_id,1,$amount);
                return $res;
            }else{
                return response()->json(['message'=>'you don\'t have enough balance to complete this operation!'],403);
            }
        }
    }

    public static function restore(Request $request , $amount){
        $request->validate([
            'card_number' => ['required','string'],
            'secret_key' => ['required','string']
        ]);
        $card = Card::firstWhere('card_number',$request->card_number);        
        
        if(Hash::check($request->secret_key, $card->secret_key)){
            $account = Account::findOrFail($card->account_id);
            $admin = Account::findOrFail(1);

            #check if user has enough money to checkout
            if($admin->balance >= $amount){
                $res = AccountController::transfer(1,$account->id,$amount);
                return $res;
            }else{
                return response()->json(['message'=>'There is Error right now ! Try Again or contact with us !'],500);
            }
        }
    }

}
