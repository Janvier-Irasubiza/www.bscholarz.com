@section('title', 'Create account')

<x-guest-notify-layout>

<div class="client-body w-full h-middle">

<div style="background: #3e647257; box-shadow: rgba(0, 0, 0, 0.35) 0px 0px 15px; padding: 15px" class="w-full sm:max-w-lg px-5 py-4 pt-2 shadow-md overflow-hidden sm:rounded-lg">

<div class="d-flex justify-content-center align-items-center p-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
        
        <h1 style="font-size: 30px" class="ml-3 mb-2">Congratulations!</h1>
    </div>

    <div class="container text-center mt-3" style="padding: 5px 0px;">
        <p style="font-size: 16px">
            <strong> Your request has beeen successfuly received by BScholarz.</strong> <br/> <br/>
            <div>You'll be contacted for further application processes via phone number and email you provided.</div> 
            <div class="mt-3">For a better experience, 
      
              <button id="newSetPassword" style="text-transform: uppercase; font-weight: 600; font-size: 12px; background: none; border: none" class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                  Create your account
              </button>

          	</div>
         </p>
    </div>
    
        <form action="{{ route('set-client-password', ['client' => $applicant]) }}" method="post"> @csrf

  	<div class="set-password">
      
      
      
       <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Set Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            placeholder="Create password"
                            required autocomplete="password" />

        </div>

        <!-- Confirm Password -->
        <div class="mt-3">
            <x-input-label for="password_confirmation" :value="__('Confirm Your Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            placeholder="Confirm password"
                            name="password_confirmation" required autocomplete="password_confirmation" />
          
          	<x-input-error :messages="$errors->get('password')" class="mt-2 w-full text-left" />
      		<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 w-full text-left" />

        </div>
      
      </div>
  
   <div class="mt-4 d-flex justify-content-center" style="">
      
      <button type="submit" style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 12px" class="apply-btn set-password-btn px-5" href="{{ route('home') }}" style="border: none">
                Set password
        </button>

      </div>
      
      </form>

    <div class="mt-4 d-flex justify-content-center" style="">

        <a style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 12px" class="apply-btn home-btn" href="{{ route('home') }}" style="border: none">
                ok, &nbsp; Explore more
        </a>

    </div>
    </div>

    <div class="mt-4 w-full sm:max-w-lg">
        @include('layouts.full-footer')
    </div>

    </div>


<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>


@if($errors->isNotEmpty())

<script>

  
   $(window).on('load', function() {
  
  	$('.set-password').toggleClass('show');
    $('.set-password-btn').toggleClass('show');
    $('.home-btn').toggleClass('hide');
     
  });
  
</script>

@endif


<script>

  
  let setNewPassword = document.getElementById('newSetPassword');
  
  setNewPassword.addEventListener('click', function() {
  
    $('.set-password').toggleClass('show');
    $('.set-password-btn').toggleClass('show');
    $('.home-btn').toggleClass('hide');
        
  });
  
</script>


</x-guest-layout>
