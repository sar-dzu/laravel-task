<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/', '/profile/create');

Route::get('/profile/create', [ProfileController::class, 'showForm']);
Route::post('/profile/result', [ProfileController::class, 'processForm']);

// Alebo alternatíva
Route::prefix('profile')->group(function () {
    Route::get('/create', [ProfileController::class, 'showForm']);
    Route::post('/result', [ProfileController::class, 'processForm']);
});

Route::prefix('example')->group(function () {
Route::get('/create', [ExampleController::class, 'create']);
Route::post('/result', [ExampleController::class, 'result']);
});
