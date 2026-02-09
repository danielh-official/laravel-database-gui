<?php

namespace DanielHOfficial\LaravelDatabaseGui;

use DanielHOfficial\LaravelDatabaseGui\Commands\LaravelDatabaseGuiCommand;
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
            ->hasViews()
            ->hasMigration('create_laravel_database_gui_table')
            ->hasCommand(LaravelDatabaseGuiCommand::class);
    }
}
