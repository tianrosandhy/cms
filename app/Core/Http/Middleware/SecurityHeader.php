<?php
namespace App\Core\Http\Middleware;

use Closure;

class SecurityHeader
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'sameorigin');
        $response->headers->set('X-Xss-Protection', '1; mode=block');
        $response->headers->set('Content-Security-Policy', "default-src 'self' https:; img-src 'self' data: https: blob: http:; style-src 'self' 'unsafe-inline' https:; font-src data: 'self' http: https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; connect-src 'self' https: blob:");
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');
        $response->headers->set('Feature-Policy', "fullscreen *, payment 'none' ");
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('X-Powered-By', 'TianRosandhy');

        return $response;
    }
}
