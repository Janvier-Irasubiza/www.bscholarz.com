@section('title', 'Create account')

<x-rhythm-box>

<x-slot name="header">
</slot>

<div class="client-body cst-h-middle d-flex justify-content-center px-0 mt-4">
<div style="background: none;" class="w-full px-6 py-4 pt-2 overflow-hidden sm:rounded-lg">

        <div class="d-flex justify-content-center align-items-center py-3 mb-4" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
                <h3 style="font-size: 25px" class="mb-2">Create new account </h3>
        </div>

    <form method="POST" action="{{ route('rhythmbox.create') }}">
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

         <!-- Email Address -->
         <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="Phone number" required autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
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

        <div class="flex items-center justify-center mt-4">

            <x-primary-button class="apply-btn px-5">
                {{ __('Create account') }}
            </x-primary-button>
        </div>
    </form>

    </div>

</div>


</x-rhythm-box>
