<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class HomeController
{
    public function __invoke()
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $connectionDetails = \DB::getConfig();

        // @phpstan-ignore-next-line
        return view('database-gui::home', compact('tables', 'connectionDetails'));
    }
}
