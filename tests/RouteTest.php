<?php

use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\HomeController;
use DanielHOfficial\LaravelDatabaseGui\Http\Controllers\SqlController;

test('home', function () {
    $result = (new HomeController)->__invoke();

    expect($result->name())->toBe('database-gui::home');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('connectionDetails');
});

test('sql', function () {
    $request = new \Illuminate\Http\Request;

    $result = (new SqlController)->__invoke($request);

    expect($result->name())->toBe('database-gui::sql');
    expect($result->getData())
        ->toHaveKey('tables')
        ->toHaveKey('query')
        ->toHaveKey('results');
});

describe('sql', function () {
    it('redirects back if query is not empty and not valid', function () {
        $request = new \Illuminate\Http\Request([
            'query' => 'invalid query',
        ]);

        $result = (new SqlController)->__invoke($request);

        expect($result->isRedirect())->toBeTrue();
    });
});
