<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskManager') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <script
          src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous">
        </script>

        <script>
          $(document).ready(function() {
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
          });
        </script>

        <style>
          body {
            font-family: 'Nunito', sans-serif;
          }
          .alert {
            border-radius: 0.25rem;
            margin-bottom: 1rem;
            width: 100%;
            white-space: nowrap;
            display: block;
          }
          .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
          }
          .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
          }
        </style>

    </head>

    <body>
      <div id="app">

        <header class="fixed w-full">
          @include('layouts.navigation')
        </header>

        <section class="bg-white dark:bg-gray-900">
          <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">

            <div class="grid col-span-full">
              <div class="container">
                @include('flash::message')
              </div>
              @yield('content')
            </div>

          </div>
        </section>

      </div>
    </body>
</html>
