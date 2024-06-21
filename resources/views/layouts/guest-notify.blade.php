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
            background-color: #F8FAFF;
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

          .set-password {

              display: none

            }
          
          .set-password-btn {
          
            display: none;
            
          }
          
          .home-btn {
          
            display: block
            
          }
          
          .set-password.show {

              display: block

            }
          
          .set-password-btn.show {
          
            display: block;
            
          }
          
          .home-btn.hide {
          
            display: none
            
          }
          
            @media (max-width: 600px) {
                .sm-section {
                    margin: auto;
                    width: 85%;
                    display: flex;
                }

                .h-middle {
                    margin-top: -3em;

                }
            }

        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen  sm-section">

                {{ $slot }}

            </div>
    </body>
</html>
