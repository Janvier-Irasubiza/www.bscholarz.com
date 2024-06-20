@section('title', 'Request Service')

<x-guest-layout>

<div class="client-body w-full h-middle">

<div style="background: #3e647257; box-shadow: rgba(0, 0, 0, 0.35) 0px 0px 15px; border-radius: 8px" class="px-3 shadow-md overflow-hidden">

<div class="mb-4 px-4 pt-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">

    <div class="d-flex justify-content-center align-items-center py-3">
        <h2 style="font-size: 20px" class="mb-2 s-font">
            Check status
        </h2>
    </div>

</div>

<form method="POST" action="{{ route('pay-callback') }}" enctype="multipart/form-data">
    <div class="">
        <div class="px-4 pt-1">
        @csrf

            <!-- Name -->
        <div>
            <x-input-label for="names" :value="__('RefId')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px" id="names" class="block mt-1 w-full input-holder" type="text" name="tid" value="{{ old('tid') }}" placeholder="Full name" required autofocus autocomplete="names" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px" id="names" class="block mt-1 w-full input-holder" type="text" name="refid" value="{{ old('refid') }}" placeholder="Full name" required autofocus autocomplete="names" />
            <x-input-error :messages="$errors->get('names')" class="mt-2" />
        </div>



        <x-input-error :messages="$errors->get('email')" class="mt-2 text-left" style="color #000; font-weight: bold" />

        </div>


    
        <div class="button-section mt-4" style="margin-bottom: 20px">
            <x-primary-button class="apply-btn button-section-btn">
                {{ __('Check') }}
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
