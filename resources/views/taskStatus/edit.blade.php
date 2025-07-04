@extends('layouts.app')

@section('content')
<h1 class="mb-5 self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ __('status.edit') }}</h1>

{{ html()->modelForm($taskStatus, 'PUT', route('task_statuses.update', $taskStatus))->class('w-50')->open() }}
    <div class="flex flex-col">
        <div>
            {{ html()->label(__('status.fields.name'), 'name') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('name'), 'border-red-500')
                ->id('name')
                ->required() }}
                
            @error('name')
                <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->button(__('status.update_button'))
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                ->type('submit') }}
        </div>
    </div>
{{ html()->form()->close() }}
@endsection
