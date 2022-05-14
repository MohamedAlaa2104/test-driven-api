<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index()
    {
        $todoList = TodoList::get();

        return response($todoList);
    }

    public function show(TodoList $todoList)
    {
        return response($todoList);
    }

    public function store(Request $request)
    {
        return TodoList::create($request->all());
    }
}
