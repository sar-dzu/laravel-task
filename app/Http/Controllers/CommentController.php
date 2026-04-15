<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function indexForNote(string $noteId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->authorize('view', [Comment::class, $note]);

        $comments = $note->comments()
            ->with('user:id,first_name,last_name,email')
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'comments' => $comments,
        ], Response::HTTP_OK);
    }

    public function storeForNote(Request $request, string $noteId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->authorize('create', [Comment::class, $note]);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $comment = $note->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return response()->json([
            'message' => 'Komentár bol úspešne vytvorený.',
            'comment' => $comment->load('user:id,first_name,last_name,email'),
        ], Response::HTTP_CREATED);
    }

    public function indexForTask(string $noteId, string $taskId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.',
            ], Response::HTTP_NOT_FOUND);
        }

        $task = Task::find($taskId);

        if (!$task || $task->note_id != $note->id) {
            return response()->json([
                'message' => 'Úloha nenájdená.',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->authorize('viewTaskComments', [Comment::class, $task]);

        $comments = $task->comments()
            ->with('user:id,first_name,last_name,email')
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'comments' => $comments,
        ], Response::HTTP_OK);
    }

    public function storeForTask(Request $request, string $noteId, string $taskId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.',
            ], Response::HTTP_NOT_FOUND);
        }

        $task = Task::find($taskId);

        if (!$task || $task->note_id != $note->id) {
            return response()->json([
                'message' => 'Úloha nenájdená.',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->authorize('createForTask', [Comment::class, $task]);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $comment = $task->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return response()->json([
            'message' => 'Komentár bol úspešne vytvorený.',
            'comment' => $comment->load('user:id,first_name,last_name,email'),
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, string $commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json([
                'message' => 'Komentár nenájdený.',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->authorize('update', [Comment::class, $comment]);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $comment->update([
            'body' => $validated['body'],
        ]);

        return response()->json([
            'message' => 'Komentár bol úspešne upravený.',
            'comment' => $comment->load('user:id,first_name,last_name,email'),
        ], Response::HTTP_OK);
    }

    public function destroy(string $commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json([
                'message' => 'Komentár nenájdený.',
            ], Response::HTTP_NOT_FOUND);
        }

        $this->authorize('delete', [Comment::class, $comment]);

        $comment->delete();

        return response()->json([
            'message' => 'Komentár bol úspešne odstránený.',
        ], Response::HTTP_OK);
    }
}
