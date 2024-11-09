<x-mails>

    <x-slot name="header">
    </x-slot>
  
      <br>
        <p class="mb-0">
          Your payment for {{ $app }}'s application has been successfully received by BScholarz.
        </p> <br>
            <p>
                Thank you for requesting service in BScholarz. <br>
            </p> <br>
      
        <p>
          Bellow is your link to the application
        </p><br>
      
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                          <td align="center">
                            
                            <x-button style="border: none; text-decoration: none" :url="$url">
                              Go To Application
                            </x-button>
                        </td>
                      </tr>
                  </table>
      
        <p><br>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>