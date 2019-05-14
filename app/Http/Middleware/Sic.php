<?php

namespace App\Http\Middleware;

use Closure;

class Sic
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
        if($request->get('token') && $request->get('token') == 'mpJp33xvxzw2TyF6w55vxTHG') {
            return $next($request);
        } else {
            return abort(401);
        }
    }
}
