<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user', 'lead', 'opportunity')->get();
        return new TaskCollection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:800'],
            'description' => ['required', 'string', 'max:800'],
            'user_id' => ['required', 'exists:users,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'opportunity_id' => ['required', 'exists:opportunities,id'],
            'date' => ['required', 'date_format:Y-m-d H:i:s'],
            'due_date' => ['required', 'date'],
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->lead_id = $request->lead_id;
        $task->opportunity_id = $request->opportunity_id;
        $task->date = $request->date;
        $task->due_date = $request->due_date;
        $task->save();
        $task->statuses()->attach(1);

        return response()->json([
            'status' => 'Success',
            'message' => 'Task Created Successfully',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        if ($task != null) {
            return new TaskResource($task);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => 'Task Not Found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:800'],
            'description' => ['required', 'string', 'max:800'],
            'user_id' => ['required', 'exists:users,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'opportunity_id' => ['required', 'exists:opportunities,id'],
            'date' => ['required', 'date_format:Y-m-d H:i:s'],
            'due_date' => ['required', 'date'],
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->user_id = $request->user_id;
        $task->lead_id = $request->lead_id;
        $task->opportunity_id = $request->opportunity_id;
        $task->date = $request->date;
        $task->due_date = $request->due_date;
        $task->update();

        $task->statuses()->sync(2);

        return response()->json([
            'status' => 'Success',
            'message' => 'Task Updated Successfully',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->statuses()->detach();
        $task->delete();
        return response()->json([
            'status' => 'Success',
            'message' => 'Task Deleted Successfully',
        ], 200);
    }
}
