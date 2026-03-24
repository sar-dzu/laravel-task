<?php

use Illuminate\Http\Request;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


use App\Http\Controllers\NoteController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;

use Illuminate\Support\Facades\Route;



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
Route::apiResource('categories', CategoryController::class);

Route::get('notes/{noteId}/tasks', [TaskController::class, 'index']);
Route::post('notes/{noteId}/tasks', [TaskController::class, 'store']);
Route::get('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'show']);
Route::put('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'update']);
Route::patch('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'update']);
Route::delete('notes/{noteId}/tasks/{taskId}', [TaskController::class, 'destroy']);
