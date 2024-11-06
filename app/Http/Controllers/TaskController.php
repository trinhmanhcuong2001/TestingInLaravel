<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return response()->json(['data' => $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        $task = Task::create($request->all());

        return response()->json([
            'message' => 'Tạo công việc thành công!',
            'task' => $task
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);

        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        // dd($request->all());
        $task = Task::find($id);

        $task->update($request->all());

        return response()->json([
            'message' => 'Cập nhật công việc thành công!',
            'task' => $task
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        $task->delete();
        return response()->json([], 204);
    }
}
