@extends('layouts.app')

@section('content')
<h1 class="mb-5">Изменение статуса</h1>

{{ html()->form('PUT', route('task_statuses.update', $taskStatus))->class('w-50')->open() }}
    @csrf
    
    <div class="flex flex-col">
        <div>
            {{ html()->label('Имя', 'name') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')
                ->value(old('name', $taskStatus->name))
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('name'), 'border-red-500')
                ->id('name') }}
                
            @error('name')
                <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->button('Обновить')
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                ->type('submit') }}
        </div>
    </div>
{{ html()->form()->close() }}
@endsection
