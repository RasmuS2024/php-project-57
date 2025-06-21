@extends('layouts.app')

@section('content')
<h1 class="mb-5 self-center text-2xl font-semibold whitespace-nowrap dark:text-white">@lang('task.index.title')</h1>

<div class="w-full flex items-center justify-between mb-4">
    <div class="flex items-center space-x-2">
        {{ html()->form('GET', route('tasks.index'))->class('flex items-center space-x-2')->open() }}
            <div>
                {{ html()->select('filter[status_id]', collect(['' => __('task.index.filters.status')])->union($statuses))
                    ->class('rounded border-gray-300 p-2 md:w-48')
                    ->value(request()->input('filter.status_id', null))
                }}
            </div>
            
            <div>
                {{ html()->select('filter[created_by_id]', collect(['' => __('task.index.filters.author')])->union($users))
                    ->class('rounded border-gray-300 p-2 md:w-48')
                    ->value(request()->input('filter.created_by_id', null))
                }}
            </div>
            
            <div>
                {{ html()->select('filter[assigned_to_id]', collect(['' => __('task.index.filters.assignee')])->union($users))
                    ->class('rounded border-gray-300 p-2 md:w-48')
                    ->value(request()->input('filter.assigned_to_id', null))
                }}
            </div>
            
            <div class="flex space-x-2">
                {{ html()->submit(__('task.index.buttons.apply'))
                    ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
                }}

                {{ html()->a(route('tasks.index'), __('task.index.buttons.reset'))
                    ->class('bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap')
                }}
            </div>
        {{ html()->form()->close() }}
    </div>
    
    @auth
        <div class="flex space-x-2">
            {{ html()->a(route('tasks.create'), __('task.index.buttons.create'))
                ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
            }}
        </div>
    @endauth

</div>

<table class="mt-4">
    <thead class="border-b-2 border-solid border-black text-left">
        <tr>
            <th>@lang('task.index.columns.id')</th>
            <th>@lang('task.index.columns.status')</th>
            <th>@lang('task.index.columns.name')</th>
            <th>@lang('task.index.columns.author')</th>
            <th>@lang('task.index.columns.assignee')</th>
            <th>@lang('task.index.columns.created_at')</th>
            @auth
            <th>@lang('task.index.columns.actions')</th>
            @endauth
        </tr>
    </thead>
    <tbody>
        @foreach($tasks as $task)
            <tr class="border-b border-dashed text-left">
                <td style="text-align: center">{{ $task->id }}</td>
                <td class="break-all" style="text-align: center">{{ $task->status->name }}</td>
                <td class="break-all">
                    {{ html()->a(route('tasks.show', $task), $task->name)
                        ->class('text-blue-600 hover:text-blue-900')
                    }}
                </td>
                <td>{{ $task->creator->name }}</td>
                <td>{{ $task->assignee->name ?? '-' }}</td>
                <td>{{ $task->created_at->format('d.m.Y') }}</td>
                @auth
                    <td>
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
