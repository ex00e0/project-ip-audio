<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckIsPerformer
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
        
        if (Auth::user() != null) {
            $isAdmin = false;

            $user = DB::table('users')->where('id', '=', Auth::user()->id)->get();
            $role = $user[0]->role;
            
            if($role == 'performer')
            {
                $isAdmin = true;
            }
            if($isAdmin == false){
                return redirect()->route('/');
            }
        }
        return $next($request);
    }
}