<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\TaskStatus;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::orderBy('id')->paginate(15);
        return view('taskStatus.index', compact('taskStatuses'));
    }

    public function show($id)
    {
        abort(403);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('taskStatus.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:task_statuses|max:255',
        ], [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => 'Статус'
            ])
        ]);

        TaskStatus::create($request->all());
        
        return redirect()->route('task_statuses.index')->with('alert', [
            'type' => 'success',
            'message' => 'Статус успешно создан'
        ]);
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
        
        return redirect()->route('task_statuses.index')->with('alert', [
            'type' => 'success',
            'message' => 'Статус успешно изменён'
        ]);
    }

    public function destroy(TaskStatus $taskStatus)
    {
        try {
            $taskStatus->delete();
            return redirect()->route('task_statuses.index')
                             ->with('alert', [
                                    'type' => 'success',
                                    'message' => 'Статус успешно удалён'
                                ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()
                                 ->with('alert', [
                                    'type' => 'danger',
                                    'message' => 'Не удалось удалить статус'
                                ]);
            }
        return redirect()->back()->with('error', 'Произошла ошибка при удалении');
        }
    }
}
