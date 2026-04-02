<?php

use Illuminate\Http\Request;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/change-password', [AuthController::class, 'changePassword']);
        Route::patch('/profile', [AuthController::class, 'updateProfile']);
    });
});

Route::get('notes/stats/status', [NoteController::class, 'statsByStatus']);
Route::patch('notes/actions/archive-old-drafts', [NoteController::class, 'archiveOldDrafts']);
Route::get('notes-actions/search', [NoteController::class, 'search']);
Route::get('notes/pinned', [NoteController::class, 'pinned']);

Route::patch('notes/{id}/publish', [NoteController::class, 'publish']);
Route::patch('notes/{id}/archive', [NoteController::class, 'archive']);
Route::patch('notes/{id}/pin', [NoteController::class, 'pin']);
Route::patch('notes/{id}/unpin', [NoteController::class, 'unpin']);

Route::get('users/{user}/notes', [NoteController::class, 'userNotesWithCategories']);

Route::apiResource('notes', NoteController::class);


Route::get('notes/{noteId}/tasks', [TaskController::class, 'index']);
Route::post('notes/{noteId}/tasks', [TaskController::class, 'store']);
Route::get('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'show']);
Route::put('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'update']);
Route::patch('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'update']);
Route::delete('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    // všetci prihlásení môžu čítať kategórie
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);

    // iba admin môže vytvárať, upravovať, mazať kategórie
    Route::middleware('admin')->group(function () {
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    });
});
