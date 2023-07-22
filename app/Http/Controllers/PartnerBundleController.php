<?php

namespace App\Http\Controllers;

use App\Models\PartnerBundle;
use App\Models\Bundle;
use App\Models\Partner;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartnerBundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PartnerBundle::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function buyBundle(Request $request)
    {
        $request->validate([
            'bundle_id' => ['required' , 'numeric']
        ]);

        $bundle = Bundle::findOrFail($request->bundle_id);
        $request->merge(['price'=>$bundle->price]);

        #check if partner has a bundle in this month 

        #check if partner has enough money to buy this bundle


        /*
        ************using Bank API****************
        if(partner -> bankAccount -> balance >= $bundle -> price){
            transferToAdminAccount($bundle -> price);
        }
        */

        $user = Auth::user();
        if($user->role_id == 2){
            $p = Partner::where('user_id',$user->id)->get();
            $p->update([
                'gems'=>$bundle->gems,
                'bouns'=>$bundle->bonus,
                'status'=>1
            ]);
            $now = new DateTime();
            $request->merge([
                'partner_id' => $p->id,
                'price' => $bundle->price,
                'start_date' => getdate()['year'].'-'.getdate()['mon'].'-'.getdate()['mday'],
                'end_date' => date_add($now,date_interval_create_from_date_string($bundle->expiration_period . ' days')) //getdate()+$bundle->expiration_period,
            ]);

            PartnerBundle::create($request->all());

            return response()->json(['message'=>'bundle bought successfully!'],201);
        }else{
            return response()->json(['message'=>'you are not a partner !']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myBundlesHistory()
    {
        $user = Auth::user();
        $p = Partner::where('user_id',$user->id)->get();
        return PartnerBundle::where('partner_id',$p->id)->get();
    }
}
