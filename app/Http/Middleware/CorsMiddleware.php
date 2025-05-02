<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Add CORS headers
        $response->headers->set('Access-Control-Allow-Origin', '*'); // Allow all origins (or specify your Flutter app's origin)
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); // Allow specific HTTP methods
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization'); // Allow specific headers

        return $response;
    }
}
