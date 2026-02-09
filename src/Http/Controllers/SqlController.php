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

            return view('database-gui::sql', compact('tables', 'query', 'results'));
        }

        $request->validate([
            'query' => 'string',
        ]);

        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $query = $request->input('query');

        try {
            $results = \DB::select($query);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['query' => $e->getMessage()]);
        }

        return view('database-gui::sql', compact('tables', 'query', 'results'));
    }
}
