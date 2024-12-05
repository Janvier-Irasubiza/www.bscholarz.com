<x-mails>

  <x-slot name="header">
  </x-slot>

  <br>
  <p class="mb-0">Dear {{ $data['assistant'] }}, </p> <br>

  <p>Your were assigned an appointment with {{ $data['client_names'] }} which will take place at
    {{ $data['client_address'] }} on {{ $data['appt_time'] }}.</p>
  <br>

  <p>Please mark your calender so you can't miss this appointment.</p> <br>

  <h2>Appointment Info</h2>
  <p>Client: {{ $data['client_names'] }}</p>
  <p>Phone number: {{ $data['client_phone'] }}</p>
  <p>Email address: {{ $data['client_email'] }}</p>
  <p>Client Address: {{ $data['client_address'] }}</p>
  <p>Appointment time: {{ $data['appt_time'] }}</p>
  <p><br>

    Regards, <br>
    <strong>{{ config('app.name') }}.</strong>

  </p>

</x-mails>