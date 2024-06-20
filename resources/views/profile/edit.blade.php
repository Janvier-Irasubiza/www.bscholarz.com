<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="px-3 lg:px-8 space-y-6">
            <div class="sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="d-flex gap-5 justify-content-between px-4 ">


                    <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="w-full">
                    @include('profile.partials.update-password-form')
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
