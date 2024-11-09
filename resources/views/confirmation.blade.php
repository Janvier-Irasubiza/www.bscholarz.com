@section('title', 'Create account')

<x-guest-layout>

<div class="client-body w-full h-middle">

    <div style="padding: 15px" class="w-full sm:max-w-lg px-5 py-4 pt-2 overflow-hidden sm:rounded-lg">

        <div class="d-flex justify-content-center align-items-center p-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
            <h1 style="font-size: 30px" class="ml-3 mb-2">Congratulations!</h1>
        </div>

        <div class="container mt-5" style="padding: 5px 0px;">
            <p style="font-size: 16px">
                <strong>Your payment has been successfully received by BScholarz.</strong> <br><br>
                <div>Here is the link to application</div>

                <div class="flex gap-2 items-center">
                    <input type="text" id="copy-link" value="{{ $link }}" class="w-full" style="background-color: #ddd; border: none" readonly>
                    <button id="copy-button" class="copy-button" style="background: #000; color: #fff; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;">Copy</button>
                </div>
            </p>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            <a style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 12px" class="apply-btn home-btn" href="{{ route('home') }}" style="border: none">
                OK, &nbsp; Explore more
            </a>
        </div>

    </div>

    <div class="mt-4 w-full sm:max-w-lg">
        @include('layouts.full-footer')
    </div>

</div>

<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>

@if($errors->isNotEmpty())
<script>
    $(window).on('load', function() {
        $('.set-password').toggleClass('show');
        $('.set-password-btn').toggleClass('show');
        $('.home-btn').toggleClass('hide');
    });
</script>
@endif

<script>
    // Copy functionality for the copy button
    document.getElementById('copy-button').addEventListener('click', function() {
        let copyText = document.getElementById('copy-link');
        let copyButton = document.getElementById('copy-button');

        copyText.select(); // Select the input value
        copyText.setSelectionRange(0, 99999); // For mobile devices
        
        navigator.clipboard.writeText(copyText.value) // Copy to clipboard
            .then(() => {
                copyButton.textContent = 'Copied!'; // Change button text to "Copied!"
                
                // Optional: Reset button text after a delay
                setTimeout(() => {
                    copyButton.textContent = 'Copy';
                }, 2000);
            })
            .catch((err) => {
                alert('Failed to copy: ' + err);
            });
    });
</script>


</x-guest-layout>
