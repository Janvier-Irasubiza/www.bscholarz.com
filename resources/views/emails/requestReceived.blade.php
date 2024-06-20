<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $client }}, <br>
  		Your request for {{ $app }} has been successfully received by BScholarz.
  	</p> <br>
        <p>
            Thank you for requesting service in BScholarz. <br>

            Our team is going to process your request, be sure to receive feedback not later than 24 hours.<br>
        </p> <br>
  
  <p>
    To keep track of your request progress, or exploring more opportunities, click on the buttoin bellow.
    </p><br>
  
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
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