<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register the new user to the system using e-mail or phone number
     * 
     * @param Request $request
     * @return App\Models\User
    */
    public static function register(Request $request)
    {
        $request->validate([
            //required email | phone number
            'phone_number'=>['required_without:email','string'],
            'email'=>['required_without:phone_number','string'],
            'password'=>['required','string'],
            'fname' =>['required','string'],
            'lname' => ['reuired','string'],
            'role_id'=>['reuired','integer'],
        ]);
        return User::create($request->all());
    }

    /**
     * Login the user to app using e-mail.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function loginByEmail(Request $request)
    {
        // dd("hi there");
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        #check email
        $user = User::where('email', $request->email)->firstOrFail();
        #check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Bad request'
            ], 401);
        }

        $token = $user->createToken('LoyaltyPointsExchangeSystemToken')->plainTextToken;
        $content = array_merge($user->toArray(),['token' => $token]);
        $response = response()->json($content, 201);

        return $response;
    }

    /**
     * Login the user to app using phone number.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function loginByPhoneNumber(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required|string',
            'password' => 'required|string'
        ]);
        
        #check phone number
        $user = User::where('phone_number', $request->phone_number)->firstOrFail();
        #check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Bad request'
            ], 401);
        }

        $token = $user->createToken('LoyaltyPointsExchangeSystemToken')->plainTextToken;
        $content = array_merge($user->toArray(),['token' => $token]);
        $response = response()->json($content, 201);

        return $response;
    }

}
