@extends('layouts.app')

@section('content')

<h2 class="mb-5 text-3xl font-bold break-all">
    @lang('task.show.title', ['name' => $task->name])
</h2>

<h2 class="mb-5 text-xl font-bold">
    {{ html()->a(route('tasks.edit', $task), '&#9881;изменить')->class('text-blue-600 hover:text-blue-900 text-2xl') }}
</h2>

<div class="space-y-3">
    <p class="break-all whitespace-normal"><span class="font-black">@lang('task.show.fields.name'):</span> {{ $task->name }}</p>
    <p class="break-all whitespace-normal"><span class="font-black">@lang('task.show.fields.status'):</span> {{ $task->status->name }}</p>
    <p class="break-all whitespace-normal"><span class="font-black">@lang('task.show.fields.description'):</span> {{ $task->description ?? __('task.show.empty_description') }}</p>
    
    @if($task->labels->isNotEmpty())
        <p><span class="font-black">@lang('task.show.fields.labels'):</span></p>
        <div>
            @foreach($task->labels as $label)
                <div class="text-xs inline-flex items-center font-bold leading-sm uppercase px-3 py-1 bg-blue-200 text-blue-700 rounded-full break-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    {{ $label->name }}
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
