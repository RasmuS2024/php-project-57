@extends('layouts.app')

@section('content')
<h1 class="mb-5 self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ __('label.edit_title') }}</h1>
{{ html()->modelForm($label, 'PATCH', route('labels.update', $label))->class('flex flex-col')->open() }}
    <div class="flex flex-col">
        <div>
            {{ html()->label(__('label.fields.name'), 'name') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('name'), 'border-red-500')
                ->required()
            }}
            @error('name')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mt-4">
            {{ html()->label(__('label.fields.description'), 'description') }}
        </div>
        <div class="mt-2">
            {{ html()->textarea('description')
                ->class('rounded border-gray-300 w-1/3 h-32')
                ->classIf($errors->has('description'), 'border-red-500')
            }}
            @error('description')
                <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
            @enderror
        </div>
        <div class="mt-4">
            {{ html()->button(__('label.update_button'))
                ->type('submit')
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
            }}
        </div>
    </div>
{{ html()->form()->close() }}
@endsection
