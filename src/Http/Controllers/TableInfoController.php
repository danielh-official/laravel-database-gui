<?php

namespace DanielHOfficial\LaravelDatabaseGui\Http\Controllers;

class TableInfoController
{
    public function __invoke(string $table)
    {
        $tables = \DB::connection()->getSchemaBuilder()->getTables();

        $columns = \Schema::getColumns($table);

        $foreignKeys = \Schema::getForeignKeys($table);

        $indexes = \Schema::getIndexes($table);

        $rowCount = \DB::table($table)->count();

        if (\DB::getDriverName() === 'mysql') {
            $databaseType = 'mysql';
            $engine = \DB::selectOne('SHOW TABLE STATUS WHERE Name = ?', [$table])->Engine;
            $collation = \DB::selectOne('SHOW TABLE STATUS WHERE Name = ?', [$table])->Collation;
            $comment = \DB::selectOne('SHOW TABLE STATUS WHERE Name = ?', [$table])->Comment;
        } else {
            $databaseType = \DB::getDriverName();
            $engine = null;
            $collation = null;

            if (\DB::getDriverName() === 'pgsql') {
                $collation = \DB::selectOne('SELECT pg_catalog.pg_get_userbyid(datdba) AS collation FROM pg_catalog.pg_database WHERE datname = ?', [\DB::getDatabaseName()])->collation;
            }

            if (\DB::getDriverName() === 'sqlite') {
                $collation = \DB::selectOne('PRAGMA encoding')->encoding;
            }

            $comment = null;

            if (\DB::getDriverName() === 'pgsql') {
                $comment = \DB::selectOne('SELECT obj_description(oid) AS comment FROM pg_class WHERE relname = ?', [$table])->comment;
            }
        }

        $createQuery = null;

        if (\DB::getDriverName() === 'sqlite') {
            $createQuery = \DB::selectOne('SELECT sql FROM sqlite_schema WHERE name = ?', [$table])->sql;
        }

        if (\DB::getDriverName() === 'mysql') {
            $createQuery = \DB::selectOne("SHOW CREATE TABLE `$table`")->{'Create Table'};
        }

        if (\DB::getDriverName() === 'pgsql') {
            $createQuery = \DB::selectOne('SELECT pg_get_tabledef(oid) AS create_table FROM pg_class WHERE relname = ?', [$table])->create_table;
        }

        return view('database-gui::table.info', compact('tables', 'table', 'columns', 'foreignKeys', 'indexes', 'rowCount', 'engine', 'collation', 'comment', 'createQuery'));
    }
}
