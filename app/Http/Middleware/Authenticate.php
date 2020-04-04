<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

use App\Traits\LoginHandler;

class Authenticate extends Middleware
{
    use LoginHandler;

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        
        $user = $request->user();
        $token = $this->calcLoginToken($user, $request->ip());
        
        if ($this->getTokenWithoutTimestamp($user->lock_token) !== $this->getTokenWithoutTimestamp($token)) {
            auth()->guard()->logout();
            $request->session()->invalidate();
            
            throw new AuthenticationException(
                'Unauthenticated.', $guards, $this->redirectTo($request)
            );
        }

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
    
}
