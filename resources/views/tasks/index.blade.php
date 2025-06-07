@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
  <div class="max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:py-16 lg:pt-28">
    @if(session('alert'))
        <div class="alert alert-{{ session('alert.type') }}  col-span-full mb-4 p-4 rounded-lg">
            {{ session('alert.message') }}
        </div>
    @endif
    <div class="grid col-span-full">
      <h1 class="mb-5">Задачи</h1>
      <div class="w-full flex items-center">
        <form method="GET" action="{{ route('tasks.index') }}">
          <div class="flex">
            <select class="rounded border-gray-300" name="filter[status_id]" id="filter_status_id">
              <option value="" selected>Статус</option>
              @foreach($statuses as $id => $name)
                <option value="{{ $id }}" {{ request('filter.status_id') == $id ? 'selected' : '' }}>
                  {{ $name }}
                </option>
              @endforeach
            </select>
            <select class="rounded border-gray-300" name="filter[created_by_id]" id="filter_created_by_id">
              <option value="" selected>Автор</option>
              @foreach($users as $id => $name)
                <option value="{{ $id }}" {{ request('filter.created_by_id') == $id ? 'selected' : '' }}>
                  {{ $name }}
                </option>
              @endforeach
            </select>
            <select class="rounded border-gray-300" name="filter[assigned_to_id]" id="filter_assigned_to_id">
              <option value="" selected>Исполнитель</option>
              @foreach($users as $id => $name)
                <option value="{{ $id }}" {{ request('filter.assigned_to_id') == $id ? 'selected' : '' }}>
                  {{ $name }}
                </option>
              @endforeach
            </select>

            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" type="submit">
              Применить
            </button>
          </div>
        </form>
        
        @auth
          <div class="ml-auto">
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
              Создать задачу
            </a>
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
            <th class="p-2">Действия</th>
          </tr>
        </thead>
        <tbody>
          @foreach($tasks as $task)
            <tr class="border-b border-dashed text-left">
              <td class="p-2">{{ $task->id }}</td>
              <td class="p-2">{{ $task->status->name }}</td>
              <td class="p-2">
                <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.show', $task) }}">
                  {{ $task->name }}
                </a>
              </td>
              <td class="p-2">{{ $task->creator->name }}</td>
              <td class="p-2">{{ $task->assignee->name ?? '-' }}</td>
              <td class="p-2">{{ $task->created_at->format('d.m.Y') }}</td>
              <td class="p-2">
                <div class="flex items-center space-x-2">
                  @auth
                    @if($task->created_by_id === auth()->id())
                      <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                        @csrf
                        @method('DELETE')
                        <button 
                          type="submit" 
                          class="text-red-600 hover:text-red-900"
                          onclick="return confirm('Вы уверены?')"
                        >
                          Удалить 
                        </button>
                      </form>&nbsp;
                    @endif
                  @endauth
                   
                   <a class="text-blue-600 hover:text-blue-900" href="{{ route('tasks.edit', $task) }}">
                     Изменить
                  </a>
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