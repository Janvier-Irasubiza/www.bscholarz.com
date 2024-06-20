@section('title', 'Reset password')

<x-forgot-password-layout>

<div class="client-body w-full h-middle d-flex justify-content-center" style="width: 100%; margin: auto;">

<div>
    <div class="mb-4 text-sm">
        {{ __('Forgot your password?') }} <br><br> {{ __('Let us know your email address and we will email you a password reset link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="Type your email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="d-flex items-center mb-4 justify-between mt-4">
        <a class="underline text-sm hover:text-black-900 dark:hover:text-black-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black-500 dark:focus:ring-offset-black-800" href="{{ route('admin.auth') }}">
                {{ __('Back to Sign in') }}
            </a>

            <x-primary-button class="apply-btn">
                {{ __('Get password reset Link') }}
            </x-primary-button>
        </div>
    </form>

</div>

</div>
</x-forgot-password-layout>
