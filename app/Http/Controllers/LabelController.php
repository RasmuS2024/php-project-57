<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'description' => 'nullable|max:255',
        ], [
            'name.unique' => trans('validation.custom.name.unique', [
                'entity' => __('label.entity')
            ])
        ]);

        Label::create($request->all());
        flash(__('label.flash.created'))->success();
        return redirect()->route('labels.index');
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
            'description' => [
                'nullable',
                'max:255',
            ],
        ]);

        $label->update($request->all());
        flash(__('label.flash.updated'))->success();

        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('label.flash.delete_error'))->error();
            return redirect()->route('labels.index');
        }

        $label->delete();
        flash(__('label.flash.deleted'))->success();

        return redirect()->route('labels.index');
    }
}
