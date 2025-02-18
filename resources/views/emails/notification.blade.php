<x-mails>

  <x-slot name="header">
  </x-slot>

  <br>
  <p class="mb-0">Dear {{ $data['names'] }}, <br>
    {{ $data['message'] }}
  </p> <br>
  <p>
    Thank you for choosing BScholarz. <br>

    We look forward to working with you again.
  </p> <br>

  <p>
  </p><br>

  <p><br>
    Regards, <br>
    <strong>{{ config('app.name') }}.</strong>

  </p>

</x-mails>