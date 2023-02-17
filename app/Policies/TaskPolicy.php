<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('task_view');
    }

    public function view(User $user, Task $task)
    {
        return $user->hasPermissionTo('task_view')
                    && ($task->user->id === $user->id);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('task_create');
    }

    public function update(User $user, Task $task)
    {
        return $user->hasPermissionTo('task_update') 
                    && ($task->user->id === $user->id);
    }

    public function complete(User $user, Task $task)
    {        
        return $user->hasPermissionTo('task_update') 
                    && ($task->user->id === $user->id);
    }

    public function delete(User $user, Task $task)
    {
        return $user->hasPermissionTo('task_delete')
                    && ($task->user->id === $user->id);
    }

    public function restore(User $user, Task $task)
    {
        return $user->hasPermissionTo('task_archive')        
                    && ($task->user->id === $user->id);
    }
 
    public function forceDelete(User $user, Task $task)
    {
        return $user->hasPermissionTo('task_archive')
                    && ($task->user->id === $user->id);
    }
}
