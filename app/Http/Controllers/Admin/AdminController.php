<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\User;
use App\Models\BonusTransfer;
use App\Models\GemsTransfer;
use App\Http\Controllers\Controller;
use App\Models\RequestsPartner;
use App\Http\Requests\ChangePassRequest;
use App\Models\CommandHistory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function modfiy(Request $request , $id){
        $request->validate([
            'status' => ['required','in:0,1']
        ]);

        $rp = RequestsPartner::findOrFail($id);

        if($rp->status !== null){return response()->json(['message'=>'you can\'t modify this request !'],400);}

        #Reject Case :
        if($request->status == 0){
            $rp->update(['status'=>$request->status]);
            return response()->json(['message'=>'Request Partner of ' . $rp->user->fname . " " . $rp->user->lname . ' rejected !'],200);

        #Accept Case :
        }else if($request->status == 1){
            $rp->update(['status'=>$request->status]);
            User::findOrFail($rp->user->id)->update(['role_id'=>2]);
            Partner::create(['user_id' => $rp->user->id]);
            return response()->json(['message'=>'Request Partner of ' . $rp->user->fname . " " . $rp->user->lname . ' accepted !'],200);
        }
    }

    public function changePassword(ChangePassRequest $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);

        if (Hash::check($request->oldPassword, $user->password)) {
            if ($request->newPassword == $request->oldPassword) {
                return response()->json(['message' => 'new password match old password !'], 400);
            }
            if ($request->newPassword != $request->confirmation_password) {
                return response()->json(['message' => 'new password not match confirmation password'], 400);
            }
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return response()->json(['message' => 'password changed successfully'],200);
        } else {
            return response()->json(['message' => 'old password not match '], 400);
        }
    }

    public function sort_partner($sort_by)
    {
        $par = partner::get()->sortBy($sort_by);
        return response()->json(['message' => 'The partner is sort', $par]);
    }

    public function search_user($fname)
    {
        $part = user::where('fname', 'like', '%' . $fname . '%')->get();
        return response()->json([$part]);
    }

    public function commands(){
        return CommandHistory::all();
    }
}
