@extends('layouts.app')

@section('content')
<h1 class="mb-5">Изменение задачи</h1>
{{ html()->modelForm($task, 'PATCH', route('tasks.update', $task))->class('w-50')->open() }}
    <div class="flex flex-col">
        <div>
            {{ html()->label('Имя', 'name') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('name'), 'border-red-500')
                ->value(old('name', $task->name))
                ->required()
            }}
            @error('name')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->label('Описание', 'description') }}
        </div>
        <div>
            {{ html()->textarea('description')
                ->class('rounded border-gray-300 w-1/3 h-32')
                ->classIf($errors->has('description'), 'border-red-500')
                ->value(old('description', $task->description))
            }}
            @error('description')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->label('Статус', 'status_id') }}
        </div>
        <div>
            {{ html()->select('status_id', $statuses->pluck('name', 'id'))
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('status_id'), 'border-red-500')
                ->value(old('status_id', $task->status_id))
                ->placeholder('')
                ->required()
            }}
            @error('status_id')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->label('Исполнитель', 'assigned_to_id') }}
        </div>
        <div>
            {{ html()->select('assigned_to_id', collect(['' => ''])->union($users->pluck('name', 'id')))
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('assigned_to_id'), 'border-red-500')
                ->value(old('assigned_to_id', $task->assigned_to_id))
            }}
            @error('assigned_to_id')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->label('Метки', 'labels') }}
        </div>
        <div>
            {{ html()->multiselect('labels[]', $labels->pluck('name', 'id'))
                ->class('rounded border-gray-300 w-1/3 h-32')
                ->classIf($errors->has('labels'), 'border-red-500')
                ->value(old('labels', $task->labels->pluck('id')->toArray()))
            }}
            @error('labels')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->button('Обновить')
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                ->type('submit')
            }}
        </div>
    </div>
{{ html()->form()->close() }}
@endsection
