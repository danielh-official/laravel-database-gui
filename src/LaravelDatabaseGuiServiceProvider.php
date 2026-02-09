<?php

namespace DanielHOfficial\LaravelDatabaseGui;

use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\ExportSqlResultsController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\HomeController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\SqlController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableDataController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableInfoController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableStructureController;
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

    public function packageRegistered()
    {
        $macro = config('database-gui.macro', 'db');
        $baseUrl = config('database-gui.base_path', 'db');

        Route::macro($macro, function () use ($baseUrl) {
            Route::name("$baseUrl.")->prefix($baseUrl)->group(function () {
                Route::get('/', HomeController::class)->name('home');

                Route::get('sql', SqlController::class)->name('sql');

                Route::post('sql/results/export', ExportSqlResultsController::class)->name('sql.results.export');

                Route::name('table.')->prefix('/table/{table}')->group(function () {
                    Route::resource('data', TableDataController::class)->parameters([
                        'data' => 'id',
                    ]);

                    Route::get('/structure', TableStructureController::class)->name('structure');

                    Route::get('/info', TableInfoController::class)->name('info');
                });
            });

        });
    }

    public function register()
    {
        parent::register();

        if (file_exists($file = __DIR__.'/helpers.php')) {
            require_once $file;
        }
    }
}
