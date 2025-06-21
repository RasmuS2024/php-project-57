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
