<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Partner;
use Illuminate\Support\Facades\Auth;
use App\Models\PartnerBundle;
use DateTime;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Offer::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBySegmentation($segmentation_id)
    {
        return Offer::where('segmentation_id',$segmentation_id)->get();
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
            'name' => ['required','string'],
            'segmentation_id' => ['required','numeric','digits_between:1,4'],
            'value' => ['required'],
            'quantity' => ['required', 'numeric']
        ]);
        $partner = Partner::where(['user_id'=>Auth::user()->id])->first();
        $partnerBundle = PartnerBundle::where('partner_id',$partner->id)->latest('id')->first();

        #check validty of bundle
        $interval = date_diff(new DateTime(),new DateTime($partnerBundle->end_date))->format('%R%a');
        if($interval <= 0){
            return response()->json(['message' => 'your bundle expired !']);
        }

        if($request->segmentation_id == 1){
            if($partnerBundle->golden_offers_number <= 0){
                return response()->json(['message'=>'your limit is over!']);
            }else{
                $partnerBundle->update(['golden_offers_number'=>$partnerBundle->golden_offers_number-1]);
            }
        }
        if($request->segmentation_id == 2){
            if($partnerBundle->silver_offers_number <= 0){
                return response()->json(['message'=>'your limit is over!']);
            }else{
                $partnerBundle->update(['silver_offers_number'=>$partnerBundle->silver_offers_number-1]);
            }
        }
        if($request->segmentation_id == 3){
            if($partnerBundle->bronze_offers_number <= 0){
                return response()->json(['message'=>'your limit is over!']);
            }else{
                $partnerBundle->update(['bronze_offers_number'=>$partnerBundle->bronze_offers_number-1]);
            }
        }
        if($request->segmentation_id == 4){
            if($partnerBundle->new_offers_number <= 0){
                return response()->json(['message'=>'your limit is over!']);
            }else{
                $partnerBundle->update(['new_offers_number'=>$partnerBundle->new_offers_number-1]);
            }
        }

        $request->merge(['partner_id'=>$partner->id]);
        Offer::create($request->all());
        return response()->json(['message'=>'Offer added successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Offer::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
