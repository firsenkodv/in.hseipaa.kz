<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAnyMiddleware
{
    public function handle(Request $request, Closure $next): Response|string
    {
        if (auth()->check() || session()->get('r') || session()->get('m')) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
