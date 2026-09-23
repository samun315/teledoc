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

        // Only set CSP when directives are configured (empty header hurts Best Practices)
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

        if (!empty($cspPolicy)) {
            $response->headers->set('Content-Security-Policy', implode('; ', $cspPolicy));
        }

        // Security headers that help Best Practices without changing behavior
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }

}
