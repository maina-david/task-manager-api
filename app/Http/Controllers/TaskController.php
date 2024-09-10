<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    /**
     * Create a new task.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:tasks,title|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'due_date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'status' => $request->input('status', TaskStatus::PENDING->value),
            'due_date' => $request->input('due_date')
        ]);

        return response()->json($task, 201);
    }

    /**
     * Get all tasks with optional filtering, pagination, and search.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => ['nullable', Rule::enum(TaskStatus::class)],
            'due_date' => 'nullable|date',
            'search' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $query = Task::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by due date
        if ($request->has('due_date')) {
            $query->where('due_date', $request->input('due_date'));
        }

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        // Pagination with 10 items per page
        $tasks = $query->paginate(10);

        // Return paginated task list
        return response()->json($tasks);
    }

    /**
     * Get a specific task.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    /**
     * Update an existing task.
     *
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }


        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|unique:tasks,title,' . $task->id . '|max:255',
            'description' => 'nullable|string',
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'due_date' => 'required|date|after:today',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task->update([
            'title' => $request->input('title', $task->title),
            'description' => $request->input('description', $task->description),
            'status' => $request->input('status', $task->status),
            'due_date' => $request->input('due_date', $task->due_date),
        ]);

        return response()->json($task);
    }

    /**
     * Delete a task.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}