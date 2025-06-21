<nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900 shadow-md">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
        <a href="{{ url('/') }}" class="flex items-center">
            <span class="self-center text-3xl font-semibold whitespace-nowrap dark:text-white">
                @lang('navigation.app_name')
            </span>
        </a>

        <div class="flex items-center lg:order-2">
            @auth
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                    @lang('navigation.auth.logout')
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    @lang('navigation.auth.login')
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                        @lang('navigation.auth.register')
                    </a>
                @endif
            @endauth
        </div>
        <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                <li>
                    <a href="{{ route('tasks.index') }}" class="block py-2 pl-3 pr-4 text-2xl text-gray-700 hover:text-blue-700 lg:p-0">
                        @lang('navigation.links.tasks')
                    </a>
                </li>
                <li>
                    <a href="{{ route('task_statuses.index') }}" class="block py-2 pl-3 pr-4 text-2xl text-gray-700 hover:text-blue-700 lg:p-0">
                        @lang('navigation.links.statuses')
                    </a>
                </li>
                <li>
                    <a href="{{ route('labels.index') }}" class="block py-2 pl-3 pr-4 text-2xl text-gray-700 hover:text-blue-700 lg:p-0">
                        @lang('navigation.links.labels')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
