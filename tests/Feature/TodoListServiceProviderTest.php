<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodoListServiceProviderTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }
    
    public function testTodoListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo("1", "Tidur");

        $todolist = Session::get("todolist");
        foreach($todolist as $value){
            self::assertEquals("1",$value["id"]);
            self::assertEquals("Tidur",$value["todo"]);
        }
    }

    public function testGetTodoListIsEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodo());
    }

    public function testGetTodoListIsNotEmpty()
    {
        $expected = [
            [
                "id" => "1",
                "todo" => "Tidur"
            ],
            [
                "id" => "2",
                "todo" => "Makan"
            ]
            ];

        $this->todoListService->saveTodo("1", "Tidur");
        $this->todoListService->saveTodo("2", "Makan");

        self::assertEquals($expected, $this->todoListService->getTodo());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo("1", "Tidur");
        $this->todoListService->saveTodo("2", "Makan");

        self::assertEquals(2, sizeof($this->todoListService->getTodo()));

        $this->todoListService->removeTodo("1");
        self::assertEquals(1, sizeof($this->todoListService->getTodo()));

    }
}
