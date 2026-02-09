<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class TableStructureController
{
    public function __invoke(string $table)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $columns = \Schema::getColumns($table);

        $foreignKeys = \Schema::getForeignKeys($table);

        $indexes = \Schema::getIndexes($table);

        return view('database-gui::table.structure', compact('tables', 'table', 'columns', 'foreignKeys', 'indexes'));
    }
}
