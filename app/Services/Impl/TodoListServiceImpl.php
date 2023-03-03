<?php

namespace App\Services\Impl;

use App\Models\TodoList;
use App\Models\User;
use App\Services\TodoListService;
use Illuminate\Support\Facades\Session;

class TodoListServiceImpl implements TodoListService
{
    public function saveTodo(mixed $user_id, string $id, string $todo): void
    {
        $todo_id = $id;
        TodoList::create([
            "user_id" => $user_id,
            "todo_id" => $todo_id,
            "todo" => $todo
        ]);
    }

    public function getTodo(mixed $user_id)
    {
        $user = User::all()->where('user_id', '=', $user_id)->first();
        $todolist = $user->todolist;

        return $todolist;
    }

    public function removeTodo(string $id)
    {
        $user_id = Session::get('user_id');
        $deleted = TodoList::where('user_id', $user_id)->where('todo_id', $id)->delete();
    }
}