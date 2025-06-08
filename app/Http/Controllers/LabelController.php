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
        $labels = Label::paginate(15);
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
            'description' => 'nullable|string'
        ]);

        Label::create($request->all());
        return redirect()->route('labels.index')->with('alert', [
                                    'type' => 'success',
                                    'message' => 'Метка создана'
                                ]);
    }

    public function show($id)
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
        return redirect()->route('labels.index')->with('alert', [
                                    'type' => 'success',
                                    'message' => 'Метка обновлена'
                                ]);
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            return redirect()->route('labels.index')
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Не удалось удалить метку'
                ]);
        }
        try {
            $label->delete();
            return redirect()->route('labels.index')
                             ->with('alert', [
                                    'type' => 'success',
                                    'message' => 'Метка успешно удалена'
                                ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return redirect()->route('labels.index')
                    ->with('alert', [
                        'type' => 'danger',
                        'message' => 'При удалении метки произошла ошибка: ' . $e->getMessage()
                    ]);
            }
        }
    }
}
