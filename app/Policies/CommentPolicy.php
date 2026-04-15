<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Note $note): bool
    {
        if ($note->status === 'published' || $note->status === 'archived') {
            return true;
        }

        return $note->user_id === $user->id;
    }
    public function viewTaskComments(User $user, Task $task): bool
    {
        $note = $task->note;

        if ($note->status === 'published' || $note->status === 'archived') {
            return true;
        }

        return $note->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Note $note): bool
    {
        if ($note->status === 'published' || $note->status === 'archived') {
            return true;
        }

        return $note->user_id === $user->id;
    }

    public function createForTask(User $user, Task $task): bool
    {
        $note = $task->note;

        if ($note->status === 'published' || $note->status === 'archived') {
            return true;
        }

        return $note->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $comment->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
