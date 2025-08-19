<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\TaskCreateRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $requesterId = $request->get("requesterId");
        $tasks = Task::get()->where("user_id", '=', $requesterId);
        return response()->json(['tasks' => $tasks], 200);
    }

    public function store(TaskCreateRequest $request)
    {
        try {
            $requesterId = $request->get("requesterId");
            $request["user_id"] = $requesterId;

            Task::create($request->all());

            return response()->json(["result" => "ok"], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $requesterId = $request->get('requesterId');

        $task = Task::find($id);
        if (empty($task)) {
            return response()->json(['error' => 'task not found'], 404);
        }

        if ($task->user_id !== $requesterId) {
            return response()->json(['error' => 'forbidden request'], 403);
        }

        $formattedTask = $task->toArray();
        unset($formattedTask["user_id"]);

        return response()->json(['task' => $formattedTask], 200);
    }

    public function update(Request $request, $id)
    {
        $result = Task::update($id, $request->all());
        if ($result === false) {
            return response()->json(['error' => "unable to update task with id: {$id}"], 500);
        }

        return response()->json(['result' => 'ok'], 200);
    }

    public function destroy($id)
    {
        $result = Task::destroy($id);
        if ($result === false) {
            return response()->json(['error' => "unable to delete task with id: {$id}"], 500);
        }

        return response()->json(['result' => 'ok'], 200);
    }
}