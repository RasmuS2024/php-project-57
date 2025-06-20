<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->defaultSort('id')
            ->with(['status', 'creator', 'assignee'])
            ->paginate(15);

        return view('tasks.index', [
            'tasks' => $tasks,
            'statuses' => TaskStatus::pluck('name', 'id'),
            'users' => User::pluck('name', 'id')
        ]);
    }

    public function create()
    {
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
            'labels.*' => 'exists:labels,id'
        ], [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => __('task.entity')
            ])
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

        flash(__('task.flash.created'))->success();

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        $task->load('status', 'creator', 'assignee', 'labels');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
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
            'labels' => 'nullable|array',
            'labels.*' => 'exists:labels,id'
        ]);

        $task->update($validated);
        $task->labels()->sync($request->labels ?? []);

        flash(__('task.flash.updated'))->success();

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        flash(__('task.flash.deleted'))->success();

        return redirect()->route('tasks.index');
    }
}
