<?php

namespace App\Http\Controllers;

use App\Models\Bonus2Gems;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\DefaultValue;
use Illuminate\Support\Facades\Auth;

class Bonus2GemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $b2gs = Bonus2Gems::all();
        foreach($b2gs as $b2g){$b2g->customer->user;}
        return $b2gs;
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
            'bonus' => ['required','numeric']
        ]);
        $customer = Customer::firstWhere('user_id',Auth::user()->id);
        $b2g = DefaultValue::firstWhere('name','B2G')->value;

        if($request['bonus'] < $b2g){return response()->json(['message'=>'you can\'t convert less than ' . $b2g . ' bonus !' ],400);}

        if($customer->cur_bonus >= $request['bonus'] && $request['bonus'] >= $b2g){
            $newValue = $request['bonus'] - $request['bonus'] % (int) $b2g;
            $customer->update([
                'cur_bonus' => $customer->cur_bonus - $newValue,
                'cur_gems' => $customer->cur_gems + $newValue / $b2g,
                'total_gems' => $customer->total_gems + $newValue / $b2g,
            ]);
            Bonus2Gems::create([
                'customer_id' => $customer->id,
                'bonus' => $newValue,
                'gems' => $newValue / $b2g
            ]);
            return response()->json(['message'=>'your converting ' . $newValue . ' bonus to ' . $newValue / $b2g . ' gems done successfully !']);
        }else{
            return response()->json(['message'=>'you don\'t have enough bonus to make this operation !'],400);
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
        $b2gs = Bonus2Gems::where('customer_id',$customer->id)->get();
        return response()->json(['b2gs'=>$b2gs]);
    }

}
