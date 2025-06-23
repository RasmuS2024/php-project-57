<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use Illuminate\Support\Facades\Config;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id')->paginate(Config::get('pagination.per_page'));
        return view('taskStatus.index', compact('taskStatuses'));
    }

    public function create()
    {
        return view('taskStatus.create');
    }

    public function store(StoreTaskStatusRequest $request)
    {
        TaskStatus::create($request->validated());
        flash(__('status.flash.created'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('taskStatus.edit', compact('taskStatus'));
    }

    public function update(UpdateTaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $taskStatus->update($request->validated());
        flash(__('status.flash.updated'))->success();

        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        try {
            $taskStatus->delete();
            flash(__('status.flash.deleted'))->success();
        } catch (\Exception $e) {
            flash(__('status.flash.delete_error'))->error();
        }

        return redirect()->route('task_statuses.index');
    }
}
