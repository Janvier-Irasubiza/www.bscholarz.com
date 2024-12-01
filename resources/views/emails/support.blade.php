<x-mails>

  <x-slot name="header">
  </x-slot>

  <br>
  <p class="mb-0">{{$issue}}</p> <br>

  <p>{{ $desc }}</p>

  <br>

  <p><br>

    Regards, <br>
    <strong>{{ config('app.name') }}.</strong>
    
  </p>

</x-mails>