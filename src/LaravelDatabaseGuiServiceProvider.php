<?php

namespace DanielHOfficial\LaravelDatabaseGui;

use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelDatabaseGuiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-database-gui')
            ->hasConfigFile()
            ->hasViews();
    }

    public function packageBooted(): void
    {
        if (! app()->environment('local')) {
            return;
        }

        if (config('database-gui.auto_register', true)) {
            $this->loadRoutesFrom(__DIR__.'/../routes/database-gui.php');
        }

        $macro = config('database-gui.route_macro');

        if (is_string($macro) && $macro !== '') {
            Route::macro($macro, function () {
                require __DIR__.'/../routes/database-gui.php';
            });
        }
    }

    public function register()
    {
        parent::register();

        if (file_exists($file = __DIR__.'/helpers.php')) {
            require_once $file;
        }
    }
}
