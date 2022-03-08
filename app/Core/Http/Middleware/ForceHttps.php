<?php
namespace App\Core\Http\Middleware;

use Closure;

class ForceHttps
{

    public function handle($request, Closure $next)
    {
        if (!$request->secure() && config('cms.config.force_https')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
