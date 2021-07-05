<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\UserToken;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

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
        $uri = $request->getRequestUri();
        $parts = explode('/', $uri);
        $token = $parts[2];
        $email = $parts[3];
        $event = $parts[4];
        if ($token && $email && $event) {
            if (!Auth::user()) {
                // find user by its token and log the user in.
                $jubileum = UserToken::findByToken($token, $email, $event);
                if ($jubileum) {
                    $user = User::find($jubileum->user_id);
                    Auth::login($user);
                } else {
                    return Response('Unautorized.', 401);
                }
            } else {
                return redirect('Unautorized.', 401);
            }

        } else {
            return redirect('Unautorized.', 401);
        }
        return $next($request);
    }
}