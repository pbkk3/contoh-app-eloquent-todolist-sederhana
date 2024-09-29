<?php

namespace App\Services;

use App\Models\User;

interface TodoService
{

    public function saveTodo(int $userId, string $todo): void;

    public function getTodolist(User $user): array;

    public function removeTodo(int $todoId);

}
