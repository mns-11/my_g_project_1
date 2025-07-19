<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    protected $supportedLocales = ['en', 'ar'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->header('Accept-Language');


        if(str_contains($request->path(), 'admin')) {
            $settings = Setting::getAllSettings();
            $currentLocale = $settings['language'];
        }else{
            if(!empty($locale) and in_array($locale, $this->supportedLocales)) {
                $currentLocale = $locale;
            }else{
                $currentLocale = LaravelLocalization::getCurrentLocale();
            }
        }


        LaravelLocalization::setLocale($currentLocale);

        return $next($request);
    }
}
