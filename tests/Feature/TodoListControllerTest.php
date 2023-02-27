<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            "user" => "manuel",
            "todolist" =>[
                [
                    "id" => "1",
                    "todo" => "Tidur"],
                [
                    "id" => "2",
                    "todo" => "Makan"
                ]
            ]
        ]) -> get('/todolist')
                ->assertSeeText("1")
                ->assertSeeText("Tidur")
                ->assertSeeText("2")
                ->assertSeeText("Makan");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "manuel"
        ])->post('/todolist', [])
            ->assertSeeText("Todo is required!");
    }

    public function testAddTodo()
    {
        $this->withSession([
            "user" => "manuel"
        ])->post('/todolist', [
            "todo" => "Makan"
        ])->assertRedirect('/todolist');
    }
}