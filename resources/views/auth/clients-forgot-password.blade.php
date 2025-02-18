@section('title', 'Reset password')

<x-forgot-password-layout>

<div class="client-body w-full h-middle d-flex justify-content-center" style="width: 100%; margin: auto;">

<div>
    <div class="text-sm">
        {{ __('Forgot your password?') }} <br><br> @if(!$errors->has('success')) {{ __('Let us know your email address and we will email you a password reset link.') }} @endif
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('client-password.email') }}">
        @csrf
      
      @if($errors->has('success'))
      
      <div>
        <x-input-error :messages="$errors->get('success')" class="mt-4 text-left text-success" />
      </div>
      
      @else

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" placeholder="Type your email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
      
      @endif
      
      <div class="mt-5 d-flex justify-content-center">
          {!! NoCaptcha::display() !!}
      </div>

      <div class="mt-3 mb-4">
          @if ($errors->has('g-recaptcha-response'))
          <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
          @endif
      </div>

        <div class="d-flex items-center mb-5 justify-between mt-4">
        <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Back to Sign in') }}
            </a>

          @if(!$errors->has('success'))
            <x-primary-button class="apply-btn">
                {{ __('Get password reset Link') }}
            </x-primary-button>
          @endif
        </div>
    </form>

</div>

</div>
</x-forgot-password-layout>
