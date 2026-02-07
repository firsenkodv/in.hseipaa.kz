<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsROPMiddleware
{
    public function handle(Request $request, Closure $next): Response|string
    {


        if(route_name() == 'rop_login') {

            if(session()->get('r')) {
                return redirect(route('cabinet_rop'));
            }
            return $next($request);


        }

        if(session()->get('r')) {

            return $next($request);
        }


        return redirect(route('rop_login'));



    }
}
