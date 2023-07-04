<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        $tasks = Task::paginate(10);
        $tasks = Task::orderBy('title', 'asc')->paginate(10);
        return response()->json($tasks);
    }
    
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'completed' => 'boolean',
        ]);
    
        $task = Task::create($validatedData);
        return response()->json($task, 201);
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'completed' => 'boolean',
        ]);
    
        $task = Task::findOrFail($id);
        $task->update($validatedData);
        return response()->json($task);
    }
    
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204);
    }
    
    public function search(Request $request)
{
    $searchTerm = $request->input('q');
    $tasks = Task::where('title', 'like', '%'.$searchTerm.'%')->get();
    return response()->json($tasks);
}

    
}
