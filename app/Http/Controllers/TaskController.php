<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $this->authorize("getList", Task::class);
            $tasks = Task::all();

            return response()->json(['data' => $tasks], 200);
        } catch (AuthorizationException $e) {
            return response()->json(['error' => 'Không đủ quyền để thực hiện'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTaskRequest $request)
    {
        try {
            $this->authorize('create', Task::class);
            $data = $request->all();
            $data['user_id'] = $request->user()->id;
            $task = Task::create($data);

            return response()->json([
                'message' => 'Tạo công việc thành công!',
                'task' => $task
            ], 201);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => "Bạn không có quyền cho hành động này"
            ], 403);
        }
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
            $this->authorize($task);

            $task->update($request->all());

            return response()->json([
                'message' => 'Cập nhật công việc thành công!',
                'task' => $task
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Không tìm thấy bản ghi phù hợp'
            ], 404);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => "Bạn không có quyền cho hành động này"
            ], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = Task::findOrFail($id);
            $this->authorize('delete', Task::class);
            $task->delete();
            return response()->json(['ak' => "ak"], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Không tìm thấy bản ghi nào'
            ], 404);
        } catch (AuthorizationException $e) {
            return response()->json([
                'message' => "Bạn không có quyền cho hành động này"
            ], 403);
        }
    }
}
