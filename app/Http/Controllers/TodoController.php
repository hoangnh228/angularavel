<?php

namespace App\Http\Controllers;

use App\Todo;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    public function index() {
        $todos = Todo::all();
        return $todos;
    }

    public function store(Request $request) {
        $todo = Todo::create($request::all());
        return $todo;
    }

    public function update(Request $request, $id) {
        $todo = Todo::findOrFail($id);
        $todo->update($request::all());
        return $todo;
    }

    public function destroy($id) {
        Todo::destroy($id);
    }
}
