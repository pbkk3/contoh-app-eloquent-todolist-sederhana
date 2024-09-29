<?php

namespace App\Services\Impl;

use App\Models\Todo;
use App\Models\User;
use App\Services\TodoService;
use Illuminate\Support\Facades\Session;

class TodoServiceImpl implements TodoService
{

    public function saveTodo(int $userId, ?string $todo): void
    {
        if ($todo == null) {
            throw new \Exception("Todo cannot be empty");
        }

        $todo = new Todo([
            "todo" => $todo,
            "user_id" => $userId
        ]);
        $todo->save();
    }

    public function getTodolist(User $user): array
    {
        $todolist = $user->todos;

        return $todolist->toArray();
    }

    public function removeTodo(int $todoId): void
    {
        $todo = Todo::query()->find($todoId);
        if($todo != null){
            $todo->delete();
        }
    }
}
