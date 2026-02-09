<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class SqlController
{
    public function __invoke(\Illuminate\Http\Request $request)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        if (empty($request->input('query'))) {
            $query = '';
            $results = [];

            // @phpstan-ignore-next-line
            return view('database-gui::sql', compact('tables', 'query', 'results'));
        }

        $request->validate([
            'query' => 'string',
        ]);

        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $query = $request->input('query');

        $start = microtime(true);

        try {
            $results = \DB::select($query);
        } catch (\Exception $e) {
            $error = $e->getMessage();

            // @phpstan-ignore-next-line
            return view('database-gui::sql', compact('tables', 'query', 'error'));
        }

        $end = microtime(true);

        $timeToResult = ($end - $start) * 1000;

        // @phpstan-ignore-next-line
        return view('database-gui::sql', compact('tables', 'query', 'results', 'timeToResult'));
    }
}
