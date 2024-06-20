
@section('title', 'login')

<x-guest-layout>

<div class="client-body w-full h-middle d-flex justify-content-center" style="width: 100%; margin: auto;">

<div style="background: none;" class="w-full sm:max-w-md mt-0 px-6 py-4 pt-0 overflow-hidden sm:rounded-lg">

        <div class="d-flex justify-content-center align-items-center py-3 mb-5" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
                <h1 style="font-size: 30px" class="mb-2">Login</h1>
            </div>
     
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('client.auth') }}">
        @csrf
      
       @if($errors->has('pass_changed'))
      
      <div>
        <x-input-error :messages="$errors->get('pass_changed')" class="mt-4 mb-3 text-left text-success" />
      </div>
      
      @endif

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />

            @if(isset($email)) 

            <x-text-input id="discipline_id" class="block mt-1 w-full" type="text" hidden name="discipline_id" :value="$discipline_id" required/>
            <x-text-input id="discipline_identifier" class="block mt-1 w-full" type="text" hidden name="discipline_identifier" :value="$discipline_identifier" required/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$email" placeholder="Your email or phone number" required autocomplete="username" />
            
          
          @elseif(isset($user_email)) 

            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user_email" placeholder="Your email or phone number" required autocomplete="username" />
            
            @else

            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="Your email or phone number" required autofocus autocomplete="username" />

            @endif
          
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />


            @if(isset($set_key))
            <small class="text-muted mb-0">Create Password</small>
            <input type="hidden" name="set_key" value="{{ $set_key }}">
            <x-text-input id="password" class="block mt-1 mb-3 w-full"
                            type="password"
                            name="password"
                            placeholder="Create Password"
                            required autofocus autocomplete="current-password" />

                            <small class="text-muted mb-0">Confirm Password</small>
                            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm Password"
                            required autofocus autocomplete="current-password" />

            @else

                @if(isset($email)) 

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    placeholder="Password"
                                    required autofocus autocomplete="current-password" />

                @else

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    placeholder="Password"
                                    required autocomplete="current-password" />

                @endif

            @endif


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
            @if(!isset($set_key))
            @if (Route::has('password.request'))
                <a class="underline text-sm hover:text-black-900 dark:hover:text-black-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('clients-password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            

            <x-primary-button class="ml-3 apply-btn" style="border: none">
                {{ __('Log in') }}
            </x-primary-button>

            @else 

            <x-primary-button class="ml-3 apply-btn" style="border: none">
                {{ __('Set up and Log in') }}
            </x-primary-button>

            @endif
        </div>

        <div class="d-flex justify-content-center w-full sm:max-w-md mt-4">
                    <div style="border-top: 1px solid rgba(0, 0, 0, 0.151); padding: 10px 0px 0px 0px" class="row container">
                     <p style="margin: 0px; text-align: center" class="text-sm">Don't have Account yet? &nbsp; &nbsp;<a class="text-sm hover:text-black-900 dark:hover:text-black-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}" style="font-weight: bold">
                    {{ __('Create Account') }}
                </a></p>
                    </div>
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
