<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['status', 'creator', 'assignee'])
        ->filter(request()->only('filter'))
        ->paginate(15);

        return view('tasks.index', [
            'tasks' => $tasks,
            'statuses' => TaskStatus::pluck('name', 'id'),
            'users' => User::pluck('name', 'id')
        ]);
    }

    public function create()
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('tasks.create', [
            'statuses' => TaskStatus::all(),
            'users' => User::all(),
            'labels' => Label::all()
        ]);
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status_id' => 'required|exists:task_statuses,id',
        'assigned_to_id' => 'nullable|exists:users,id',
        'labels' => 'nullable|array',
        'labels.*' => 'exists:labels,id' // Проверка каждой метки
    ]);

    $task = Task::create([
        'name' => $validated['name'],
        'description' => $validated['description'],
        'status_id' => $validated['status_id'],
        'assigned_to_id' => $validated['assigned_to_id'],
        'created_by_id' => auth()->id()
    ]);

    if (isset($validated['labels'])) {
        $task->labels()->sync($validated['labels']);
    }

    return redirect()->route('tasks.index')->with('alert', [
        'type' => 'success',
        'message' => 'Задача успешно создана'
    ]);
}

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'id');
        $users = User::pluck('name', 'id');
        return view('tasks.edit', [
            'task' => $task,
            'statuses' => TaskStatus::all(),
            'users' => User::all(),
            'labels' => Label::all(),
        ]);
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);
        return redirect()->route('tasks.index')->with('alert', [
            'type' => 'success',
            'message' => 'Задача успешно изменена'
        ]);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('alert', [
            'type' => 'success',
            'message' => 'Задача успешно удалена'
        ]);
    }
}
