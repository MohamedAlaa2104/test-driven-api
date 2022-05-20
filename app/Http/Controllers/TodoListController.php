<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $request->validate(['name' => 'required']);

        return TodoList::create($request->all());
    }

    public function update(TodoList $todoList, Request $request)
    {
        return $todoList->update($request->all());
    }

    public function destroy(TodoList $todoList)
    {
        $todoList->delete();

        return response('', Response::HTTP_NO_CONTENT);
    }
}
