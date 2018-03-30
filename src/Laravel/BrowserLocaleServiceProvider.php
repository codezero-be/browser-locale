<?php

namespace CodeZero\BrowserLocale\Laravel;

use CodeZero\BrowserLocale\BrowserLocale;
use Illuminate\Support\ServiceProvider;
use Request;

class BrowserLocaleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBrowserLocale();
    }

    /**
     * Register BrowserLocale.
     *
     * @return void
     */
    protected function registerBrowserLocale()
    {
        $this->app->bind(BrowserLocale::class, function () {
            return new BrowserLocale(
                Request::server('HTTP_ACCEPT_LANGUAGE')
            );
        });
    }
}
