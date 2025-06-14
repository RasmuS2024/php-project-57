<x-guest-layout>
    <h2 class="text-center"><a href="{{ route('home') }}">@lang('auth.app_name')</a></h2>

    @if($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">
                @lang('auth.register.error_header')
            </div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('auth.register.name')" />
            <x-text-input id="name" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('auth.register.email')" />
            <x-text-input id="email" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('auth.register.password')" />
            <x-text-input id="password" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('auth.register.confirmation')" />
            <x-text-input id="password_confirmation" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                @lang('auth.register.already_registered')
            </a>

            <button class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4">
                @lang('auth.register.submit')
            </button>
        </div>
    </form>
</x-guest-layout>
