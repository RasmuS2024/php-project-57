@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:py-16 lg:pt-28">
        @if(session('alert'))
            <div class="alert alert-{{ session('alert.type') }} col-span-full mb-4 p-4 rounded-lg">
                {{ session('alert.message') }}
            </div>
        @endif
        
        <div class="grid col-span-full">
            <h1 class="mb-5">Задачи</h1>
            
            <div class="w-full flex items-center">
                {{ html()->form('GET', route('tasks.index'))->class('flex')->open() }}
                    <div class="flex">
                        {{ html()->select('filter[status_id]', collect(['' => 'Статус'])->union($statuses))
                            ->class('rounded border-gray-300')
                            ->value(request('filter.status_id'))
                            ->id('filter_status_id')
                        }}
                        
                        {{ html()->select('filter[created_by_id]', collect(['' => 'Автор'])->union($users))
                            ->class('rounded border-gray-300')
                            ->value(request('filter.created_by_id'))
                            ->id('filter_created_by_id')
                        }}
                        
                        {{ html()->select('filter[assigned_to_id]', collect(['' => 'Исполнитель'])->union($users))
                            ->class('rounded border-gray-300')
                            ->value(request('filter.assigned_to_id'))
                            ->id('filter_assigned_to_id')
                        }}
                        
                        {{ html()->button('Применить')
                            ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2')
                            ->type('submit')
                        }}
                    </div>
                {{ html()->form()->close() }}
                
                @auth
                    <div class="ml-auto">
                        {{ html()->a(route('tasks.create'), 'Создать задачу')
                            ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2')
                        }}
                    </div>
                @endauth
            </div>
            
            <table class="mt-4 w-full">
                <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th class="p-2">ID</th>
                        <th class="p-2">Статус</th>
                        <th class="p-2">Имя</th>
                        <th class="p-2">Автор</th>
                        <th class="p-2">Исполнитель</th>
                        <th class="p-2">Дата создания</th>
                        @auth
                        <th class="p-2">Действия</th>
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $task)
                        <tr class="border-b border-dashed text-left">
                            <td class="p-2">{{ $task->id }}</td>
                            <td class="p-2">{{ $task->status->name }}</td>
                            <td class="p-2">
                                {{ html()->a(route('tasks.show', $task), $task->name)
                                    ->class('text-blue-600 hover:text-blue-900')
                                }}
                            </td>
                            <td class="p-2">{{ $task->creator->name }}</td>
                            <td class="p-2">{{ $task->assignee->name ?? '-' }}</td>
                            <td class="p-2">{{ $task->created_at->format('d.m.Y') }}</td>
                            <td class="p-2">
                                <div class="flex items-center space-x-2">
                                    @auth
                                        @if($task->created_by_id === auth()->id())
                                            {{ html()->form('DELETE', route('tasks.destroy', $task))->open() }}
                                                {{ html()->button('Удалить')
                                                    ->class('text-red-600 hover:text-red-900')
                                                    ->type('submit')
                                                    ->attribute('onclick', 'return confirm("Вы уверены?")')
                                                }}
                                            {{ html()->form()->close() }}
                                        @endif
                                    {{ html()->a(route('tasks.edit', $task), 'Изменить')
                                        ->class('text-blue-600 hover:text-blue-900')
                                    }}
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $tasks->appends(request()->input())->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</section>
@endsection
