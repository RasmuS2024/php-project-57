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
    Route::resource('tasks', TaskController::class)->only([
        'create', 'edit', 'store', 'update', 'destroy'
    ]);
});

Route::resource('tasks', TaskController::class)->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::resource('task_statuses', TaskStatusController::class)->only([
        'create', 'edit', 'store', 'update', 'destroy'
    ]);
});

Route::resource('task_statuses', TaskStatusController::class)->only(['index']);

Route::middleware('auth')->group(function () {
    Route::resource('labels', LabelController::class)->only([
        'create', 'edit', 'store', 'update', 'destroy'
    ]);
});

Route::resource('labels', LabelController::class)->only(['index']);
