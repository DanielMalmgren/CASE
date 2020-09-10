<?php

namespace App\Http\Middleware;

use Closure;

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
        } else {
            $browserlocale = str_replace('-', '_', substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 5));
            if($browserlocale == 'en_GB') {
                $browserlocale = 'en_US';
            }
            \App::setLocale($browserlocale);
        }

        return $next($request);
    }
}
