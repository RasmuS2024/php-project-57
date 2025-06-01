@extends('layouts.app') <!-- Если используете мастер-шаблон -->

@section('content')
    <div class="container">
        <h1 class="mb-5">Метки</h1>
        
        <!-- Здесь будет вывод меток -->
        <div class="mt-4">
            @foreach($labels as $label)
                <div>{{ $label->name }}</div>
            @endforeach
        </div>
    </div>
@endsection