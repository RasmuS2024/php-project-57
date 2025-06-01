<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <h2 class="text-center"><a href="/">Менеджер задач</a></h2>

    @if($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">
                Упс! Что-то пошло не так:
            </div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Address -->
        <div>
            <x-input-label class="block font-medium text-sm text-gray-700" for="email" :value="__('Email')" />
            <x-text-input id="email" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label class="block font-medium text-sm text-gray-700" for="password" :value="__('Пароль')" />
            <x-text-input id="password" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Запомнить меня') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Забыли пароль?') }}
                </a>
            @endif
            
            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-3">
              {{ __('Войти') }}
            </button>
        </div>
    </form>
</x-guest-layout>
