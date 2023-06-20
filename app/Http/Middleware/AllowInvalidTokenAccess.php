<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;

class AllowInvalidTokenAccess extends Authenticate
{
    public function handle($request, Closure $next, ...$guards)
    {
        // Check if the request has a valid bearer token
        if ($request->bearerToken()) {
            // Validate the token and retrieve the user
            $this->authenticate($request, $guards);
        }

        // Allow the request to proceed even if the token is not valid
        return $next($request);
    }
}