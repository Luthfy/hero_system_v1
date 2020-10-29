<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;

class CheckForAllScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$scopes)
    {
        if (! $request->user() || ! $request->user()->token())
        {
            throw new AuthenticationException;
        }

        return response( array( "message" => "Not Authorized." ), 403 );
    }
}
