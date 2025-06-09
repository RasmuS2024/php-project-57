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
            <h1 class="mb-5">Статусы</h1>
            
            @auth
                <div>
                    {{ html()->a(route('task_statuses.create'), 'Создать статус')
                        ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded') }}
                </div>
            @endauth

            <table class="mt-4">
                <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Дата создания</th>
                        @auth
                            <th>Действия</th>
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($taskStatuses as $status)
                        <tr class="border-b border-dashed text-left">
                            <td>{{ $status->id }}</td>
                            <td>{{ $status->name }}</td>
                            <td>{{ $status->created_at->format('d.m.Y') }}</td>
                            @auth
                                <td>
                                    <div class="flex items-center"> 
                                        {{ html()->a(route('task_statuses.edit', $status), 'Изменить')
                                            ->class('text-blue-600 hover:text-blue-900') }}
                                        
                                        {{ html()->form('DELETE', route('task_statuses.destroy', $status))
                                            ->class('ml-2')
                                            ->open() }}
                                            @csrf
                                            {{ html()->button('Удалить')
                                                ->type('submit')
                                                ->class('text-red-600 hover:text-red-900')
                                                ->attribute('onclick', "return confirm('Вы уверены?')") }}
                                        {{ html()->form()->close() }}
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
