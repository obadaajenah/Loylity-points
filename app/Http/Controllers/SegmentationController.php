<?php

namespace App\Http\Controllers;

use App\Models\Segmentation;
use Illuminate\Http\Request;

class SegmentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Segmentation::all();
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
            'offerMaxGems' => ['required' , 'numeric'],
            'offerMaxBonus' => ['required' , 'numeric'],
            'period' => ['required','numeric'], 
            'gems' => ['required','numeric'], 
            'relation' => ['required','in:0,1']// if true => relation is AND , if false => relation is OR
        ]);

        $segmentation = Segmentation::findOrFail($id);

        $segmentation->update(['offerMaxGems' => $request->offerMaxGems]);
        $segmentation->update(['offerMaxBonus' => $request->offerMaxBonus]);

        if($id == 4) {return response()->json(['message'=>'you can\'t update the new segmentation !'],400);}

        $segmentation->update($request->all());
        return response()->json(['message'=>$segmentation->name . ' updaetd successfully!']);
    }
}
