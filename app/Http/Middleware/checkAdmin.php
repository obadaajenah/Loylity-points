<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkAdmin
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
            dd($user->role_id);
            if($user->role_id == 1){            
                return $next($request);
            }else{
                return response()->json(['message' => 'You are not admin!'],401);
            }
        }else{
            return response()->json(['message' => 'unAuthorized!'],401);
        }
    }
}
