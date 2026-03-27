<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsROPIsManagerMiddleware
{
    public function handle(Request $request, Closure $next): Response|string
    {
        if (session()->get('r') || session()->get('m')) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
