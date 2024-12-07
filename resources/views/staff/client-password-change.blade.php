@section('title', 'Customer - Details')

<x-staff-layout>

    <x-slot name="header">
    </x-slot>

    <div style="padding: 20px 32px" class="d-flex justify-content-center">
        <div class="bg-white dark:bg-gray-800 col-lg-6 p-4 overflow-hidden shadow-sm sm:rounded-lg p-2">
            <form action="{{ route('staff.update-client-password') }}" method="POST">
                @csrf

                <div class="d-flex align-items-center gap-4 mb-4 border rounded-lg p-3">
                    <i class="fa-regular fa-user text-muted" style="font-size: 3em"></i>
                    <div>
                        <h1 style="font-size: 1.5em">{{ $client->names }}</h1>
                        <p class="text-muted">{{ $client->email }}</p>
                    </div>
                </div>

                <h2 class="muted-text" style="font-size: 1.5em">Change Client Password</h2>

                <div class="mt-3">
                    <div class="mt-3">
                        <x-input-label for="password_confirmation" :value="__('New Password')" />
                        <input type="hidden" name="client_id" value="{{ $client->id }}">
                        <input type="hidden" name="application_id" value="{{ $application->app_id }}">
                        <input id="user_c" name="new_password" type="password"
                            style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                            class="mt-1 block w-full" placeholder="Enter new password" />
                        <x-input-error :messages="$errors->get('new_password')" class="mt-2 text-left" />
                    </div>
                    <div class="mt-3">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" name="new_password_confirmation"
                            style="padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 4px"
                            type="password" class="mt-1 block w-full" placeholder="Re-enter the password" />
                        <x-input-error :messages="$errors->get('new_password_confirmation')" class="mt-2 text-left" />
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="cst-primary-btn px-5 py-2 w-full mt-4">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</x-staff-layout>