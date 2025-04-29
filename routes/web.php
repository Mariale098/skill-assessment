<?php

use Illuminate\Support\Facades\Route;
use Mariale098\Quotes\Quotes;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('/quotes/random', function (Quotes $quotes) {
        return response()->json($quotes->getRandomQuote());
    });

    Route::get('/quotes', function (Quotes $quotes) {
        $limit = request('limit', 10);
        $skip = request('skip', 0);
        return response()->json($quotes->getQuotes($limit, $skip));
    });

    Route::get('/quotes/{id}', function (Quotes $quotes, $id) {
        return response()->json($quotes->getQuote($id));
    });
});

Route::get('/quotes', function () {
    return view('quotes::index');
});
