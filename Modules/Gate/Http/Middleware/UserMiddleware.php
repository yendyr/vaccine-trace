<?php

namespace Modules\Gate\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        //role 1 -
        if (Auth::user()->role == null){
            return $next($request);
        }
        if (Auth::user()->role == 1){
            return redirect('/gate/user/');
        }
    }
}
