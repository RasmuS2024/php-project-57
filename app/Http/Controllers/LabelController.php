<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::paginate(10);
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
        return redirect()->route('labels.index')->with('success', 'Метка создана');
    }

    public function show(Label $label)
    {
        return view('labels.show', compact('label'));
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
        return redirect()->route('labels.index')->with('success', 'Метка обновлена');
    }

    public function destroy(Label $label)
    {
        $label->delete();
        return redirect()->route('labels.index')->with('success', 'Метка удалена');
    }
}
