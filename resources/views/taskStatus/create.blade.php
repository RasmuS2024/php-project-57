@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('status.create') }}</h1>

{{ html()->form('POST', route('task_statuses.store'))->class('w-50')->open() }}
    @csrf
    
    <div class="flex flex-col">
        <div>
            {{ html()->label(__('status.fields.name'), 'name') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')
                ->value(old('name'))
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('name'), 'border-red-500')
                ->id('name')
                ->required() }}
            
            @error('name')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mt-2">
            {{ html()->button(__('status.create_button'))
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                ->type('submit') }}
        </div>
    </div>
{{ html()->form()->close() }}
@endsection
