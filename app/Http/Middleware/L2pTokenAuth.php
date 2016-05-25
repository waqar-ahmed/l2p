<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class L2pTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        if(!Auth::check()) {
            echo  'unauthorized';
            return redirect('/');
        }
        return $next($request);
    }
}
