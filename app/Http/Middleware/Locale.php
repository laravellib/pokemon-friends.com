<?php namespace obsession\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use obsession\Infrastructure\Interfaces\Domain\Locale\LocalesInterface;

class Locale
{

    /**
     * The available languages.
     *
     * @array $languages
     */
    protected $languages = LocalesInterface::LOCALES;

    /**
     * Handle current locale.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('locale')) {
            Session::put('locale', LocalesInterface::DEFAULT_LOCALE);
        }

        app()->setLocale(Session::get('locale'));

        return $next($request);
    }
}
