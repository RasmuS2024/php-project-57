<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskManager') }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
      <div class="container">
        @include('flash::message') {{-- Основной вывод сообщений --}}
      </div>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script>
        $(document).ready(function() {
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
        });
      </script>

      <div id="app">
        <header class="fixed w-full">
            @include('layouts.navigation')
        </header>
            @yield('content')
        </div>
    </body>
</html>
