<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;

// auth
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/me/profile-photo', [AuthController::class, 'storeProfilePhoto']);
        Route::delete('/me/profile-photo', [AuthController::class, 'destroyProfilePhoto']);

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/change-password', [AuthController::class, 'changepassword']);
        Route::patch('/profile', [AuthController::class, 'updateProfile']);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    // notes
    Route::get('/notes', [NoteController::class, 'index']);
    Route::get('/my-notes', [NoteController::class, 'myNotes']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::get('/notes/{note}', [NoteController::class, 'show']);
    Route::patch('/notes/{note}', [NoteController::class, 'update']);
    Route::delete('/notes/{note}', [NoteController::class, 'destroy']);

    Route::patch('/notes/{id}/publish', [NoteController::class, 'publish']);
    Route::patch('/notes/{id}/archive', [NoteController::class, 'archive']);
    Route::patch('/notes/{id}/pin', [NoteController::class, 'pin']);
    Route::patch('/notes/{id}/unpin', [NoteController::class, 'unpin']);

    Route::get('notes/stats/status', [NoteController::class, 'statsByStatus']);
    Route::patch('notes/actions/archive-old-drafts', [NoteController::class, 'archiveOldDrafts']);
    Route::get('notes-actions/search', [NoteController::class, 'search']);
    Route::get('notes/pinned', [NoteController::class, 'pinned']);
    Route::get('users/{user}/notes', [NoteController::class, 'userNotesWithCategories']);

    // tasks
    Route::apiResource('notes.tasks', TaskController::class)->scoped();

    // comments
    Route::get('notes/{noteId}/comments', [CommentController::class, 'indexForNote']);
    Route::post('notes/{noteId}/comments', [CommentController::class, 'storeForNote']);

    Route::get('notes/{noteId}/tasks/{taskId}/comments', [CommentController::class, 'indexForTask']);
    Route::post('notes/{noteId}/tasks/{taskId}/comments', [CommentController::class, 'storeForTask']);

    Route::patch('comments/{commentId}', [CommentController::class, 'update']);
    Route::delete('comments/{commentId}', [CommentController::class, 'destroy']);

    // attachments
    Route::get('notes/{note}/attachments', [AttachmentController::class, 'index']);
    Route::post('notes/{note}/attachments', [AttachmentController::class, 'store'])
        ->middleware('premium');
    Route::get('attachments/{attachment}/link', [AttachmentController::class, 'link']);
    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy']);

    // categories
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);

    Route::middleware('admin')->group(function () {
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    });
});
