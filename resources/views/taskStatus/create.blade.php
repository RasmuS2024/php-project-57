@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5">Создать статус</h1>

            {{ html()->form('POST', route('task_statuses.store'))->class('w-50')->open() }}
                @csrf
                
                <div class="flex flex-col">
                    <div>
                        {{ html()->label('Имя', 'name') }}
                    </div>
                    <div class="mt-2">
                        {{ html()->text('name')
                            ->value(old('name'))
                            ->class('rounded border-gray-300 w-1/3')
                            ->classIf($errors->has('name'), 'border-red-500')
                            ->id('name') }}
                        
                        @error('name')
                            <div class="text-rose-600">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mt-2">
                        {{ html()->button('Создать')
                            ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                            ->type('submit') }}
                    </div>
                </div>
            {{ html()->form()->close() }}
        </div>
    </div>
</section>
@endsection
