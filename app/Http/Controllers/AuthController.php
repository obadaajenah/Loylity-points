<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

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
            //required email OR phone number
            'phone_number' => ['required_without:email','string','unique:users'],
            'email' => ['required_without:phone_number','string','unique:users','email'],
            'password' => ['required','string','min:8','confirmed'],
            'role_id' => ['required','numeric','digits_between:1,4'],
            'fname' => ['required','string'],
            'lname' => ['required','string'],
            'image' => ['image']
        ]);

        if ($request->image && !is_string($request->image)) {
            $photo = $request->image;
            $newPhoto = time() . $photo->getClientOriginalName();
            $photo->move('uploads/users', $newPhoto);
            $request["img_url"] = 'uploads/users/' . $newPhoto;
        }
        
        $user = User::create($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('LoyaltyPointsExchangeSystemToken')->plainTextToken;
        $response = array_merge($user->toArray(),['token' => $token]);
        return $response;
    }

    /**
     * Login the user to app using e-mail.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function loginByEmail(Request $request)
    {
        $this->validate($request, [
            'email' => ['required','string','email'],
            'password' => ['required','string','min:8']
        ]);

        #check email
        $user = User::where('email', $request->email)->first();
        #check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Bad request'
            ], 400);
        }

        $token = $user->createToken('LoyaltyPointsExchangeSystemToken')->plainTextToken;
        $content = array_merge($user->toArray(),['token' => $token,'role' => Role::find($user->role_id)->name]);
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
        $request->validate( [
            'phone_number' => ['required','string'],
            'password' => ['required','string','min:8']
        ]);
        
        #check phone number
        $user = User::where('phone_number', $request->phone_number)->first();
        #check password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Bad request'
            ], 400);
        }

        $token = $user->createToken('LoyaltyPointsExchangeSystemToken')->plainTextToken;
        $content = array_merge($user->toArray(),['token' => $token,'role' => Role::find($user->role_id)->name]);
        $response = response()->json($content, 201);

        return $response;
    }

    /**
     * Logout the user from app.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $auth = Auth::user();
        if ($auth) {
            // Revoke the token that was used to authenticate the current request...
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logged out'
            ], 200);
        } else {
            return response()->json(['message' => 'Bad request']);
        }
    }

    /**
     * Logout the user from all devices.
     *
     * @return \Illuminate\Http\Response
     */
    public function logoutAll()
    {
        $auth = Auth::user();
        if ($auth) {
            $user = User::find($auth->id);
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Logged out from all devices'
            ], 200);
        } else {
            return response()->json(['message' => 'Bad request']);
        }
    }
}
