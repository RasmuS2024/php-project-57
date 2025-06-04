<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\TaskStatus;
use Illuminate\Validation\Rule;

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
            'name' => 'required|unique:task_statuses|max:255'
        ]);

        TaskStatus::create($request->all());
        
        return redirect()->route('task_statuses.index')
            ->with('success', 'Статус успешно создан');
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
        
        return redirect()->route('task_statuses.index')
            ->with('success', 'Статус успешно обновлён');
    }

    public function destroy(TaskStatus $taskStatus)
    {
        try {
            $taskStatus->delete();
            return redirect()->route('task_statuses.index')
                             ->with('success', 'Статус успешно удалён');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->back()
                                 ->with('error', 'Нельзя удалить статус с привязанными задачами');
            }
        return redirect()->back()->with('error', 'Произошла ошибка при удалении');
        }
    }
}
