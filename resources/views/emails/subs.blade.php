<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $subscriber }}, <br>
  		{{ $message }}
  	</p> <br>
  
    <p>
        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>
    </p>

</x-mails>