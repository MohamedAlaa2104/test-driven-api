<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_todo_list()
    {
        // Preparation
        $todo = TodoList::factory()->create();

        // Action
        $response = $this->getJson(route('todo-list.index'));

        // Assertion
        $this->assertEquals($todo->name, $response->json()[0]['name']);
    }
}
