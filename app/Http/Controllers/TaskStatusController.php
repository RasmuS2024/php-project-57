<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TaskStatusController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStatus $taskStatus)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        //
    }

    public function edit(TaskStatus $taskStatus)
    {
        //
    }


    public function update(Request $request, TaskStatus $taskStatus)
    {
        //
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
