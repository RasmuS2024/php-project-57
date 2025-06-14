@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('label.create_title') }}</h1>
{{ html()->form('POST', route('labels.store'))->class('flex flex-col')->open() }}
    <div class="flex flex-col">
        <div>
            {{ html()->label(__('label.fields.name'), 'name') }}
        </div>
        <div class="mt-2">
            {{ html()->text('name')
                ->value(old('name'))
                ->class('rounded border-gray-300 w-1/3')
                ->classIf($errors->has('name'), 'border-red-500')
                ->attribute('autocomplete', 'off')
            }}
            @error('name')
                <div class="text-rose-600">{{ $message }}</div>
            @enderror
        </div>
        <div class="mt-4">
            {{ html()->label(__('label.fields.description'), 'description') }}
        </div>
        <div class="mt-2">
            {{ html()->textarea('description')
                ->value(old('description'))
                ->class('rounded border-gray-300 w-1/3 h-32')
                ->classIf($errors->has('description'), 'border-red-500')
            }}
        </div>
        <div class="mt-4">
            {{ html()->button(__('label.create_button'))
                ->type('submit')
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
            }}
        </div>
    </div>
{{ html()->form()->close() }}
@endsection
