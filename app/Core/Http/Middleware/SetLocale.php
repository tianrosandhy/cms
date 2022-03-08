<?php
namespace App\Core\Http\Middleware;

use App;
use Closure;
use Language;

class SetLocale
{

    public function handle($request, Closure $next)
    {
        $lang = session('lang', Language::default());
        App::setLocale($lang);
        session(['lang' => $lang]);

        return $next($request);
    }
}
