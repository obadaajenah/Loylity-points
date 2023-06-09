<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        foreach($customers as $c) {$c->user; $c->segmentation;}
        return $customers;
    }

    /**
     * Register a newly created customer in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $request->validate([
            'fname' => ['required', 'string'],
            'lname' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'unique:users','digits_between:9,12'],
            'email'=>['string', 'unique:users' ,'email'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
            'nickName' => ['string'],
            'image' => ['image']
        ]);
        $request->merge(['role_id' => 3]);
        $content = AuthController::register($request);
        Customer::create([
            'user_id'=>$content["id"],
            'nickName'=>$request["nickName"],
            'segmentation_id' => 4,
        ]);
        return response()->json(['token' => $content['token'], 'message' => $content['fname'].' account added successfully!'],201);
    }

    /**
     * Display the specified customer profile.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(Auth::user()){
            $user = Customer::where('user_id',Auth::user()->id)->first();
            $user->User;
            $user->Segmentation;
            return $user;
        }else{
            return response()->json(['message' => 'unAuthorized !']);
        }
    }

    /**
     * Update the specified customer profile details.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()){
            $id = Auth::user()->id;
            $request->validate([
                'phone_number'=>['string','unique:users','digits_between:9,12'],
                'email'=>['string','unqiue:users','email'],
                'password'=>['string','min:8'],
                'fname' =>['string'],
                'lname' => ['string'],
                'image' => ['image'],
                'nickName' => ['string'],
                ]);
    
            if ($request->image && !is_string($request->image)) {
                $photo = $request->image;
                $newPhoto = time() . $photo->getClientOriginalName();
                $photo->move('uploads/users', $newPhoto);
                $request["img_url"] = 'uploads/users/' . $newPhoto;
            }
            $customer = Customer::where('user_id',$id)->firstOrFail();
            $customer->update($request->all());
            $user = User::findOrFail($id);
            $user->update($request->all());
            return response()->json(['message' => 'Your profile updated successfully!']);
        }else{
            return response()->json(['message' => 'unAuthorized !']);
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
