@php use Spatie\Html\Facades\Html; @endphp
@extends('layouts.app')

@section('content')
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            @if(session('alert'))
            <div class="alert alert-{{ session('alert.type') }} col-span-full mb-4 p-4 rounded-lg">
                {{ session('alert.message') }}
            </div>
            @endif
            
            <div class="grid col-span-full">
                <h1 class="mb-5">Метки</h1>
                
                @auth
                    <div>
                        {!! Html::a(route('labels.create'), 'Создать метку')
                            ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') 
                        !!}
                    </div>
                @endauth

                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Описание</th>
                            <th>Дата создания</th>
                            @auth
                                <th>Действия</th>
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($labels as $label)
                            <tr class="border-b border-dashed text-left">
                                <td>{{ $label->id }}</td>
                                <td>{{ $label->name }}</td>
                                <td>{{ $label->description }}</td>
                                <td>{{ $label->created_at->format('d.m.Y') }}</td>
                                @auth
                                    <td>
                                        <div class="flex items-center">
                                            {!! Html::a(route('labels.edit', $label), 'Изменить')
                                                ->class('text-blue-600 hover:text-blue-900') 
                                            !!}
                                            
                                            {!! Html::form()
                                                ->action(route('labels.destroy', $label))
                                                ->method('POST') // Основной метод - POST
                                                ->class('ml-2 inline')
                                                ->children([
                                                    Html::hidden('_method')->value('DELETE'), // Переопределение метода
                                                    Html::token(), // CSRF-токен
                                                    Html::button('Удалить')
                                                        ->type('submit')
                                                        ->class('text-red-600 hover:text-red-900 bg-transparent border-none p-0 cursor-pointer')
                                                        ->attribute('onclick', "return confirm('Вы уверены?')")
                                                ])
                                            !!}
                                        </div>
                                    </td>
                                @endauth
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection