<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

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
            ->paginate(Config::get('pagination.per_page'));

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

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by_id'] = Auth::id();
        $task = Task::create($validated);

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

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();
        $task->update($validated);
        $task->labels()->sync($validated['labels'] ?? []);

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
