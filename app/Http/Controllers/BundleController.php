<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;
use App\Http\Requests\BundleRequest;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Bundle::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BundleRequest $request)

    {

        $bundle = Bundle::create($request->all());
        return response()->json(['message' => 'bundle ' . $bundle->name . ' added successfully !'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function show(Bundle $bundle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bundle $bundle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bundle  $bundle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bundle $bundle)
    {
        //
    }
}
