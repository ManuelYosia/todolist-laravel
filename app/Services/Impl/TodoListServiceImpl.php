<?php

namespace App\Services\Impl;

use App\Models\TodoList;
use App\Services\TodoListService;
use Illuminate\Support\Facades\Session;

class TodoListServiceImpl implements TodoListService
{
    public function saveTodo(string $user_id, string $id, string $todo): void
    {
        $todo_id = $id;
        TodoList::create([
            "user_id" => $user_id,
            "todo_id" => $todo_id,
            "todo" => $todo
        ]);
    }

    public function getTodo(string $user_id)
    {
        $todolist = TodoList::all();

        $userTodolist = $todolist->where('user_id', '=', $user_id);

        return $userTodolist;
    }

    public function removeTodo(string $id)
    {
        $user_id = Session::get('user_id');
        $deleted = TodoList::where('user_id', $user_id)->where('todo_id', $id)->delete();
    }
}