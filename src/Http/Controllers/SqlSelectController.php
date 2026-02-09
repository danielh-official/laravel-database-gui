<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class SqlSelectController
{
    public function __invoke(\Illuminate\Http\Request $request)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $query = $request->input('query');

        if (empty($query)) {
            $query = '';
            $results = [];

            // @phpstan-ignore-next-line
            return view('database-gui::sql.select', compact('tables', 'query', 'results'));
        }

        if ($this->isNotSelectStatement($query)) {
            $error = 'Only SELECT statements are allowed.';

            // @phpstan-ignore-next-line
            return view('database-gui::sql.select', compact('tables', 'query', 'error'));
        }

        $request->validate([
            'query' => 'string',
        ]);

        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $start = microtime(true);

        try {
            $results = \DB::select($query);
        } catch (\Exception $e) {
            $error = $e->getMessage();

            // @phpstan-ignore-next-line
            return view('database-gui::sql.select', compact('tables', 'query', 'error'));
        }

        $end = microtime(true);

        $timeToResult = ($end - $start) * 1000;

        // @phpstan-ignore-next-line
        return view('database-gui::sql.select', compact('tables', 'query', 'results', 'timeToResult'));
    }

    private function isNotSelectStatement(string $query): bool
    {
        return ! str_starts_with(strtolower(trim($query)), 'select');
    }
}
