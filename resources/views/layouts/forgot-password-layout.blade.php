<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BScholarz - @yield('title')</title>

        <link rel="stylesheet" href="{{ asset('styles.css') }}?v={{ filemtime(public_path('styles.css')) }}">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}?v={{ filemtime(public_path('bootstrap/css/bootstrap.min.css')) }}">
        <link rel="stylesheet" href="{{ asset('fa-icons/css/all.css') }}?v={{ filemtime(public_path('fa-icons/css/all.css')) }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">

        <style>

        body, .modal-content{
            margin: 0px;
            background-color: #EBF0FF;
            }

        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        function toggleShakeAnimation(enableShake) {
            if (enableShake) {
                $('#contactButton').addClass('shaking');
            } else {
                $('#contactButton').removeClass('shaking');
            }
        }

        $('#contactButton').click(function() {
            $('#popup').slideDown();
            toggleShakeAnimation(false);
        });

        $('#closePopup').click(function() {
            $('#popup').slideUp();
            toggleShakeAnimation(true);
        });

        toggleShakeAnimation(true);
    });

    $(document).ready(function() {
        $('#contactForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    $('#messageDiv').html('<p class="text-green-500">Message sent successfully. We will reach out to you shortly.</p>');
                    $('#contactForm').trigger('reset');
                },
                error: function(xhr, status, error) {
                    $('#messageDiv').html('<p class="text-red-500">Failed to send message. Please try again later.</p>');
                }
            });
        });
    });
</script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center">

        <div class="d-flex justify-content-center align-items-center mt-3 mb-5">
        <a href="{{ route('home') }}">
        <div class="bbg-logo" style="">
                <img src="{{ asset('images') }}/{{ 'BScholarz_Logo.png' }}" class="img-responsive" alt="Logo">
            </div>
        </a>
    </div>

        <div style="background: none;" class="w-full sm:max-w-md mt-6 px-6 py-4 pt-2 overflow-hidden sm:rounded-lg">

        <div class="d-flex justify-content-center align-items-center py-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
                
                <h1 style="font-size: 30px" class="ml-3 mb-2">Reset password</h1>
            </div>
                {{ $slot }}
            </div>

            <div class="d-flex justify-content-center w-full sm:max-w-md mt-4">
        <div style="border-top: 1px solid #a8a3a3; padding: 20px 0px" class="mt-3 row container">
    <div class="col-lg-6" style="font-size: 13px">
        &copy; 2023 <strong>BScholarz</strong> 
    </div>  

    <div class="col-lg-6">
        <p style="margin-bottom: 0px; text-align: right; font-size: 13px">Developed by <button id="contactButton"  class="text-center text-gray-600 shake b-none bg-none"> &nbsp; <strong>RB-A</strong></button>                    </div> </p> 
    </div> 


<div id="popup" class="popup p-4 border col-md-6 bg-gray-200">
                <div class="d-flex justify-content-between">
                    <h3 class="text-gray-600">RhythmBox Associations</h3>
                    <button id="closePopup" class="b-none bg-none">Close</button>
                </div>
                <div class="mt-4 flex-section gap-3">
                   <div class="col-md-4 border-r mb-8">
                   <h4 class="text-gray-600 text-center">Contact</h4>
                   <div class="mt-6">        

                        <p class="text-center">
                            <i class="fa-solid fa-phone f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">
                            <a href="tel:+250781336634">+250 781 336 634</a>
                        </p>
                        </div>
                        <div class="mt-6">
                        <p class="text-center">
                            <i class="fa-solid fa-phone f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">
                            <a href="tel:+250780478405">+250 780 478 405</a>
                        </p>
                    </div>

                    <div class="mt-6">
                        <p class="text-center">
                            <i class="fa-solid fa-envelope f-25"></i>
                        </p>
                        <p class="text-gray-600 text-center mt-2">arhythmbox@gmail.com</p>
                    </div>

                   </div>
                   <div class="w-full">
                   <h4 class="text-gray-600">Send us a message</h4>
                    <form action="{{ route('send.email') }}" method="POST" class="mt-3" id="contactForm"> @csrf
                        <div>
                            <x-input-label for="name" class="f-14" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="How can we address you?" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-3">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- phone number -->
                        <div class="mt-3">
                            <x-input-label for="phone" :value="__('Message')" />
                            <textarea id="request" class="block mt-1 w-full border-gray rounded p-2" name="request" required placeholder="Message">{{ old('requests') }}</textarea>
                            <x-input-error :messages="$errors->get('request')" class="mt-2" />
                        </div>

                        <div id="messageDiv" class="mt-3"></div>

                        <div class="mt-6 d-flex align-items-center justify-content-between">

                            <button class="lara-btn">
                                {{ __('Send message') }}
                            </button>
                        </div>
                    </form>
                   </div>
                </div>
            </div>
            
</div>
        </div>
        
        </div>

        

    </body>
</html>
