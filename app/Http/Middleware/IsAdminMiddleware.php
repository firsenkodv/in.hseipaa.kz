<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response|string
    {


        if(route_name() == 'admin_login') {

            if(session()->get('a')) {
                return redirect(route('cabinet_admin'));
            }
            return $next($request);


        }

        if(session()->get('a')) {
            session(['active_role' => 'admin']);
            return $next($request);
        }


        return redirect(route('admin_login'));



    }
}
