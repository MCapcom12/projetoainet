<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlock
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
        if (auth()->check() && auth()->user()->bloqueado) {
            auth()->logout();

            return redirect()->route('login')->withMessage('A sua conta está bloqueada, contacte um administrador!');
        }

        return $next($request);
    }
}
