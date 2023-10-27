<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Phase;
use App\Models\Task;

class TaskController extends Controller
{

    public function kanban()
    {
        return view('tasks.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return \App\Models\Phase::withCount('tasks')->with('tasks.user')->get();
    }

    /**
     * Display a listing of the Users resource.
     */
    public function users()
    {
        return \App\Models\User::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // Create a new task from the $request
        $task = Task::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $phase  = Phase::find($request->input('phase_id'));
        if($phase->is_completion and is_null($task->completed_at)){
            $task->completed_at = now();
        }

        $task->name = $request->input('name');
        $task->phase_id = $request->input('phase_id');
        $task->user_id = $request->input('user_id');

        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Task::destroy($task->id);
    }
}
