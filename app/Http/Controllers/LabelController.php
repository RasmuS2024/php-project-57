<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::orderBy('id')->paginate(15);
        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        return view('labels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:labels|max:255',
        ], [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => 'Метка'
            ])
        ]);

        Label::create($request->all());
        flash('Метка успешно создана')->success();
        return redirect()->route('labels.index');
    }

    public function show()
    {
        abort(403);
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('labels')->ignore($label->id)
            ],
            'description' => 'nullable|string'
        ]);

        $label->update($request->all());
        flash('Метка успешно изменена')->success();
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash('Не удалось удалить метку: метка связана с задачами')->error();
            return redirect()->route('labels.index');
        }

        try {
            $label->delete();
            flash('Метка успешно удалена')->success();
            return redirect()->route('labels.index');
        } catch (QueryException $e) {
            if ($e->getCode() === 23000) {
                flash('При удалении метки произошла ошибка: ' . $e->getMessage())->error();
                return redirect()->route('labels.index');
            }
            throw $e;
        }
    }
}
