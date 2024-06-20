@section('title', 'Profile')

<x-rhythm-box>

<x-slot name="header">
</slot>

<div class="py-2" style="padding: 0px 55px">
<div class="mt-5 mb-5">
        <div class="max-w-7xl mx-auto px-3 lg:px-8 space-y-6">
            <div class="sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex-section gap-5" >
            


            <form action="{{ route('partner-update-profile-pic') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="small-8 medium-2 large-2 columns img-section col-lg-2 pt-2">
            
                <div class="circle">

                <img id="output" class="profile-pic" src="{{ asset('profile_pictures') }}/{{ $user -> profile_picture }}">
                                
                </div>
                <div class="p-image">
                <i class="fa fa-camera upload-button"></i>
                    <input class="profile-file-input" type="file" name="profile_image" accept="image/*" onchange="loadFile(event)"/>
                </div>
            </div>

            <div>
            <x-primary-button class="apply-btn" style="border: none">
                {{ __('update') }}
            </x-primary-button>
            </div>
            </form>


            

                <div class="w-full">
                <section>
                <header>
                    <h2 style="color: #000" class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </header>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>

                <form method="post" action="{{ route('dev.profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        
                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" :value="$user->id" hidden required autocomplete="id" />
                        <x-text-input id="name" name="names" type="text" class="mt-1 block w-full" :value="old('names', $user->names)" required autocomplete="names" />
                        <x-input-error class="mt-2" :messages="$errors->get('names')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
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
                        <x-text-input id="phone" name="phone_number" type="text" class="mt-1 block w-full" value="{{ $user->phone_number }}" required autocomplete="phone_number" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
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

                </div>

                <div class="w-full">
                    
                    <section>
                    <header>
                        <h2 style="color: #000" class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Update Password') }}
                        </h2>
    
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>
                    </header>
    
                    <form method="post" action="{{ route('rb.password.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('put')

                        <x-text-input id="id" name="id" type="text" class="mt-1 block w-full" :value="$user->id" hidden required autocomplete="id" />
    
                        <div>
                            <x-input-label for="current_password" :value="__('Current Password')" />

                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
    
                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
    
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
    
                        <div class="flex items-center gap-4">
                        <x-primary-button class="apply-btn" style="border: none">
                                {{ __('change password') }}
                            </x-primary-button>
    
                            <small style="color: red">{{ Session::get('error') }}</small>
                            <small style="color: red">{{ Session::get('status') }}</small>
    
                            @if (session('status') === 'password-updated')
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
    
    
                </div>

            </div>
            

        </div>
    </div>
</div>


<script>

var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
    URL.revokeObjectURL(output.src) // free memory
    }
};

</script>

</x-rhythm-box>
