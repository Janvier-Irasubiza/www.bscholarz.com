
@section('title', 'login')

<x-guest-layout>

<div class="client-body w-full h-middle d-flex justify-content-center" style="width: 100%; margin: auto;">

<div style="background: none;" class="w-full sm:max-w-md mt-0 px-6 py-4 pt-0 overflow-hidden sm:rounded-lg">

        <div class="d-flex justify-content-center align-items-center mb-5 py-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">

                <h1 style="font-size: 30px" class="ml-3 mb-2">Login</h1>

</div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

  <?php /*  action="{{ route('error') */ ?>
    <form method="POST" action="{{ route('staff-login') }}">
        @csrf

      @if($errors->has('pass_changed'))

      <div>
        <x-input-error :messages="$errors->get('pass_changed')" class="mt-4 mb-3 text-left text-success" />
      </div>

      @endif

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Your email or phone number" required autofocus autocomplete="username" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember" style="border-radius: 4px; border: 1.5px solid #505050">
                <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm hover:text-black-900 dark:hover:text-black-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('staff-password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3 apply-btn" style="border: none">
                {{ __('Log in') }}
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
