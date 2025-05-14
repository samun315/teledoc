<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class GenerateCSPNonce
{
    public function handle($request, Closure $next)
    {
        $nonce = base64_encode(random_bytes(16));
        View::share('cspNonce', $nonce);
        $response = $next($request);

        // Create the CSP policy string
        $cspPolicy = [
//            "default-src 'self'",
//            "script-src 'self' 'nonce-$nonce'",
//            "style-src 'self' 'nonce-$nonce' https://fonts.googleapis.com",
//            "font-src 'self' https://fonts.gstatic.com",
//            "img-src 'self' data:", // Allow data URIs for images (including SVGs)
//            "object-src 'none'",
//            "frame-src 'none'",
//            "base-uri 'self'"
        ];

        // Join the directives into a single CSP string
        $cspPolicyString = implode('; ', $cspPolicy);

        $response->headers->set('Content-Security-Policy', $cspPolicyString);

        return $response;
    }

}
