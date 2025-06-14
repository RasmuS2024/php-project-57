<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        @lang('auth.forgot_password.message')
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{ html()->form('POST', route('password.email'))->open() }}
        @csrf

        <div>
            {{ html()->label(__('auth.forgot_password.email'), 'email')->class('block font-medium text-sm text-gray-700') }}

            {{ html()->email('email')
                ->value(old('email'))
                ->required()
                ->autofocus()
                ->class('block mt-1 w-full border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm')
            }}

            @if ($errors->has('email'))
                <div class="mt-2 text-sm text-red-600">
                    {{ implode(' ', $errors->get('email')) }}
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            {{ html()->button(__('auth.forgot_password.submit'))
                ->type('submit')
                ->class('inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded')
            }}
        </div>
    {{ html()->form()->close() }}
</x-guest-layout>
