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
            background-color: #EBF0FF
            }

            .sm-section {
                margin: auto;
                width: 35%;
                display: flex;
                align-items: center;
            }

            .min-h-screen {
                height: auto;
            }

            @media (max-width: 600px) {
                
                .sm-section {
                    margin: auto;
                    width: 85%;
                    display: flex;
                    border-radius: 7px;
                }

                .h-middle {
                    margin-top: -6em;

                }

                .mgn {
                    margin-bottom: 4em
                }
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

        <div class="d-flex justify-content-center  align-items-center mt-5 mgn">
            <a href="{{ route('home') }}">
                <div class="bbg-logo mt-3" style="">
                    <img src="{{ asset('images') }}/{{ 'BScholarz_Logo.png' }}" class="img-responsive" alt="Logo">
                </div>
            </a>
        </div>

        <div class="sm-section" style="background: none">
            {{ $slot }}
        </div>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    </body>
</html>
