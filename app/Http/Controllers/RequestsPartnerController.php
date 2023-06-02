<?php

namespace App\Http\Controllers;

use App\Models\RequestsPartner;
use Illuminate\Http\Request;

class RequestsPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RequestsPartner::all();
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestsPartner  $requestsPartner
     * @return \Illuminate\Http\Response
     */
    public function show(RequestsPartner $requestsPartner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestsPartner  $requestsPartner
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestsPartner $requestsPartner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestsPartner  $requestsPartner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestsPartner $requestsPartner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestsPartner  $requestsPartner
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestsPartner $requestsPartner)
    {
        //
    }
}
