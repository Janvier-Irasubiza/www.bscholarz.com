<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $client }}, <br>
        I hope you're well.
  	</p> <br>
        <p>
            This is a friendly reminder service <strong>{{ $app }}</strong> provided on {{ $date }} remains unpaid. The outstanding amount is <strong>{{ $amount }} <small>RWF</small></strong>. <br>

            Please make the payment at your earliest convenience.<br>
        </p> <br>
  
  <p>
  Thank you for your prompt attention.
    </p><br>
  
  	<p><br>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>