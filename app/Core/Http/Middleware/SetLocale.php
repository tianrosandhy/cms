<?php
namespace App\Core\Http\Middleware;

use App;
use Closure;
use Autocrud;

class SetLocale
{

    public function handle($request, Closure $next)
    {
        $lang = session('lang', Autocrud::defaultLang());
        App::setLocale($lang);
        session(['lang' => $lang]);

        return $next($request);
    }
}
