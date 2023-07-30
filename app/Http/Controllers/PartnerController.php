<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = Partner::all();
        $res = [];$i=0;
        foreach($partners as $p){
            $res[$i]["fname"] = $p->user["fname"];
            $res[$i]["lname"] = $p->user["lname"];
            $res[$i]["email"] = $p->user["email"];
            $res[$i]["phone_number"] = $p->user["phone_number"];
            $res[$i]["img_url"] = $p->user["img_url"];
            $res[$i]["offer"] = $p->offer;
            $res[$i]["PartnerBundle"] = $p->PartnerBundle;
            $i++;
        }
        return $res;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexName()
    {
        // return User::where('role_id',2)->get('fname');
        $ps = Partner::all();
        $res =[];
        foreach($ps as $p){
            $res = array_merge($res,[$p->user["fname"] . ' ' . $p->user["lname"]]);
        }
        return $res;
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
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $partner = Partner::firstWhere('user_id',Auth::user()->id);
        $partner->User;
        $partner->Offer;
        $partner->PartnerBundle;
        return $partner;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'phone_number'=>['string','unique:users','digits_between:9,12'],
            'email'=>['string','unqiue:users','email'],
            'password'=>['string','min:8'],
                'fname' =>['string'],
                'lname' => ['string'],
                'image' => ['image'],
        ]);
    
        if ($request->image && !is_string($request->image)) {
            $photo = $request->image;
            $newPhoto = time() . $photo->getClientOriginalName();
            $photo->move('uploads/users', $newPhoto);
            $request["img_url"] = 'uploads/users/' . $newPhoto;
        }
        $partner = Partner::firstWhere('user_id',Auth::user()->id);
        $partner->update($request->all());
        $user = User::findOrFail(Auth::user()->id);
        $user->update($request->all());
        return response()->json(['message' => 'Your profile updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Partner  $partner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Partner $partner)
    {
        //
    }
}
