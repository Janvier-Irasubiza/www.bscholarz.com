@section('title', 'Request Service')

<x-guest-layout>

<div class="client-body w-full h-middle">

<div style="background: none; border-radius: 8px" class="px-3 overflow-hidden">

<div class="mb-4 px-4 pt-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">

    <div class="d-flex justify-content-center align-items-center py-3">
        <h2 style="font-size: 20px" class="mb-2 s-font">
            {{ $discipline_info -> discipline_name }}
        </h2>
    </div>

</div>

<form method="POST" action="{{ route('user-request-application') }}" enctype="multipart/form-data">
    <div class="">
        <div class="px-4 pt-1">
        @csrf

        <div class="col-lg-4 mt-3">
        @if($discipline_info)
            <input id="application_info" class="block mt-1 w-full" type="text" name="application_info" value="{{ $discipline_info -> id }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="application_info" hidden/>
            <input id="application_info" class="block mt-1 w-full" type="text" name="identifier" value="{{ $discipline_info -> identifier }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="application_info" hidden/>
            <x-input-error :messages="$errors->get('application_info')" class="mt-2" />
        @endif
        </div>

            <!-- Name -->
        <div>
            <x-input-label for="names" :value="__('Names')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px" id="names" class="block mt-1 w-full input-holder" type="text" name="names" value="{{ old('names') }}" placeholder="Full name" required autofocus autocomplete="names" />
            <x-input-error :messages="$errors->get('names')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class=" mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <div class="d-flex gap-3">
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px" id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" placeholder="username@example.com" autocomplete="email" />

            <!-- @if($errors->has('email'))

            <div class="col-lg-3 d-flex align-items-center">
                <a style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 11px; padding: 8px 8px; diplay: block" class="apply-btn w-full text-center" href="{{ route('login', ['email' => old('email'), 'discipline_id' => $application_info -> id, 'discipline_identifier' => $application_info -> identifier]) }}" style="border: none"> Signin instead</a>
            </div>

            @endif -->
            
        </div>

        <x-input-error :messages="$errors->get('email')" class="mt-2 text-left text-danger" style="color #000; font-weight: bold" />

        </div>

        <!-- Password -->
        <div class="mt-3">
            <x-input-label for="phone_number" :value="__('Phone number')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px" id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="Your phone number" required autocomplete="phone_number" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>


    
        <div class="button-section mt-4" style="margin-bottom: 20px">
            <x-primary-button class="apply-btn button-section-btn">
                {{ __('Request service') }}
            </x-primary-button>
        </div>
        
        </div>

        </div>


        </form>

        </div>

        <div style="" class="px-1 mt-4 w-full media-footer">
                @include('layouts.full-footer')
        </div>

        </div>

        

        </div>
          
</x-guest-layout>
