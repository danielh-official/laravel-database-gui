<?php

use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\ExportSqlResultsController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\HomeController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\SqlController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableDataController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableInfoController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\TableStructureController;
use Illuminate\Support\Facades\Route;

$baseUrl = config('database-gui.base_path', 'db');

Route::name("$baseUrl.")->prefix($baseUrl)->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::get('sql', SqlController::class)->name('sql');

    Route::post('sql/results/export', ExportSqlResultsController::class)->name('sql.results.export');

    Route::name('table.')->prefix('/table/{table}')->group(function () {
        Route::resource('data', TableDataController::class)->parameters([
            'data' => 'id',
        ]);

        Route::get('/structure', TableStructureController::class)->name('structure');

        Route::get('/info', TableInfoController::class)->name('info');
    });
});
