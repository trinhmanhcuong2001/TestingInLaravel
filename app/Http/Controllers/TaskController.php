<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            $task = Task::findOrFail($id);

            $task->update($request->all());

            return response()->json([
                'message' => 'Cập nhật công việc thành công!',
                'task' => $task
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Không tìm thấy bản ghi phù hợp'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Đã xảy ra lỗi trong quá trình cập nhật công việc'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $task->delete();
            return response()->json([], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Không tìm thấy bản ghi nào'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
