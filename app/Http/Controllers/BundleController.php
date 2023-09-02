<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;
use App\Http\Requests\BundleRequest;
use App\Models\DefaultValue;
use App\Models\Segmentation;

class BundleController extends Controller
{

    public function index()
    {
       return Bundle::all();
    }


    public function store(BundleRequest $request)
    {
        $g2d = (int) DefaultValue::where('name','G2$')->firstOrFail()->value;
        $b2g = (int) DefaultValue::where('name','B2G')->firstOrFail()->value;
        $profit =(float) DefaultValue::where('name','profit')->firstOrFail()->value;
        
        $bonus_cost = $request->bonus / $b2g / $g2d ;
        $gems_cost = $request->gems / $g2d ;

        $cost_golden_offers_bonus = $request->golden_offers_number * Segmentation::findOrFail(1)->offerMaxBonus / $b2g / $g2d;
        $cost_golden_offers_gems = $request->golden_offers_number * Segmentation::findOrFail(1)->offerMaxGems / $g2d;

        $cost_silver_offers_bonus = $request->silver_offers_number * Segmentation::findOrFail(2)->offerMaxBonus / $b2g / $g2d;
        $cost_silver_offers_gems = $request->silver_offers_number * Segmentation::findOrFail(2)->offerMaxGems  / $g2d;

        $cost_bronze_offers_bonus = $request->bronze_offers_number * Segmentation::findOrFail(3)->offerMaxBonus / $b2g / $g2d;
        $cost_bronze_offers_gems = $request->bronze_offers_number * Segmentation::findOrFail(3)->offerMaxGems  / $g2d;

        $cost_new_offers_bonus = $request->new_offers_number * Segmentation::findOrFail(4)->offerMaxBonus / $b2g / $g2d;
        $cost_new_offers_gems = $request->new_offers_number * Segmentation::findOrFail(4)->offerMaxGems  / $g2d;

        $cost = $bonus_cost + $gems_cost + $cost_golden_offers_bonus + $cost_golden_offers_gems + $cost_silver_offers_bonus + $cost_silver_offers_gems + $cost_bronze_offers_bonus + $cost_bronze_offers_gems + $cost_new_offers_bonus + $cost_new_offers_gems;
        $price = $cost + ($cost * $profit);
        $request->merge(['price'=>$price]);

        $bundle = Bundle::create($request->all());
        return response()->json(['message' => 'bundle ' . $bundle->name . ' added successfully !'],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Bundle::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['string'],
            'price' => ['numeric'],
            'bonus' => ['numeric'],
            'gems' => ['numeric'],
            'expiration_period' => ['numeric'],
            'golden_offers_number' => ['numeric'],
            'silver_offers_number' => ['numeric'],
            'bronze_offers_number' => ['numeric'],
            'new_offers_number' => ['numeric']
        ]);
        $bundle = Bundle::findOrFail($id);
        $bundle->update($request->all());
        return response()->json(['message' => $bundle->name . ' updated successfully !']);
    }


    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);
        $bundle->delete();
        return response()->json(['message'=>"The Bundle $bundle->name is Deleted"]);
    }

}

