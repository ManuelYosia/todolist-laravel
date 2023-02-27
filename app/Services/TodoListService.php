<?php

namespace App\Services;

interface TodoListService
{
    function saveTodo(string $id, string $todo): void;
    
    function getTodo(): array;

    function removeTodo(string $id);
}