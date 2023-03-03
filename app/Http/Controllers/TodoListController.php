<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class TodoListController extends Controller
{
    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService){
        $this->todoListService = $todoListService;
    }
    public function todoList(Request $request): Response
    {
        $username = Session::get('username');
        $user_id = Session::get('user_id');
        $todolist = $this->todoListService->getTodo($user_id);

        return response()->view('todolist.todolist', [
            "title" => "TodoList",
            "username" => $username,
            "todolist" => $todolist
        ]);
    }

    public function addTodo(Request $request): Response|RedirectResponse
    {
        $user_id = Session::get('user_id');
        $todo = $request->input("todo");

        if(empty($todo)){
            $todolist = $this->todoListService->getTodo($user_id);

            return response()->view('todolist.todolist', [
                "title" => "TodoList",
                "todolist" => $todolist,
                "error" => "Todo is required!"
            ]);
        }

        $this->todoListService->saveTodo($user_id, uniqid(), $todo);
        return redirect()->action([TodoListController::class, 'todoList']);
    }

    public function removeTodo(Request $request, string $id): RedirectResponse
    {
        $this->todoListService->removeTodo($id);

        return redirect()->action([TodoListController::class, 'todoList']);
    }
}
