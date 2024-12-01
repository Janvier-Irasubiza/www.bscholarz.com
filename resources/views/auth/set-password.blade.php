@section('title', 'Set Password')

<x-apply-layout>
    <div class="client-body padding mt-2 sm-section mb-5 w-full">
        <div style="min-height: 70vh; display: flex; justify-content: center; align-items: center;">
            <div style="border-radius: 8px; padding: 1.5rem; width: 100%; max-width: 500px;"
                class="overflow-hidden d-flex justify-content-center bg-white shadow-md">
                <form method="POST" action="{{ route('password.set-new') }}" class="w-full">
                    @csrf

                    <div class="d-flex align-items-center gap-4 mb-4 border rounded-lg p-3">
                        <i class="fa-regular fa-user text-muted" style="font-size: 3em"></i>
                        <div>
                            <h1 style="font-size: 1.5em">{{ $user->names }}</h1>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>
                    </div>

                    <h2 class="muted-text" style="font-size: 1.5em">Set Password</h2>

                    <!-- Password -->
                    <div class="mt-3">
                        <x-input-label for="password" :value="__('Password')" />
                        <input type="hidden" name="email" class="w-full" value="{{ $user->email }}">
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" placeholder="Enter you password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Re-enter your password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end mt-4">
                        <button class="apply-btn w-full py-2 text-center">
                            {{ __('Set Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-apply-layout>