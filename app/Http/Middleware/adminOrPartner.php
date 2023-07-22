<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminOrPartner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()){
            $user = Auth::user();
            if($user->role_id == 1 || $user->role_id == 2){            
                return $next($request);
            }else{
                return response()->json(['message' => 'you are not admin or partner!'],401);
            }
        }else{
            return response()->json(['message' => 'unAuthorized!'],401);
        }
    }
}
