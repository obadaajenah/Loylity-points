<?php

namespace App\Http\Controllers;

use App\Models\RequestsPartner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myrequests()
    {
        $user = Auth::user();
        $rps = RequestsPartner::where('user_id',$user->id)->get();
        return response()->json(['user'=>$user,'requests'=>$rps]);
    }

    public function pendingRequests(){
        $rps = RequestsPartner::where('status',null)->get();
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
            'phone_number'=>['string','unique:users'],
            'email'=>['required','string','email'],
            'password'=>['required','string','min:8','confirmed'],
            'fname' =>['required','string'],
            'lname' => ['string'],
            'image' => ['image'],
            'details'=>['string']
        ]);

        if($u = User::firstWhere('email',$request['email'])){
            if($r = RequestsPartner::where('user_id',$u->id)->latest('id')->first()){
                if($r->status == 1 || $u->role_id == 2){
                    return response()->json(['message'=>'you are a partner now !'],400);
                }else if($r->status === null){
                    return response()->json(['message'=>'your request is pending'],400);
                }else{
                    $request["role_id"] = 4;
                    $request->merge([
                        'user_id' => $u->id,
                    ]);
                    $u->fname = $request->fname;
                    $u->lname = $request->lname;
                    $u->phone_number = $request->phone_number;
                    $u->save();
                    RequestsPartner::create($request->all());
                    return response()->json(['message'=>'your request submitted with old password , wish you the best this time !'],200);
                }
            }else{
                $request["role_id"] = 4;
                $request->merge([
                    'user_id' => $u->id,
                ]);
                $u->fname = $request->fname;
                $u->lname = $request->lname;
                $u->phone_number = $request->phone_number;
                $u->save();
                RequestsPartner::create($request->all());
                return response()->json(['message'=>'your request submitted with old password , wish you the best this time !'],200);
            }
        }else{
            $request["role_id"] = 4;
            $content = AuthController::register($request);
            $request->merge([
                'user_id' => $content["id"],
            ]);
            RequestsPartner::create($request->all());
            return response()->json(['message'=>'your request submitted successfully !','token'=>$content['token']]);
        }
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
            'phone_number'=>['string','unique:users'],
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
            if($rp->status === null){
                if ($request->image && !is_string($request->image)) {
                    $photo = $request->image;
                    $newPhoto = time() . $photo->getClientOriginalName();
                    $photo->move('uploads/users', $newPhoto);
                    $request["img_url"] = 'uploads/users/' . $newPhoto;
                }
                $rp->update($request->all());
                $user = User::findOrFail($user->id);
                $user->update($request->all());
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json(['message' => 'your info updated successfully !']);
            }else {
                return response()->json(['message'=>'you can\'t update after confirmation !'],400);
            }
        }else {
            return response()->json(['message'=> 'you don\'t have a permission !'],401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = Auth::user()->id;
        $rp = RequestsPartner::findOrFail($id);
        $pending = User::findOrFail($user_id);

        if($rp->status != null){return response()->json(['message'=>'you can\'t delete your request !']);}

        if($rp->user_id == $pending->id){
            $rp->delete();
            return response()->json(['message'=>'your request deleted successfully !']);
        }
        else{
            return response()->json(['message'=>'you aren\'t authorized !'],401);
        }
    }
}
