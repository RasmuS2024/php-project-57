<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\Http\Controllers\LabelController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('profile', ProfileController::class)->only([
        'edit', 'update', 'destroy'
    ]);
});

Route::resource('tasks', TaskController::class);

Route::resource('task_statuses', TaskStatusController::class);

Route::resource('labels', LabelController::class);

Route::get('/test-rollbar', function () {
    \Illuminate\Support\Facades\Log::debug('Test debug message from route');
    return 'Rollbar test complete! Check your Rollbar dashboard.';
});
