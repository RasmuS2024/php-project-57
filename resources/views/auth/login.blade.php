<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <h2 class="text-center"><a href="/">@lang('auth.app_name')</a></h2>

    @if($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">
                @lang('auth.login.error_header')
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
        <div>
            <x-input-label class="block font-medium text-sm text-gray-700" for="email" :value="__('auth.login.email')" />
            <x-text-input id="email" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus/>
        </div>

        <div class="mt-4">
            <x-input-label class="block font-medium text-sm text-gray-700" for="password" :value="__('auth.login.password')" />
            <x-text-input id="password" class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" name="remember">
                <span class="ml-2 text-sm text-gray-600">@lang('auth.login.remember')</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    @lang('auth.login.forgot_password')
                </a>
            @endif
            
            <button type="submit" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-3">
              @lang('auth.login.submit')
            </button>
        </div>
    </form>
</x-guest-layout>
