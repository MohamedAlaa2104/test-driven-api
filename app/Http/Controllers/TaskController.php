<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::get();

        return response($tasks);
    }

    public function show(Task $task)
    {
        return response($task);
    }

    public function store(Request $request)
    {
        $request->validate([
            'todo_list_id' => 'required|exists:todo_lists,id',
            'title' => 'required'
        ]);

        return Task::create($request->all());
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
