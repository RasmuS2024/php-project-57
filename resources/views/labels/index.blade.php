@php use Spatie\Html\Facades\Html; @endphp
@extends('layouts.app')

@section('content')
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
                        <div class="flex items-center space-x-4">
                            {{ html()->a('#', 'Удалить')
                                ->class('text-red-600 hover:text-red-900')
                                ->attribute('onclick', 'event.preventDefault(); if(confirm(\'Вы уверены?\')) { document.getElementById(\'delete-form-'.$label->id.'\').submit() }')
                                ->attribute('dusk', 'delete-link-'.$label->id)
                            }}
                            {{ html()->form('DELETE', route('labels.destroy', $label))
                                ->id('delete-form-'.$label->id)
                                ->class('hidden')
                                ->open()
                            }}
                            {{ html()->form()->close() }}
                            &nbsp;
                            {{ html()->a(route('labels.edit', $label), 'Изменить')
                                ->class('text-blue-600 hover:text-blue-900')
                                ->attribute('dusk', 'edit-link-'.$label->id)
                            }}
                        </div>
                    </td>
                @endauth
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
