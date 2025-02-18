@extends ('layouts.bbg-layout')

@section('title', 'Contact Us')

@section('content')

<div class="body-content" style="">

<div class="section-right-body-other cstm-other-section py-3" style="">


<div class="about-us py-3">

    <div class="bacic-infos mt-3 mb-3">
        <div class="cst-fluid" style="">
            <div class="flex-section gap-2">
                <div class="col-lg-4 mb-2 info-sect" style="">
                    <div class="address-info mt-1">
                        <div class="icon-hold">
                            <i style="font-size: 18px" class="fa-solid fa-location-pin"></i>
                        </div>
                    </div>
                    <div class="text-center mb-2 mt-1" style="">
                        <strong>Address:</strong>&nbsp KN 20 AVE, Kigali City - Rwanda
                    </div>
                </div>

                <div class="col-lg-4 mb-2 info-sect" style="">
                    <div class="address-info mt-1">
                        <div class="icon-hold-1">
                            <i style="font-size: 17px" class="fa-solid fa-phone"></i>
                        </div>
                    </div>
                    <div class="text-center mb-2 mt-1" style="">
                        <strong>Phone:</strong>&nbsp +250 786 981 832
                    </div>
                </div>

                <div class="col-lg-4 mb-2 info-sect" style="">
                    <div class="address-info mt-1">
                        <div class="icon-hold-1">
                            <i style="font-size: 17px" class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <div class="text-center mb-2 mt-1" style="">
                        <strong>Email:</strong>&nbsp bscholarz.rw@gmail.com
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="leave-message mt-3 mb-3">
    <div class="row mb-2"><strong><h4>Leave us a message</h4></strong>

    </div>

    <div class="message-left">

    <form action="{{ route('seek-assistance') }}" method="post" class="space-y-6" >   @csrf                     

        <div class="modal-body">

        <div>
            <x-input-label for="names" style="text-align: left" class="text-left w-full" :value="__('Names')" />
            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Type your fullname</p>
            <x-text-input id="names" class="block mt-1 w-full" style="border-radius: 4px;" type="text" name="names" :value="old('names')" placeholder="Fullname" required autofocus autocomplete="names" />
            <x-input-error :messages="$errors->get('names')" class="mt-2" />
        </div>

        <div class="flex-section gap-3">
        <div class="mt-3 w-full">
            <x-input-label for="email" style="text-align: left" class="text-left w-full" :value="__('Email')" />
            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Your Email address</p>
            <x-text-input id="email" class="block mt-1 w-full" style="border-radius: 4px;" type="email" name="email" :value="old('email')" placeholder="username@example.com" required  autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-3 w-full">
            <x-input-label for="phone" style="text-align: left" class="text-left w-full" :value="__('Phone number')" />
            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Provide your active phone number</p>
            <x-text-input id="email" class="block mt-1 w-full" style="border-radius: 4px;" type="text" name="phone" :value="old('phone')" placeholder="your phone number" required  autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        </div>

        <div class="mt-3 w-full">
            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Message')" />
            <x-text-input id="email" class="block mt-1 mb-0 w-full" style="border-radius: 4px; border-bottom: 1px solid #bfbfbf; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px;" type="text" name="issue" :value="old('phone')" placeholder="Type your message here..." required autocomplete="issue" />
            <textarea placeholder="Describe your message here..." id="desc" name="desc" class="block w-full" style="border: 2px solid #000; border-top: 0px; border-radius: 6px; border-top-right-radius: 0px; border-top-left-radius: 0px; padding: 6px; font-size: 14px" required ></textarea>
            <x-input-error :messages="$errors->get('issue')" class="mt-2" />
            <x-input-error :messages="$errors->get('desc')" class="mt-2" />
        </div>


        <div class="mt-4 text-right d-flex justify-content-end">
            <!-- <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="">
                {{ __('Or see tips & tricks') }}
            </a> -->
            <button type="submit" style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase" class="btn apply-btn">Submit</button>
        </div>
        </div>
    </form>
    </div>

    <!-- Maps Address -->
    <div class="mt-4">
        <div class="mapouter">
            <div class="gmap_canvas">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.4465122275856!2d30.167559874805075!3d-1.975706198006421!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19db598ce5854861%3A0xeca516e5d416d5b8!2sBSCHOLARZ%20LTD!5e0!3m2!1sen!2srw!4v1739907904910!5m2!1sen!2srw" 
                    width="100%" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>

    </div>
    
</div>        
</div>
</div>



<!-- <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script> -->


<script>

$(document).ready(function(){ 
    $('.sidebar-drawer').toggleClass('hide');
});


</script>


@stop