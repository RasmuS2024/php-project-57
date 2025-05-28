<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-db', function() {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'Connected successfully',
            'db' => DB::connection()->getDatabaseName()
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
