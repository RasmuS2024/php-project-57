<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        @lang('auth.verify.message')
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            @lang('auth.verify.link_sent')
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-primary-button>
                    @lang('auth.verify.resend_button')
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                @lang('auth.verify.logout')
            </button>
        </form>
    </div>
</x-guest-layout>
