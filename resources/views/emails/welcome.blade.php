<x-mails>

    <x-slot name="header">
    </x-slot>
  
  <br>
    <p class="mb-0">Dear {{ $client }}, <br>
  		Welcome to BScholarz, We're thrilled to have you as part of our community.
  	</p> <br>
  
  <p>
    Your presence enriches our space, and we're excited to embark on this journey together. Feel free to explore available opportunities by clicking the button below. 
    </p><br>
  
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                        
                        <x-button style="border: none; text-decoration: none" :url="$url">
                           Explore Opportunities
                        </x-button>
                     </td>
                  </tr>
              </table>
  
  	<p><br>

        Regards, <br>
        <strong>{{ config('app.name') }}.</strong>

    </p>

</x-mails>