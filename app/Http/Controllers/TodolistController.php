<?php

namespace App\Http\Controllers;

use App\Services\TodoService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class TodolistController extends Controller
{

    private UserService $userService;
    private TodoService $todolistService;


    public function __construct(UserService $userService, TodoService $todolistService)
    {
        $this->userService = $userService;
        $this->todolistService = $todolistService;
    }

    public function todoList(Request $request): Response
    {
        $userId = $request->session()->get("user");
        $user = $this->userService->getUser($userId);
        $todolist = $this->todolistService->getTodolist($user);
        return response()->view("todolist.todolist", [
            "title" => "Todolist",
            "todolist" => $todolist,
            "user" => $user
        ]);
    }

    public function addTodo(Request $request): RedirectResponse|Response
    {
        try {
            $userId = $request->session()->get("user");
            $todo = $request->input('todo');
            $this->todolistService->saveTodo($userId, $todo);
            return redirect()->action([TodolistController::class, 'todoList']);
        } catch (Exception $e) {
            $userId = $request->session()->get("user");
            $user = $this->userService->getUser($userId);
            $todolist = $this->todolistService->getTodolist($user);
            return response()->view("todolist.todolist", [
                "title" => "Todolist",
                "todolist" => $todolist,
                "error" => $e->getMessage()
            ]);
        }
    }

    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todolistService->removeTodo($todoId);
        return redirect()->action([TodolistController::class, 'todoList']);
    }

}
