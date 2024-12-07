<x-mails>

  <x-slot name="header">
  </x-slot>

  <br>
  <p class="mb-0">Dear {{ $data['emp_names'] }}, <br>
    Welcome to BScholarz, We're thrilled to have you as part of our community.
  </p> <br>

  <p>
    Your presence enriches our space, and we're excited to embark on this journey together.

    <br>

    Click the bellow button to your Dashoard

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td align="center">

        <x-button style="border: none; text-decoration: none" :url="$data['url']">
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