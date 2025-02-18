<x-mails>

  <x-slot name="header">
  </x-slot>

  <br>
  <p class="mb-0">Hello, <br>
    {{ $data['message'] }}
  </p> <br>
  <p>
    To review all the deatils about the request, You can access the dashboard by clicking the following button <br>
  </p> <br>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
            
            <x-button style="border: none; text-decoration: none" :url="$data['url']">
                Dashboard
            </x-button>
            </td>
        </tr>
    </table>

  <p><br>
    Regards, <br>
    <strong>{{ config('app.name') }}.</strong>

  </p>

</x-mails>