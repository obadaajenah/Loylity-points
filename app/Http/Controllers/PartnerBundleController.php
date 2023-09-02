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
            'bundle_id' => ['required' , 'numeric'],
            'card_number' => ['required','string'],
            'secret_key' => ['required','string']
        ]);

        $bundle = Bundle::findOrFail($request->bundle_id);
        
        $user = Auth::user();
        if($user->role_id == 2){
            $partner = Partner::where('user_id',$user->id)->firstOrFail();
            
            #check if partner has a bundle in this month
            $pb = PartnerBundle::where('partner_id',$partner->id)->where('status',1)->first();
            if(isset($pb)){
                return response()->json(['message'=>'you can\'t buy bundle when you have one !'],400);
            }

            #using Bank Api-------------------------------------------------------------------
            CardController::checkout($request,$bundle->price);
            #---------------------------------------------------------------------------------
            
            $partner->update([
                'gems'=>$bundle->gems,
                'bonus'=>$bundle->bonus,
            ]);
            $now = new DateTime();
            $request->merge([
                'start_date' => getdate()['year'].'-'.getdate()['mon'].'-'.getdate()['mday'],
                'end_date' => date_add($now,date_interval_create_from_date_string($bundle->expiration_period . ' days')) //getdate()+$bundle->expiration_period,
            ]);

            PartnerBundle::create([
                'partner_id' => $partner->id,
                'bundle_id' => $bundle->id,
                'status' => 1,
                'price' => $bundle->price,
                'golden_offers_number' => $bundle->golden_offers_number,
                'silver_offers_number' => $bundle->silver_offers_number,
                'bronze_offers_number' => $bundle->bronze_offers_number,
                'new_offers_number' => $bundle->new_offers_number,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

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
        $pb =  PartnerBundle::where('partner_id',$p->id)->get();

        return response()->json(['pb' => $pb]);
    }
}
