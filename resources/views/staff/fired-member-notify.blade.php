@section('title', 'Create account')

<x-guest-notify-layout>

<div class="client-body w-full h-middle">

<div style="background: #3e647257; box-shadow: rgba(0, 0, 0, 0.35) 0px 0px 15px; padding: 15px" class="w-full sm:max-w-lg px-5 py-4 pt-2 shadow-md overflow-hidden sm:rounded-lg">

<div class="d-flex justify-content-center align-items-center p-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
        
        <h1 style="font-size: 30px" class="ml-3 mb-2">Failed to authenticate you!</h1>
    </div>

    <div class="container text-center mt-3" style="padding: 5px 0px;">
        <p style="font-size: 16px">
            <strong>
                You are no longer a BScholarz Staff!</strong> <br> <br>
        </p>
    </div>

    <div class="mt-3 d-flex justify-content-center" style="">

        <a style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 12px" class="apply-btn" href="{{ route('home') }}" style="border: none">
                ok, &nbsp; Go home
        </a>

    </div>
    </div>

    <div class="mt-4 w-full sm:max-w-lg">
        @include('layouts.full-footer')
    </div>

    </div>

</x-guest-layout>
