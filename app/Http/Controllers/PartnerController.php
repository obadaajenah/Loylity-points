<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PartnerBundle;
use Illuminate\Support\Facades\Hash;

class PartnerController extends Controller
{

    public function indexAdmin(){
        $partners = Partner::all();
        foreach($partners as $p){$p->user;$p->user->BonusTransferSender;$p->user->BonusTransferReceiver;$p->user->GemsTransferSender;$p->user->GemsTransferReceiver;$p->offer;$p->PartnerBundle;}
        return $partners;
    }

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
            if(PartnerBundle::where('partner_id',$p->id)->where('status',1)->first()){
                $res[$i]["fname"] = $p->user["fname"];
                $res[$i]["lname"] = $p->user["lname"];
                $res[$i]["email"] = $p->user["email"];
                $res[$i]["phone_number"] = $p->user["phone_number"];
                $res[$i]["img_url"] = $p->user["img_url"];
                $res[$i]["offer"] = $p->offer;
                $res[$i]["PartnerBundle"] = $p->PartnerBundle;
                $i++;
            }
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
        $ps = Partner::all();
        $res =[];
        foreach($ps as $p){
            if(PartnerBundle::where('partner_id',$p->id)->where('status',1)->first()){
                $res = array_merge($res,[$p->user["fname"] . ' ' . $p->user["lname"]]);
            }
        }
        return $res;
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
        return response()->json(['partner'=>$partner,'offers'=>$partner->Offer,'partner_bundle'=>$partner->PartnerBundle]);
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
            'phone_number'=>['string','unique:users'],
            'email'=>['string','unique:users','email'],
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
        if($request->password){
            $user->password = Hash::make($request->password);
            $user->save();
        }
        return response()->json(['message' => 'Your profile updated successfully!']);
    }
}
