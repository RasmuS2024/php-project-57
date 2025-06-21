@extends('layouts.app')

@section('content')
<h1 class="mb-5 self-center text-2xl font-semibold whitespace-nowrap dark:text-white">@lang('task.create.title')</h1>
{{ html()->form('POST', route('tasks.store'))->class('w-50')->open() }}
    <div class="flex flex-col">
        <div>
            {{ html()->label(__('task.create.fields.name'), 'name') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('name'), 'border-red-500')
                ->value(old('name'))
                ->attribute('autocomplete', 'off')
            }}
            @error('name')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-2">
            {{ html()->label(__('task.create.fields.description'), 'description') }}
        </div>
        <div>
            {{ html()->textarea('description')
                ->class('rounded border-gray-300 w-1/3 h-32')
                ->classIf($errors->has('description'), 'border-red-500')
                ->value(old('description'))
            }}
            @error('description')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-2">
            {{ html()->label(__('task.create.fields.status'), 'status_id') }}
        </div>
        <div>
            {{ html()->select('status_id', $statuses->pluck('name', 'id'))
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('status_id'), 'border-red-500')
                ->placeholder(__('task.create.status_placeholder'))
                ->value(old('status_id'))
            }}
            @error('status_id')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-2">
            {{ html()->label(__('task.create.fields.assignee'), 'assigned_to_id') }}
        </div>
        <div>
            {{ html()->select('assigned_to_id', $users->pluck('name', 'id'))
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('assigned_to_id'), 'border-red-500')
                ->placeholder(__('task.create.assignee_placeholder'))
                ->value(old('assigned_to_id'))
            }}
            @error('assigned_to_id')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-2">
            {{ html()->label(__('task.create.fields.labels'), 'labels') }}
        </div>
        <div>
            {{ html()->multiselect('labels[]', $labels->pluck('name', 'id'))
                ->class('rounded border-gray-300 w-1/3 h-32')
                ->classIf($errors->has('labels'), 'border-red-500')
                ->value(old('labels', []))
            }}
            @error('labels')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mt-2">
            {{ html()->button(__('task.create.submit'))
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                ->type('submit')
            }}
        </div>
    </div>
{{ html()->form()->close() }}
@endsection
