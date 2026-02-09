<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class TableDataController
{
    public function index(\Illuminate\Http\Request $request, string $table)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $columns = \DB::connection()->getSchemaBuilder()->getColumnListing($table);

        $currentPage = $request->input('page', 1);

        $query = \DB::table($table);

        $showSortForm = $request->input('show_sort_form', false);

        $sorts = collect($request->array('sort'));

        $sorts = $sorts->filter(fn ($value) => ! empty($value));

        foreach ($columns as $column) {
            if (isset($sorts[$column])) {
                $query->orderBy($column, $sorts[$column]);
            }
        }

        $rows = $query->paginate(15, ['*'], 'page', $currentPage)->withQueryString();

        $basePath = config('database-gui.base_path', 'db');

        // @phpstan-ignore-next-line
        return view('database-gui::table.data.index', compact('tables', 'table', 'columns', 'rows', 'sorts', 'showSortForm'));
    }

    public function create(string $table)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $columns = \Schema::getColumns($table);

        $basePath = config('database-gui.base_path', 'db');

        // @phpstan-ignore-next-line
        return view('database-gui::table.data.create', compact('tables', 'table', 'columns'));
    }

    public function store(\Illuminate\Http\Request $request, string $table)
    {
        $columns = \Schema::getColumns($table);

        $data = $request->only(array_map(fn ($column) => $column['name'], $columns));

        $validationRules = [];

        $foreignKeys = \Schema::getForeignKeys($table);

        // Check if any of the columns are foreign keys and validate the referenced IDs
        foreach ($foreignKeys as $foreignKey) {
            $referencedTable = $foreignKey['foreign_table'];
            $referencedColumn = $foreignKey['foreign_columns'][0];
            $column = $foreignKey['columns'][0];
            $value = $data[$column] ?? null;

            if (isset($validationRules[$column])) {
                $validationRules[$column][] = ["exists:{$referencedTable},{$referencedColumn}"];
            } else {
                $validationRules[$column] = ["exists:{$referencedTable},{$referencedColumn}"];
            }
        }

        $indexes = collect(\Schema::getIndexes($table));

        // Check if any of the columns have a unique constraint and validate the values
        foreach ($columns as $column) {
            $columnName = $column['name'];
            $indexes->filter(function ($index) use ($columnName) {
                $indexColumnName = $index['columns'][0];

                return $indexColumnName === $columnName && $index['unique'];
            })->each(function ($index) use ($columnName, $table, &$validationRules) {
                if (isset($validationRules[$columnName])) {
                    $validationRules[$columnName][] = ["unique:{$table},{$columnName}"];
                } else {
                    $validationRules[$columnName] = ["unique:{$table},{$columnName}"];
                }
            });
        }

        $request->validate($validationRules);

        \DB::table($table)->insert($data);

        $basePath = config('database-gui.base_path', 'db');

        // Check if route exists
        if (!\Route::has("$basePath.table.data.index")) {
            return redirect()->back();
        }

        return redirect()->route("$basePath.table.data.index", ['table' => $table]);
    }

    public function show(string $table, mixed $id)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $row = \DB::table($table)->where('id', $id)->orWhere('key', $id)->first();

        $basePath = config('database-gui.base_path', 'db');

        // @phpstan-ignore-next-line
        return view('database-gui::table.data.show', compact('tables', 'table', 'row'));
    }

    public function edit(string $table, mixed $id)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $columns = \Schema::getColumns($table);

        $row = \DB::table($table)->where('id', $id)->orWhere('key', $id)->first();

        $basePath = config('database-gui.base_path', 'db');

        // @phpstan-ignore-next-line
        return view('database-gui::table.data.edit', compact('tables', 'table', 'columns', 'row'));
    }

    public function update(\Illuminate\Http\Request $request, string $table, mixed $id)
    {
        $columns = \Schema::getColumns($table);

        $data = $request->only(array_map(fn ($column) => $column['name'], $columns));

        $validationRules = [];

        $foreignKeys = \Schema::getForeignKeys($table);

        // Check if any of the columns are foreign keys and validate the referenced IDs
        foreach ($foreignKeys as $foreignKey) {
            $referencedTable = $foreignKey['foreign_table'];
            $referencedColumn = $foreignKey['foreign_columns'][0];
            $column = $foreignKey['columns'][0];

            if (isset($validationRules[$column])) {
                $validationRules[$column][] = ["exists:{$referencedTable},{$referencedColumn}"];
            } else {
                $validationRules[$column] = ["exists:{$referencedTable},{$referencedColumn}"];
            }
        }

        $indexes = collect(\Schema::getIndexes($table));

        // Check if any of the columns have a unique constraint and validate the values
        foreach ($columns as $column) {
            $columnName = $column['name'];
            $indexes->filter(function ($index) use ($columnName) {
                $indexColumnName = $index['columns'][0];

                return $indexColumnName === $columnName && $index['unique'];
            })->each(function ($index) use ($columnName, $table, &$validationRules, $id) {
                if (isset($validationRules[$columnName])) {
                    $validationRules[$columnName][] = [
                        \Illuminate\Validation\Rule::unique($table, $columnName)->ignore($id),
                    ];
                } else {
                    $validationRules[$columnName] = [
                        \Illuminate\Validation\Rule::unique($table, $columnName)->ignore($id),
                    ];
                }
            });
        }

        unset($validationRules['id']);

        $request->validate($validationRules);

        \DB::table($table)->where('id', $id)->orWhere('key', $id)->update($data);

        $basePath = config('database-gui.base_path', 'db');

        // Check if route exists
        if (!\Route::has("$basePath.table.data.index")) {
            return redirect()->back();
        }

        return redirect()->route("$basePath.table.data.show", ['table' => $table, 'id' => $id]);
    }

    public function destroy(string $table, mixed $id)
    {
        \DB::table($table)->where('id', $id)->orWhere('key', $id)->delete();

        return redirect()->back();
    }
}
