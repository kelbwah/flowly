<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json(['tasks' => Task::get()], 200);
    }

    public function store(Request $request)
    {
        try {
            Task::create($request->all());
            return response()->json(["result" => "ok"], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'task not found'], 404);
        }

        return response()->json(['task' => $task], 200);
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