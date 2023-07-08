<?php

namespace App\Http\Controllers;

use App\Models\RequestsPartner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestsPartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rps = RequestsPartner::all();
        foreach($rps as $rp){$rp->user;}
        return $rps;
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
            'phone_number'=>['string','unique:users','digits_between:9,12'],
            'email'=>['required','string','unique:users','email'],
            'password'=>['required','string','min:8','confirmed'],
            'fname' =>['required','string'],
            'lname' => ['string'],
            'image' => ['image'],
            'details'=>['string']
        ]);

        if ($request->image && !is_string($request->image)) {
            $photo = $request->image;
            $newPhoto = time() . $photo->getClientOriginalName();
            $photo->move('uploads/users', $newPhoto);
            $request["img_url"] = 'uploads/partners/' . $newPhoto;
        }

        $request["role_id"] = 4;
        $content = AuthController::register($request);
        $request->merge([
            'user_id' => $content["id"],
        ]);
        RequestsPartner::create($request->all());
        return response()->json(['message'=>'your request submitted successfully !']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rp = RequestsPartner::findOrFail($id);
        $rp->user;
        return $rp;
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
            'phone_number'=>['string','unique:users','digits_between:9,12'],
            'email'=>['string','unique:users','email'],
            'password'=>['string','min:8','confirmed'],
            'fname' =>['string'],
            'lname' => ['string'],
            'image' => ['image'],
            'details'=>['string']
        ]);
        
        $user = Auth::user();
        $rp = RequestsPartner::findOrFail($id);
        if($rp->user_id == $user->id){
            if ($request->image && !is_string($request->image)) {
                $photo = $request->image;
                $newPhoto = time() . $photo->getClientOriginalName();
                $photo->move('uploads/users', $newPhoto);
                $request["img_url"] = 'uploads/partners/' . $newPhoto;
            }
        $rp->update($request->all());
        User::findOrFail($user->id)->update($request->all());
        return response()->json(['message' => 'your info updated successfully !']);
        }else {
            return response()->json(['message'=> 'you don\'t have a permission !']);
        }
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
