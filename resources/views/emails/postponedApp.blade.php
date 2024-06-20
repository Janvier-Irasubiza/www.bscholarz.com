<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $client }}, <br>
  		Your request for {{ $app }} has been postponed.
  	</p> <br>
        <p>
           This is due to {{ $reason }}

        </p> <br>
  
  <p>
    Quickly take an action and provide missing information (or documents).
    </p><br>
  
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
                           Take an action
                        </x-button>
                     </td>
                  </tr>
              </table>
  
  	<p><br>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>