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
            foreach(explode(",", $request->server('HTTP_ACCEPT_LANGUAGE')) as $lang) {
                $localefirstletters = substr($lang, 0, 2);
                $locale = Locale::where('id', 'like', $localefirstletters.'%')->first();
                if(isset($locale)) {
                    break;
                }
            }
            if(!isset($locale)) {
                logger("Unknown browser locale: ".$request->server('HTTP_ACCEPT_LANGUAGE'));
                $locale = Locale::find('en_US');
            }
            \App::setLocale($locale->id);
            setlocale(LC_TIME, $locale->id);
        }

        return $next($request);
    }
}
