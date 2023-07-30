<?php

namespace App\Http\Controllers;

use App\Models\GemsTransfer;
use App\Models\User;
use App\Models\Customer;
use App\Models\Partner;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GemsTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gts = GemsTransfer::all();
        foreach($gts as $gt){        
            $gt->senderUser;
            $gt->receiverUser;
    }
        return $gts;    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => ['required','numeric'],
            'type' => ['string','in:C2C,P2C'],
            'phone_number' => ['required','exists:users,phone_number'],
        ]);
        $su = Auth::user();

        if($request['type'] == 'P2C' && $su->role_id == 2){$s = Partner::firstWhere('user_id',$su->id);$gems=$s->gems;}
        else if($request['type'] == 'C2C' && $su->role_id == 3){$s = Customer::firstWhere('user_id',$su->id);$gems=$s->cur_gems;}
        else{return response()->json(['message' => 'you can\'t send any gems !'],401);}

        $cu = User::firstWhere('phone_number',$request['phone_number']);
        $c = Customer::firstWhere('user_id',$cu->id);

        if($su->id == $cu->id){return response()->json(['message'=>'you can\'t transfer gems to your self !'],400);}

        if($cu && $c){
            if($gems >= $request['value']){
                $c->update(['cur_gems' => $c->cur_gems + $request['value'],'total_gems' => $c->total_gems + $request['value']]);
                if($su->role_id == 2){$s->update(['gems'=>$s->gems - $request['value']]);}
                if($su->role_id == 3){$s->update(['cur_gems'=>$s->cur_gems - $request['value']]);}
                $request->merge([
                    'sender_user_id' => $su->id,
                    'receiver_user_id' => $cu->id,
                ]);
                GemsTransfer::create($request->all());
                return response()->json(['messages'=>[                
                    'Transfer completed successfully!',
                    "$request->phone_number you recieved $request->value gems from $su->fname $su->lname"
                ]]);
            }else{
                return response()->json(['message'=>'you don\'t have enough gems to transfer !'],400);
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
        $gt = GemsTransfer::findOrFail($id);
        $gt->senderUser;
        $gt->receiverUser;
        return $gt;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTransfer()
    {
        $user = Auth::user();
        $user->GemsTransferSender;
        $user->GemsTransferReceiver;
        return $user;
    }

}
