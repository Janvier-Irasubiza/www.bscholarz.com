<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $staff_names }}, <br>
  		You have received {{ number_format($amount_disbursed) }} <small>RWF</small> as your payment from BScholarz!
  	</p> <br>
  
 <p> This payment was made through {{ $phone_number }}, your desired phone number.</p><br>
  
 <p>
    Now, {{ $balance }} <small>RWF</small> is your remaining balance in your BScholarz staff dashboard.
    </p><br>
  
  <p>
    Thank you for working with BScholarz. <br><br>
	#DREAM BIG
  </p><br>

  
  	<p><br>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>