<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestCookie = $request->cookie();

        if (empty($requestCookie)) {
            return response()->json(["error" => "unauthorized"], 401);
        }

        if (strtotime($requestCookie["expires"]) < time()) {
            return response()->json(["error" => "invalid session"], 401);
        }

        $request->attributes->set("requesterId", $requestCookie["session"]);

        return $next($request);
    }
}
