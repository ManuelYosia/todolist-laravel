<?php

namespace App\Services\Impl;

use App\Services\TodoListService;
use Illuminate\Support\Facades\Session;

class TodoListServiceImpl implements TodoListService
{
    public function saveTodo(string $id, string $todo): void
    {
        if (!Session::exists('todolist')) {
            Session::put('todolist', []);
        }

        Session::push('todolist', [
            "id" => $id,
            "todo" => $todo
        ]);
    }

    public function getTodo(): array
    {
        return Session::get("todolist",[]);
    }

    public function removeTodo(string $id)
    {
        $todolist = Session::get("todolist");

        foreach($todolist as $index => $value){
            if($id == $value["id"]){
                unset($todolist[$index]);
                break;
            }
        }

        Session::put('todolist', $todolist);
    }
}