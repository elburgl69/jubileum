<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class JubileumTokens
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
        $token = $request->get('token', false);
        if ($token)
        {
            if (!Auth::user()) {
                // find user by its token and log the user in.
                Auth::login($user);
            }
            else {
                // Redirect to ???
                return redirect('home');
            }

        }
        return $next($request);
    }
}