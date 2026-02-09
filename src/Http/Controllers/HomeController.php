<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class HomeController
{
    public function __invoke()
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $connectionDetails = \DB::getConfig();

        return view('database-gui::home', compact('tables', 'connectionDetails'));
    }
}
