<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $question }}, <br>
  		Your enquiry: {{ $client }}, got a reply from BScholarz.
  	</p> <br>
        <p>
            BScholarz replied: <br>

            {{ $answer }}<br>
        </p> <br>
  
  <p>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>