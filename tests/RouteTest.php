<?php

use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\ExportSqlResultsController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\HomeController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\SqlController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableDataController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableInfoController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableStructureController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

beforeEach(function () {
    Schema::dropIfExists('test_items');

    Schema::create('test_items', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique();
        $table->string('key')->nullable();
    });

    DB::table('test_items')->insert([
        ['name' => 'Alpha', 'key' => 'alpha'],
        ['name' => 'Beta', 'key' => 'beta'],
    ]);
});

test('home', function () {
    $result = (new HomeController)->__invoke();

    expect($result->name())->toBe('database-gui::home');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('connectionDetails');
});

test('sql', function () {
    $request = new Request;

    $result = (new SqlController)->__invoke($request);

    expect($result->name())->toBe('database-gui::sql');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('query')
        ->toHaveKey('results');
});

describe('sql', function () {
    it('redirects back if query is not empty and not valid', function () {
        $request = new Request([
            'query' => 'invalid query',
        ]);

        $result = (new SqlController)->__invoke($request);

        expect($result->isRedirect())->toBeTrue();
    });
});

test('sql results export', function () {
    $request = new Request([
        'query' => 'select * from test_items',
    ]);

    $result = (new ExportSqlResultsController)->__invoke($request);

    expect($result)->toBeInstanceOf(BinaryFileResponse::class);

    $exportPath = $result->getFile()->getPathname();
    if (file_exists($exportPath)) {
        unlink($exportPath);
    }
});

test('table data index', function () {
    $request = new Request;

    $result = (new TableDataController)->index($request, 'test_items');

    expect($result->name())->toBe('database-gui::table.data.index');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('table')
        ->toHaveKey('columns')
        ->toHaveKey('rows')
        ->toHaveKey('sorts')
        ->toHaveKey('showSortForm');
});

test('table data create', function () {
    $result = (new TableDataController)->create('test_items');

    expect($result->name())->toBe('database-gui::table.data.create');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('table')
        ->toHaveKey('columns');
});

test('table data store', function () {
    $request = new Request([
        'name' => 'Gamma',
        'key' => 'gamma',
    ]);

    $result = (new TableDataController)->store($request, 'test_items');

    expect($result->isRedirect())->toBeTrue();
    expect(DB::table('test_items')->where('name', 'Gamma')->exists())->toBeTrue();
});

test('table data show', function () {
    $rowId = DB::table('test_items')->value('id');

    $result = (new TableDataController)->show('test_items', $rowId);

    expect($result->name())->toBe('database-gui::table.data.show');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('table')
        ->toHaveKey('row');
});

test('table data edit', function () {
    $rowId = DB::table('test_items')->value('id');

    $result = (new TableDataController)->edit('test_items', $rowId);

    expect($result->name())->toBe('database-gui::table.data.edit');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('table')
        ->toHaveKey('columns')
        ->toHaveKey('row');
});

test('table data update', function () {
    $rowId = DB::table('test_items')->value('id');

    $request = new Request([
        'name' => 'Alpha Updated',
        'key' => 'alpha-updated',
    ]);

    $result = (new TableDataController)->update($request, 'test_items', $rowId);

    expect($result->isRedirect())->toBeTrue();
    expect(DB::table('test_items')->where('id', $rowId)->value('name'))->toBe('Alpha Updated');
});

test('table data destroy', function () {
    $rowId = DB::table('test_items')->value('id');

    $result = (new TableDataController)->destroy('test_items', $rowId);

    expect($result->isRedirect())->toBeTrue();
    expect(DB::table('test_items')->where('id', $rowId)->exists())->toBeFalse();
});

test('table structure', function () {
    $result = (new TableStructureController)->__invoke('test_items');

    expect($result->name())->toBe('database-gui::table.structure');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('table')
        ->toHaveKey('columns')
        ->toHaveKey('foreignKeys')
        ->toHaveKey('indexes');
});

test('table info', function () {
    $result = (new TableInfoController)->__invoke('test_items');

    expect($result->name())->toBe('database-gui::table.info');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('table')
        ->toHaveKey('columns')
        ->toHaveKey('foreignKeys')
        ->toHaveKey('indexes')
        ->toHaveKey('rowCount')
        ->toHaveKey('engine')
        ->toHaveKey('collation')
        ->toHaveKey('comment')
        ->toHaveKey('createQuery');
});
