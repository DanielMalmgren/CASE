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
        if(isset($request->lang)) {
            $locale = Locale::find($request->lang);
            $request->session()->put('locale', $locale->id);
        } elseif($request->session()->has('locale')) {
            $session_locale = $request->session()->get('locale');
            $locale = Locale::where('id', $session_locale)->first();
        } else {
            $geoip = geoip()->getLocation($request->ip);
            $iso_code=$geoip->iso_code;
            if($iso_code == 'GB') {
                $iso_code = 'US';
            }
            $locale = Locale::where('id', 'like', '%'.$iso_code)->first();
            if(isset($locale)) {
                $request->session()->put('locale', $locale->id);
            }
        }

        if(!isset($locale)) {
            $locale = Locale::find('en_US');
        }

        \App::setLocale($locale->id);
        setlocale(LC_TIME, $locale->id);

        /*$user = \Auth::user();
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
        }*/

        return $next($request);
    }
}
