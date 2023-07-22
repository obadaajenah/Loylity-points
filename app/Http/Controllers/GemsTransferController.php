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
        // dd($request['phone_number']);
        $request->validate([
            'value' => ['required','numeric'],
            'type' => ['string'],//C2C P2C
            'phone_number' => ['required']
        ]);
        $su = Auth::user();

        if($request['type'] == 'P2C' && $su->role_id == 2){$s = Partner::firstWhere('user_id',$su->id);}
        else if($request['type'] == 'C2C' && $su->role_id == 3){$s = Customer::firstWhere('user_id',$su->id);}
        else{return response()->json(['message' => 'you can\'t send any bonus !'],401);}

        $cu = User::where('phone_number',$request['phone_number'])->first();
        $c = Customer::where('user_id',$cu->id)->first();
        if($s->gems >= $request['value']){
            $c->update(['cur_gems' => $c->cur_gems + $request['value'],'total_gems' => $c->total_gems + $request['value']]);
            $s->update(['gems'=>$s->gems - $request['value']]);
            $request->merge([
                'sender_user_id' => $su->id,
                'receiver_user_id' => $cu->id,
            ]);
            GemsTransfer::create($request->all());
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
        $gt = GemsTransfer::findOrFail($id);
        $gt->senderUser;
        $gt->receiverUser;
        return $gt;
    }
}