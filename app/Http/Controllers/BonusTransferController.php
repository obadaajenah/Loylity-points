<?php

namespace App\Http\Controllers;

use App\Models\BonusTransfer;
use App\Models\User;
use App\Models\Customer;
use App\Models\Partner;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\NotifyEvent;
use Illuminate\Support\Facades\Broadcast;

class BonusTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bts = BonusTransfer::all();
        foreach($bts as $bt){        
            $bt->senderUser;
            $bt->receiverUser;
        }
        return $bts;    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function store(Request $request)
    {
        $request->merge(['phone_number'=>'+'.$request->phone_number]);
        $request->validate([
            'value' => ['required','numeric'],
            'type' => ['string','in:C2C,P2C,A2C'],
            'phone_number' => ['required','exists:users,phone_number']
        ]);
        $su = Auth::user();

        if($request['type'] == 'A2C'){
            $bonus = 999999999;
            $su = User::where('id',1)->firstOrFail();
        }else{
            if($request['type'] == 'P2C' && $su->role_id == 2){$su = Auth::user();$s = Partner::firstWhere('user_id',$su->id);$bonus=$s->bonus;}
            else if($request['type'] == 'C2C' && $su->role_id == 3){$su = Auth::user();$s = Customer::firstWhere('user_id',$su->id);$bonus=$s->cur_bonus;}
            else{return response()->json(['message' => 'There\'s error ! Try again or contact with us ...'],400);}
        }
        
        $cu = User::firstWhere('phone_number',$request['phone_number']);
        $c = Customer::firstWhere('user_id',$cu->id);
        
        if($su->id == $cu->id){return response()->json(['message'=>'you can\'t transfer bonus to yourself !'],400);}

        if($cu && $c){
            if($bonus >= $request['value'] && $bonus - $request['value'] >= 0){
                $c->update(['cur_bonus' => $c->cur_bonus + $request['value'],'total_bonus' => $c->total_bonus + $request['value']]);
                if($su->role_id == 2){$s->update(['bonus'=>$s->bonus - $request['value']]);$name=$su->fname.' '.$su->lname;}
                if($su->role_id == 3){$s->update(['cur_bonus'=>$s->cur_bonus - $request['value']]);$name=$s->nickName;}
                $request->merge([
                    'sender_user_id' => $su->id,
                    'receiver_user_id' => $cu->id,
                    'exp_date' => date_add(new DateTime(),date_interval_create_from_date_string('30 days')),
                ]);
                BonusTransfer::create($request->all());

                #Send Notification
                Broadcast::channel('user.{userId}',function($user,$userId,$sender,$value){
                    event(new NotifyEvent("$user->phone_number you recieved $value bonus from $sender->fname $sender->lname"));
                    return true;
                });
                
                return response()->json(['messages'=>['Transfer completed successfully!']]);
            }else{
                return response()->json(['message'=>'you don\'t have enough bonus to transfer !'],400);
            }
        }
        else{return response()->json(['message'=>'failure!'],400);}
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bt = BonusTransfer::findOrFail($id);
        $bt->senderUser;
        $bt->receiverUser;
        return $bt;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTransfer()
    {
        $user = Auth::user();
        foreach($user->BonusTransferSender as $b){
            $b->senderUser;
            $b->receiverUser;
        }
        foreach($user->BonusTransferReceiver as $b){
            $b->senderUser;
            $b->receiverUser;
        }
        return $user;
    }
}