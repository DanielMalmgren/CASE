<?php

namespace App\Http\Middleware;

use Closure;
use App\Locale;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = \Auth::user();
        if(isset($user)) {
            \App::setLocale($user->locale_id);
            setlocale(LC_TIME, $user->locale_id);
        } else {
            $localefirstletters = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            $locale = Locale::where('id', 'like', $localefirstletters.'%')->first();
            \App::setLocale($locale->id);
            setlocale(LC_TIME, $locale->id);
        }

        return $next($request);
    }
}
