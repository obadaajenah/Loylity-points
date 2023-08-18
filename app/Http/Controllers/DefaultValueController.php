<?php

namespace App\Http\Controllers;

use App\Models\DefaultValue;
use Illuminate\Http\Request;

class DefaultValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DefaultValue::all();
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
            'name' => ['required','string','unique:default_values,name'],
            'value' => ['required','string']
        ]);

        DefaultValue::create($request->all());

        return response()->json(['message' => 'Default value added successfully !']);
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
            'name' => ['string'],
            'value' => ['string']
        ]);

        DefaultValue::findOrFail($id)->update($request->all());

        return response()->json(['message'=>'Default value updated successfully !']);
    }

}
