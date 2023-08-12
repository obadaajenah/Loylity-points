<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\RequestsPartner;

class AdminController extends Controller
{
    public function setGemsValue(Request $request){


    }


    public function setBonusValue(){}



    public function modfiy(Request $request ,$id ){



    $set= RequestsPartner::find($id);
     if($set->stutes=='0' || $set->states=='nul'){

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



}
