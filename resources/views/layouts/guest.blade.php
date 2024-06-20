<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BScholarz - @yield('title')</title>

        <link rel="stylesheet" href="{{ asset('styles.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fa-icons/css/all.css') }}">
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
            }


        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

    <div class="d-flex justify-content-center align-items-center mt-5 mb-0">
        <a href="{{ route('home') }}">
        <div class="bbg-logo mt-3" style="">
                <img src="{{ asset('images') }}/{{ 'BScholarz_Logo.png' }}" class="img-responsive" alt="Logo">
            </div>
        </a>
    </div>

        <div class="sm-section">

        
                {{ $slot }}

        
        </div>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    </body>
</html>
