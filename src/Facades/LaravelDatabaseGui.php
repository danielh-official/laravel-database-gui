<?php

namespace DanielHOfficial\LaravelDatabaseGui\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DanielHOfficial\LaravelDatabaseGui\LaravelDatabaseGui
 */
class LaravelDatabaseGui extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DanielHOfficial\LaravelDatabaseGui\LaravelDatabaseGui::class;
    }
}
