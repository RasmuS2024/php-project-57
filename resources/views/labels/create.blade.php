@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5">Создать метку</h1>
            {{ html()->form('POST', route('labels.store'))->class('flex flex-col')->open() }}
                <div class="flex flex-col">
                    <div>
                        {{ html()->label('Имя', 'name') }}
                    </div>
                    <div class="mt-2">
                        {{ html()->text('name')
                            ->value(old('name'))
                            ->class('rounded border-gray-300 w-1/3')
                            ->classIf($errors->has('name'), 'border-red-500')
                            ->required()
                            ->attribute('autocomplete', 'off')
                        }}
                        @error('name')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        {{ html()->label('Описание', 'description') }}
                    </div>
                    <div class="mt-2">
                        {{ html()->textarea('description')
                            ->value(old('description'))
                            ->class('rounded border-gray-300 w-1/3 h-32')
                            ->classIf($errors->has('description'), 'border-red-500')
                        }}
                        @error('description')
                            <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mt-4">
                        {{ html()->button('Создать')
                            ->type('submit')
                            ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                        }}
                    </div>
                </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</section>
@endsection