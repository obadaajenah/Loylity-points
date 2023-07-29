<?php

namespace App\Http\Controllers;

use App\Models\BonusTransfer;
use App\Models\User;
use App\Models\Customer;
use App\Models\Partner;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function store(Request $request)
    {
        // dd($request['phone_number']);
        $request->validate([
            'value' => ['required','numeric'],
            'type' => ['string'],//C2C P2C
            'phone_number' => ['required']
        ]);
        $pu = Auth::user();
        $p = Partner::where('user_id',$pu->id)->first();
        $cu = User::where('phone_number',$request['phone_number'])->first();
        // dd($cu->toArray());
        $c = Customer::where('user_id',$cu->id)->first();
        if($cu && $c && $p->bonus >= $request['value']){
            $c->update(['cur_bonus' => $c->cur_bonus + $request['value'],'total_bonus' => $c->total_bonus + $request['value']]);
            $p->update(['bonus'=>$p->bonus - $request['value']]);
            $request->merge([
                'sender_user_id' => $pu->id,
                'receiver_user_id' => $cu->id,
                'exp_date' => date_add(new DateTime(),date_interval_create_from_date_string('30 days')),
            ]);
            BonusTransfer::create($request->all());
            return response()->json(['message'=>'Transfer completed successfully!']);
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

}
