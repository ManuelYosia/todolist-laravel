<?php

namespace App\Services;

interface TodoListService
{
    function saveTodo(string $user_id, string $id, string $todo): void;
    
    function getTodo(string $user_id);

    function removeTodo(string $id);
}