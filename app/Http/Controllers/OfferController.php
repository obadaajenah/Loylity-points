<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Partner;
use Illuminate\Support\Facades\Auth;
use App\Models\PartnerBundle;
use DateTime;
use Illuminate\Http\Request;
use App\Models\Customer;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myoffers()
    {
        $user = Auth::user();
        $c = Customer::firstWhere('user_id',$user->id);
        return Offer::where('segmentation_id',$c->segmentation_id)->get();
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
            'segmentation_id' => ['required','numeric','digits_between:1,4'],
            'valueInBonus' => ['required_without:valueInGems','numeric','min:0'],
            'valueInGems' => ['required_without:valueInBonus','numeric','min:0'],
            'quantity' => ['required','numeric','min:0'],
            'image' => ['image'],
            'name' => ['required','string']
        ]);

        if ($request->image && !is_string($request->image)) {
            $photo = $request->image;
            $newPhoto = time() . $photo->getClientOriginalName();
            $photo->move('uploads/offers', $newPhoto);
            $request["img_url"] = 'uploads/offers/' . $newPhoto;
        }

        $partner = Partner::firstWhere(['user_id'=>Auth::user()->id]);
        $partnerBundle = PartnerBundle::where('partner_id',$partner->id)->where('status',1)->latest('id')->first();

        if(!$partnerBundle){return response()->json(['message'=>'please buy bundle to add an offer']);}

        #check validty of bundle
        $interval = date_diff(new DateTime(),new DateTime($partnerBundle->end_date))->format('%R%a');
        if($interval <= 0){
            return response()->json(['message' => 'your bundle expired !']);
        }

        if($request->segmentation_id == 1){
            if($partnerBundle->golden_offers_number <= 0){
                return response()->json(['message'=>'your limit is over!']);
            }else{
                // $partnerBundle->decrement('golden_offers_number');
                $partnerBundle->update(['golden_offers_number'=>$partnerBundle->golden_offers_number-1]);
            }
        }
        else if($request->segmentation_id == 2){
            if($partnerBundle->silver_offers_number <= 0){
                return response()->json(['message'=>'your limit is over!']);
            }else{
                $partnerBundle->update(['silver_offers_number'=>$partnerBundle->silver_offers_number-1]);
            }
        }
        else if($request->segmentation_id == 3){
            if($partnerBundle->bronze_offers_number <= 0){
                return response()->json(['message'=>'your limit is over!']);
            }else{
                $partnerBundle->update(['bronze_offers_number'=>$partnerBundle->bronze_offers_number-1]);
            }
        }
        else if($request->segmentation_id == 4){
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
        $user = Auth::user();
        $offer = Offer::findOrFail($id);

        if($user->role_id ==2){
            $partner = Partner::findOrFail($user->id);
            if($offer->partner_id !== $partner->id){
                return response()->json(['message'=>'you don\'t have a permission to show this offer!'],401);
            }
        }
        return response()->json(['offer'=>$offer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'segmentation_id' => ['numeric','digits_between:1,4'],
            'valueInBonus' => ['numeric','min:0'],
            'valueInGems' => ['numeric','min:0'],
            'quantity' => ['numeric','min:0'],
            'image' => ['image'],
            'name' => ['string']
        ]);

        if ($request->image && !is_string($request->image)) {
            $photo = $request->image;
            $newPhoto = time() . $photo->getClientOriginalName();
            $photo->move('uploads/offers', $newPhoto);
            $request["img_url"] = 'uploads/offers/' . $newPhoto;
        }

        $partner = Partner::firstWhere(['user_id'=>Auth::user()->id]);
        $offer = Offer::findOrFail($id);
        $partnerBundle = PartnerBundle::where('partner_id',$partner->id)->where('status',1)->latest('id')->first();

        if($partner->id == $offer->partner_id){
            if($request->segmentation_id == 1){
                if($partnerBundle->golden_offers_number <= 0){
                    return response()->json(['message'=>'your limit is over!']);
                }else{
                    // $partnerBundle->decrement('golden_offers_number');
                    $partnerBundle->update(['golden_offers_number'=>$partnerBundle->golden_offers_number-1]);
                }
            }
            else if($request->segmentation_id == 2){
                if($partnerBundle->silver_offers_number <= 0){
                    return response()->json(['message'=>'your limit is over!']);
                }else{
                    $partnerBundle->update(['silver_offers_number'=>$partnerBundle->silver_offers_number-1]);
                }
            }
            else if($request->segmentation_id == 3){
                if($partnerBundle->bronze_offers_number <= 0){
                    return response()->json(['message'=>'your limit is over!']);
                }else{
                    $partnerBundle->update(['bronze_offers_number'=>$partnerBundle->bronze_offers_number-1]);
                }
            }
            else if($request->segmentation_id == 4){
                if($partnerBundle->new_offers_number <= 0){
                    return response()->json(['message'=>'your limit is over!']);
                }else{
                    $partnerBundle->update(['new_offers_number'=>$partnerBundle->new_offers_number-1]);
                }
            }
            $offer->update($request->all());
            return response()->json(['message'=>'Offer updated successfully!']);
    
        }else{
            return response()->json(['message'=>'you aren\'t authorized !'],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $partner = Partner::firstWhere(['user_id'=>Auth::user()->id]);
        $offer = Offer::findOrFail($id);

        if($partner->id == $offer->partner_id){
            $offer->delete();
            return response()->json(['message'=>'offer deleted successfully !']);
        }
        else{
            return response()->json(['message'=>'you aren\'t authorized !'],401);
        }
    }
}
