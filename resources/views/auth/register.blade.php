@section('title', 'Create account')

<x-guest-layout>


<div class="client-body w-full h-middle d-flex justify-content-center" style="width: 100%; margin: auto;">

<div style="background: none;" class="w-full sm:max-w-md mt-6 px-6 py-4 pt-2 overflow-hidden sm:rounded-lg">

        <div class="d-flex justify-content-center align-items-center mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
                <h1 style="font-size: 30px" class="ml-3 mb-2">Join Our Community</h1>
            </div>
  
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Names')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Full name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="username@example.com" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Create password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            placeholder="Confirm password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <div class="mt-5 d-flex justify-content-center">
            {!! NoCaptcha::display() !!}
        </div>

        <div class="mt-3 mb-4">
            @if ($errors->has('g-recaptcha-response'))
                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
            @endif
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm hover:text-black-900 dark:hover:text-black-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4 apply-btn">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    </div>


</div>
</div>

<div class="mt-5 d-flex justify-content-center">
        <div class="col-lg-4 px-5">
        @include('layouts.full-footer')
        </div>
    </div>
</x-guest-layout>
