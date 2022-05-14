<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private TodoList $list;

    public function setUp() : void
    {
        parent::setUp();
        $this->list = TodoList::factory()->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_all_todo_list()
    {
        // Preparation

        // Action
        $response = $this->getJson( route('todo-list.index') )->json();

        // Assertion
        $this->assertEquals( $this->list->name, $response[0]['name'] );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_single_todo_list()
    {
        $response = $this->getJson( route('todo-list.show', $this->list) );

        $response->assertOk();

        $this->assertEquals($this->list->name, $response->json()['name']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_store_todo_list()
    {
        $list = TodoList::factory()->make();

        $this->postJson( route('todo-list.store', ['name' => $list->name]) )->assertCreated();

        $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
    }

    public function test_name_validation_while_storing_a_list()
    {
        $this->withExceptionHandling();

        $this->postJson( route('todo-list.store') )
             ->assertUnprocessable()
             ->assertJsonValidationErrorFor('name');
    }
}
