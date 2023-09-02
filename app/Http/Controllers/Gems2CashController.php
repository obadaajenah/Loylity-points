<?php

namespace App\Http\Controllers;

use App\Models\Gems2Cash;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\DefaultValue;
use Illuminate\Support\Facades\Auth;

class Gems2CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $g2cs = Gems2Cash::all();
        foreach($g2cs as $g2c){$g2c->customer->user;}
        return $g2cs;
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
            'gems' => ['required','numeric'],
            'card_number' => ['required','string'],
            'secret_key' => ['required','string']
        ]);
        $customer = Customer::firstWhere('user_id',Auth::user()->id);
        $g2c = DefaultValue::firstWhere('name','G2$')->value;

        if($customer->segmentation_id == 4){return response()->json(['message'=>'you can\'t convert your Gems to cash until you be VIP !'],400);}

        if($request['gems'] < $g2c){return response()->json(['message'=>'you can\'t convert less than ' . $g2c . ' gems !' ],400);}

        if($customer->cur_gems >= $request['gems'] && $request['gems'] >= $g2c){
            $newValue = $request['gems'] - $request['gems'] % (int) $g2c;
            $customer->update([
                'cur_gems' => $customer->cur_gems - $newValue,
            ]);
            CardController::restore($request,$newValue);
            Gems2Cash::create([
                'customer_id' => $customer->id,
                'gems' => $newValue,
                'cash' => $newValue / $g2c
            ]);
            return response()->json(['message'=>'your converting ' . $newValue . ' gems to ' . $newValue / $g2c . '$ done successfully !']);
        }else{
            return response()->json(['message'=>'you don\'t have enough gems to make this operation !'],400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mine()
    {
        $customer = Customer::firstWhere('user_id',Auth::user()->id);
        $g2cs = Gems2Cash::where('customer_id',$customer->id)->get();
        return response()->json(['g2cs'=>$g2cs]);
    }
}
