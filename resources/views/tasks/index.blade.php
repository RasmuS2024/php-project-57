@extends('layouts.app')

@section('content')
<h1 class="mb-5">@lang('task.index.title')</h1>

<div class="w-full flex items-center justify-between mb-4">
    <div class="flex items-center space-x-2">
        {{ html()->form('GET', route('tasks.index'))->class('flex items-center space-x-2')->open() }}
            <div>
                {{ html()->select('filter[status_id]', collect(['' => __('task.index.filters.status')])->union($statuses))
                    ->class('rounded border-gray-300 p-2')
                    ->value(request()->input('filter.status_id', null))
                }}
            </div>
            
            <div>
                {{ html()->select('filter[created_by_id]', collect(['' => __('task.index.filters.author')])->union($users))
                    ->class('rounded border-gray-300 p-2')
                    ->value(request()->input('filter.created_by_id', null))
                }}
            </div>
            
            <div>
                {{ html()->select('filter[assigned_to_id]', collect(['' => __('task.index.filters.assignee')])->union($users))
                    ->class('rounded border-gray-300 p-2')
                    ->value(request()->input('filter.assigned_to_id', null))
                }}
            </div>
            
            <div class="flex space-x-2">
                {{ html()->submit(__('task.index.buttons.apply'))
                    ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                }}
                
                <a href="{{ route('tasks.index') }}" class="bg-blue-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    @lang('task.index.buttons.reset')
                </a>
            </div>
        {{ html()->form()->close() }}
    </div>
    
    @auth
        <div>
            {{ html()->a(route('tasks.create'), __('task.index.buttons.create'))
                ->class('bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded')
            }}
        </div>
    @endauth
</div>

<table class="mt-4 w-full">
    <thead class="border-b-2 border-solid border-black text-left">
        <tr>
            <th class="p-2">@lang('task.index.columns.id')</th>
            <th class="p-2">@lang('task.index.columns.status')</th>
            <th class="p-2">@lang('task.index.columns.name')</th>
            <th class="p-2">@lang('task.index.columns.author')</th>
            <th class="p-2">@lang('task.index.columns.assignee')</th>
            <th class="p-2">@lang('task.index.columns.created_at')</th>
            @auth
            <th class="p-2">@lang('task.index.columns.actions')</th>
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
                @auth
                    <td class="p-2">
                        <div class="flex items-center space-x-2">
                            {{ html()->a(route('tasks.edit', $task), __('task.index.buttons.edit'))
                                ->class('text-blue-600 hover:text-blue-900')
                                ->attribute('dusk', 'edit-link-'.$task->id)
                            }}
                            
                            @if($task->created_by_id === auth()->id())
                                {{ html()->a('#', __('task.index.buttons.delete'))
                                    ->class('text-red-600 hover:text-red-900')
                                    ->attribute('onclick', "event.preventDefault();
                                        if(confirm('".__('task.index.delete_confirmation')."')) {
                                            document.getElementById('delete-form-{$task->id}').submit()
                                        }")
                                }}
                                {{ html()->form('DELETE', route('tasks.destroy', $task))
                                    ->id("delete-form-{$task->id}")
                                    ->class('hidden')
                                    ->open()
                                }}
                                {{ html()->form()->close() }}
                            @endif
                        </div>
                    </td>
                @endauth
            </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $tasks->appends(request()->input())->links('vendor.pagination.tailwind') }}
</div>
@endsection
