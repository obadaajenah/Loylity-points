<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;
use App\Http\Requests\BundleRequest;
use App\Http\Requests\UpdateBundleRequest;

class BundleController extends Controller
{

    public function index()
    {
       return Bundle::all();
    }


    public function store(BundleRequest $request)
    {
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

