<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $client }}, <br>
  		Your request for {{ $app }} has been processed successfully.
  	</p> <br>
  
 <p> Thank you for trusting Bscholarz! We look forward to working with you again. If you meet with any challenges, please don't hesitate to contact us.</p><br>
  
 <p>
    Kindly, you are required to pay for the service.
    </p><br>
  
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
                           Click here to pay
                        </x-button>
                     </td>
                  </tr>
              </table> 
  
  	<p><br>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>