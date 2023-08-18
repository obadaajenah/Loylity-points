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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function setGemsValue(Request $request){
       // GemsTransfer::create([
         //  'value'=> $request->value

        //]);

        $request->Value ;





//        }




    }


    public function setBonusValue(){}



    public function modfiy(Request $request ,$id ){



    $set= RequestsPartner::find($id);
     if($set->stutes=='0' || $set->states=='null'){

      if($request->status =='accept'){

      $re= RequestsPartner::find($id);

       $user=user::find($re->user_id);
       $partner=partner::create([
        'user_id'=>$user->id,
     ]);
     $user->update(['role_id'=>2]);
     $TT=RequestsPartner::find($id);
     $TT->update(['status' => 1]);
     return response()->json(['message'=>"Gongrats we add new partner"]);

       } elseif($request->status =='reject'){

        $TT=RequestsPartner::find($id);
        $TT->update(['status' => 0]);

        return response()->json(['message'=>"we did it",]);
       }

    }
       return response()->json(['message'=>'we decided before']);
    }

   public function serch_partner(){


   }



  public function  changePassword(ChangePassRequest $request){
    //if (Auth::check()) {
    $user_id =   Auth::user()->id ;
   //$user_id = auth()->user()->id;
    $user = User::find($user_id);

    if (Hash::check($request->oldPassword, $user->password)) {
        if ($request->newPassword == $request->oldPassword) {
            return response()->json(['message' => ['new password  match old password ']], 450);
        }
        if ($request->newPassword != $request->confirmation_password) {
            return response()->json(['message' => ['new password not match confirmation password']], 450);
        }

        $user->password = bcrypt($request->newPassword);
        $user->save();
        return response()->json(['message' => ['password changed successfully']]);
    } else {
        return response()->json(['message' => ['old password not match ']], 450);
    }
// } else {
//     // Handle the case when the user is not authenticated
//     return response()->json(['message' => ['you are not allowed to change the password']]);
// }

}
 public function sort_partner($sort_by){
    $par=partner::get()->sortBy($sort_by);
    return response()->json(['message'=>'The partner is sort',$par]) ;
    }

    public function search_user($fname){
        $part=user::where('fname','like','%'.$fname.'%')->get();
        return response()->json([$part]);
    }




}
