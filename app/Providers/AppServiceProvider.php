<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use App\View\Composers\NavbarComposer;
use App\Helpers\TranslatorHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register view composer for navbar to optimize database queries
        View::composer('layouts.app', NavbarComposer::class);

        // Register @t() Blade directive for Google Translate
        Blade::directive('t', function ($expression) {
            return "<?php echo \App\Helpers\TranslatorHelper::translate({$expression}, app()->getLocale()); ?>";
        });
    }
}
