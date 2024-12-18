<x-mails>
    <x-slot name="header">
        <!-- Optional header content can go here -->
    </x-slot>

    <br>

    <p>
        Dear {{ $client }},
        <br><br>
        We are reaching out to remind you that your payment for the <strong>{{ $app }}</strong> service remains incomplete. <br><br>
        Ensuring the timely completion of this payment helps us continue to provide you with the best service possible.
        <br>
        <br>
    </p>
    <p class="text-center">To complete your payment, please click the button below </p>

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
        <strong>{{ config('app.name') }}</strong>
    </p>
</x-mails>
