<x-forgot-password-layout>

<div class="client-body w-full h-middle d-flex justify-content-center" style="width: 100%; margin: auto;">

<div class="mb-5 w-full">
    
    <form method="POST" action="{{ route('partner-password.store') }}">
        @csrf
      
      @if($errors->has('failed'))
      
      <div>
        <x-input-error :messages="$errors->get('failed')" class="mt-4 text-left text-danger" />
      </div>
      
      @endif
      
       @if($errors->has('inv_token'))
      
      <div>
        <x-input-error :messages="$errors->get('inv_token')" class="mt-4 text-left text-danger" />
      </div>
      
      @endif
      
      @if($errors->has('no_user'))
      
      <div>
        <x-input-error :messages="$errors->get('no_user')" class="mt-4 text-left text-danger" />
      </div>
      
      @endif
      
      	@if(!empty($error)) 
      
      		{{ $request->email }} <br> <br> {{ $error }}, 
      			<a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('partner-password.request') }}">
                    {{ __('request another link') }}
                </a> 
      @else

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" disabled/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="apply-btn">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
      
      @endif
      
    </form>

    </div>

</div>
</x-forgot-password-layout>