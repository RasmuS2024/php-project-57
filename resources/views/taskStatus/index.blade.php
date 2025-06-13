@extends('layouts.app')

@section('content')
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
                    <td class="p-2">
                        <div class="flex items-center space-x-4">
                            {{ html()->a('#', 'Удалить')
                                ->class('text-red-600 hover:text-red-900')
                                ->attribute('onclick', 'event.preventDefault(); if(confirm(\'Вы уверены?\')) { document.getElementById(\'delete-form-'.$status->id.'\').submit() }')
                                ->attribute('dusk', 'delete-link-'.$status->id)
                            }}
                            {{ html()->form('DELETE', route('task_statuses.destroy', $status))
                                ->id('delete-form-'.$status->id)
                                ->class('hidden')
                                ->open()
                            }}
                            {{ html()->form()->close() }}
                            &nbsp;
                            {{ html()->a(route('task_statuses.edit', $status), 'Изменить')
                                ->class('text-blue-600 hover:text-blue-900')
                                ->attribute('dusk', 'edit-link-'.$status->id)
                            }}
                        </div>
                    </td>
                @endauth
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
