<section>
    <header>
        <h2 style="color: #000" class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    @if(Auth::guard('staff'))
    <div class="mt-4 p-3 border rounded">
        Working percentage  <br>
        <p class="text-muted mb-0" style="text-transform: none; font-size: 26px">{{ Auth::guard('staff')->user()->percentage }}% </p>
    </div>
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            
            @if(Auth::guard('staff'))

            <x-text-input id="name" name="names" type="text" class="mt-1 block w-full" :value="old('name', Auth::guard('staff')-> user()->names)" readonly autocomplete="name" />

            @else

            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />


            @endif
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />

            @if(Auth::guard('staff'))

            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', Auth::guard('staff')-> user()->email)" readonly autocomplete="username" />

            @else
            
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />

            @endif
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="Phone" :value="__('Phone number')" />

            @if(Auth::guard('staff'))

            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ Auth::guard('staff')-> user()->phone_number }}" readonly autocomplete="phone" />

            @else

            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ $user->phone_number }}" required autocomplete="phone" />


            @endif
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="flex items-center gap-4">
        <x-primary-button class="apply-btn" style="border: none">
                {{ __('save changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
