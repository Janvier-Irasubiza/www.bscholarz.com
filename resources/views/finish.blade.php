@section('title', 'Payment completed')

<x-guest-notify-layout>

<div class="client-body w-full h-middle">

<div style="background: #3e647257; box-shadow: rgba(0, 0, 0, 0.35) 0px 0px 15px; padding: 15px" class="w-full sm:max-w-lg px-5 py-4 pt-2 shadow-md overflow-hidden sm:rounded-lg">

<div class="d-flex justify-content-center align-items-center p-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
        
        <h1 style="font-size: 30px" class="ml-3 mb-2">Congratulations!</h1>
    </div>

    <div class="container text-center mt-3" style="padding: 5px 0px;">
        <p style="font-size: 16px"> @if($message) {{$message}} @else A payment request was sent to the mobile operator and a USSD menu will appear on your device shortly. @endif <br/><br/>
          
            <div> @if($subcontent) {{$subcontent}} @else Please confirm the request to pay for the service. <br> Thank you @endif</div>
     
         </p>
    </div>

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
