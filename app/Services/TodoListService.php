<?php

namespace App\Services;

interface TodoListService
{
    function saveTodo(mixed $user_id, string $id, string $todo): void;
    
    function getTodo(mixed $user_id);

    function removeTodo(string $id);
}