<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Http\Requests\StoreLabelRequest;
use App\Http\Requests\UpdateLabelRequest;
use Illuminate\Support\Facades\Config;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::orderBy('id')->paginate(Config::get('pagination.per_page'));

        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        return view('labels.create');
    }

    public function store(StoreLabelRequest $request)
    {
        Label::create($request->validated());
        flash(__('label.flash.created'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(UpdateLabelRequest $request, Label $label)
    {
        $label->update($request->validated());
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
