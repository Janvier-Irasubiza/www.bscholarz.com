<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $client }}, <br>
  		You are receiving this email because we received a password reset request for your account. 
  	</p> <br>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
                           Reset Password 
                        </x-button>
                     </td>
                  </tr>
              </table><br><br>

        <p>
            This password reset link will expire in 30 minutes. <br>

            If you did not request a password reset, no further action is required.<br>
        </p>
  
  	<p>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>