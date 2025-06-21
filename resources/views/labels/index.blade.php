@extends('layouts.app')

@section('content')
<h1 class="mb-5">{{ __('label.index_title') }}</h1>
@auth
    <div>
        {{ html()->a(route('labels.create'), __('label.create_title'))
            ->class('bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
        }}
    </div>
@endauth
<table class="mt-4">
    <thead class="border-b-2 border-solid border-black text-left">
        <tr>
            <th>{{ __('label.fields.id') }}</th>
            <th>{{ __('label.fields.name') }}</th>
            <th>{{ __('label.fields.description') }}</th>
            <th>{{ __('label.fields.created_at') }}</th>
            @auth
                <th>{{ __('label.actions') }}</th>
            @endauth
        </tr>
    </thead>
    <tbody>
        @foreach($labels as $label)
            <tr class="border-b border-dashed text-left">
                <td>{{ $label->id }}</td>
                <td class="break-all">{{ $label->name }}</td>
                <td class="break-all">{{ $label->description }}</td>
                <td>{{ $label->created_at->format('d.m.Y') }}</td>
                @auth
                    <td>
                        <div class="flex items-center space-x-4">
                            {{ html()->a('#', __('common.delete'))
                                ->class('text-red-600 hover:text-red-900')
                                ->attribute('onclick', 'event.preventDefault();
                                    if(confirm(\''.__('common.delete_confirm').'\')) {
                                        document.getElementById(\'delete-form-'.$label->id.'\').submit()
                                    }')
                                ->attribute('dusk', 'delete-link-'.$label->id)
                            }}
                            {{ html()->form('DELETE', route('labels.destroy', $label))
                                ->id('delete-form-'.$label->id)
                                ->class('hidden')
                                ->open()
                            }}
                            {{ html()->form()->close() }}
                            &nbsp;
                            {{ html()->a(route('labels.edit', $label), __('common.edit'))
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
