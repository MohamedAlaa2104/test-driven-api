<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private mixed $task;

    public function setUp(): void
    {
        parent::setUp();
        $this->task = Task::factory()->create();
    }

    public function test_can_get_all_tasks()
    {
        $response = $this->getJson( route('task.index') )
            ->assertOk()
            ->json();

        $this->assertCount(1, $response);
        $this->assertEquals($this->task->title, $response[0]['title']);
    }

    public function test_can_fetch_one_task()
    {
        $response = $this->getJson(route('task.show', $this->task))->assertOk()->json();

        $this->assertEquals($this->task->title, $response['title']);
    }

    public function test_can_store_task()
    {
        $todoList = TodoList::factory()->create();
        $this->postJson(route('task.store', ['title' => 'first task', 'todo_list_id' => $todoList->id]))
            ->assertCreated();

        $this->assertDatabaseHas('tasks', ['title' => 'first task']);
    }

    public function test_validate_name_and_todo_list_id_before_store_task()
    {
        $this->withExceptionHandling();

        $this->postJson(route('task.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'todo_list_id']);
    }

    public function test_can_delete_task()
    {
        $this->deleteJson(route('task.destroy', $this->task))
            ->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['title' => $this->task->title]);
    }
}
