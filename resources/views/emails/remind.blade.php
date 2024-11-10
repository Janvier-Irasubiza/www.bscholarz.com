<x-mails>

    <x-slot name="header">
    </x-slot>

  <br>
    <p class="mb-0">You still have a payment to make!<br> <br>
  	</p> <br>

             <p>Dear {{ $client }}<br><br>

               You have not yet paid for {{ $app }}

  				</p>



            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">

                        <x-button style="border: none; text-decoration: none" :url="$url">
                          	Click here to pay
                        </x-button>
                     </td>
                  </tr>
              </table>
        <br>

  <p>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>
