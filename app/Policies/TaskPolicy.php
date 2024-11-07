<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function getList(User $user)
    {
        return $user->role == 'admin' || $user->role == 'editor';
    }

    public function create(User $user)
    {
        return $user->role == 'admin' || $user->role == 'editor';
    }

    public function update(User $user, Task $task)
    {
        return $user->role == 'admin' || ($user->role == 'editor' && $task->user_id == $user->id);
    }

    public function delete(User $user)
    {
        return $user->role == 'admin';
    }
}
