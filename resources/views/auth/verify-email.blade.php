<x-guest-layout>

<div class="client-body w-full h-middle">

<div style="background: none;" class="w-full sm:max-w-md mt-6 px-6 py-4 pt-2 overflow-hidden sm:rounded-lg">

        <div class="d-flex justify-content-center align-items-center mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
                <a href="/" class="mb-2">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
                <h1 style="font-size: 30px" class="ml-3 mb-2">Verify your email</h1>

        </div>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-black-600 dark:text-black-400 hover:text-black-900 dark:hover:text-black-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

    </div>

    
<div class="mt-4">
    @include('layouts.full-footer')
</div>

</div>

</x-guest-layout>
