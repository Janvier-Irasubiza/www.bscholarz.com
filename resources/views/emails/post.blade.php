<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">New opportunity is waiting for you!<br> <br>
  		{{ $title }} - {{ $type }}
  	</p> <br>
  
             <p>{{ $desc }}<br><br>
               
               For more details, click the button bellow:
  
  				</p>
  
  

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
                          	Learn more
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