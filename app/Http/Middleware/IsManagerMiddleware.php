<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsManagerMiddleware
{
    public function handle(Request $request, Closure $next, string ...$guards): Response|string
    {



        if(route_name() == 'manager_login') {

            if(session()->get('m')) {
                return redirect(route('cabinet_manager'));
            }
            return $next($request);


        }

        if(session()->get('m')) {
            return $next($request);
        }


        return redirect(route('manager_login'));



    }
}
