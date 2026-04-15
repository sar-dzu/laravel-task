<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(Note $note)
    {
        // kto môže vidieť note, môže vidieť aj jej tasky
        $this->authorize('view', [Task::class, $note]);

        $tasks = $note->tasks()
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'tasks' => $tasks,
        ], Response::HTTP_OK);
    }

    public function store(Request $request, int $noteId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('create', [Task::class, $note]);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_done' => ['sometimes', 'boolean'],
            'due_at' => ['nullable', 'date'],
        ]);

        $task = $note->tasks()->create([
            'title' => $validated['title'],
            'is_done' => $validated['is_done'] ?? false,
            'due_at' => $validated['due_at'] ?? null,
        ]);

        return response()->json([
            'message' => 'Úloha bola úspešne vytvorená.',
            'task' => $task,
        ], Response::HTTP_CREATED);
    }

    public function show(int $noteId, int $taskId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }

        $task = $note->tasks()->find($taskId);

        if (!$task) {
            return response()->json([
                'message' => 'Úloha nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('view', [Task::class, $note]);
        return response()->json([
            'task' => $task->load([
                'comments.user:id,first_name,last_name,email',
            ]),
        ], Response::HTTP_OK);
    }

    public function update(Request $request, int $noteId, int $taskId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }

        $task = $note->tasks()->find($taskId);


        if (!$task) {
            return response()->json([
                'message' => 'Úloha nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('update', [Task::class, $note]);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'is_done' => ['sometimes', 'boolean'],
            'due_at' => ['nullable', 'date'],
        ]);

        $task->update($validated);

        return response()->json([
            'message' => 'Úloha bola úspešne aktualizovaná.',
            'task' => $task,
        ], Response::HTTP_OK);
    }

    public function destroy(int $noteId, int $taskId)
    {
        $note = Note::find($noteId);

        if (!$note) {
            return response()->json([
                'message' => 'Poznámka nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }

        $task = $note->tasks()->find($taskId);

        if (!$task) {
            return response()->json([
                'message' => 'Úloha nenájdená.'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->authorize('delete', [Task::class, $note]);
        $task->delete();

        return response()->json([
            'message' => 'Úloha bola úspešne odstránená.',
        ], Response::HTTP_OK);
    }
}
