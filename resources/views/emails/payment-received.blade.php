<x-mails>

  <x-slot name="header">
  </x-slot>

  <br>
  <p class="mb-0">Dear {{ $data['client_names'] }}, <br>
    Your payment for {{ $data['discipline'] }} has been successfully received by BScholarz.
  </p> <br>
  <p>
    Thank you for choosing BScholarz. <br>

    We look forward to working with you again.
  </p> <br>

  <p>
  </p><br>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">

        <x-button style="border: none; text-decoration: none" :url="$data['url']">
          My Dashboard
        </x-button>
      </td>
    </tr>
  </table>

  <p><br>

    Regards, <br>
    <strong>{{ config('app.name') }}.</strong>

  </p>

</x-mails>