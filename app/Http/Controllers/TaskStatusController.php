<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\TaskStatus;
use Illuminate\Validation\Rule;

class TaskStatusController extends Controller
{
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id')->paginate(15);
        return view('taskStatus.index', compact('taskStatuses'));
    }

    public function show()
    {
        abort(403);
    }

    public function create()
    {
        return view('taskStatus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:task_statuses|max:255',
        ], [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => __('status.entity')
            ])
        ]);

        TaskStatus::create($request->all());
        flash(__('status.flash.created'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus)
    {
        return view('taskStatus.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus)
    {
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('task_statuses')->ignore($taskStatus->id)
            ]
        ]);

        $taskStatus->update($request->all());
        flash(__('status.flash.updated'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        try {
            $taskStatus->delete();
            flash(__('status.flash.deleted'))->success();
            return redirect()->route('task_statuses.index');
        } catch (QueryException $e) {
            if ($e->getCode() === 23000) {
                flash(__('status.flash.delete_error'))->error();
            } else {
                flash(__('status.flash.delete_exception'))->error();
            }
            return redirect()->back();
        }
    }
}
