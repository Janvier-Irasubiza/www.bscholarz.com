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
            background-color: #EBF0FF;
            }

        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        <p style="margin-bottom: 0px; text-align: right; font-size: 13px"> <i class="fa-solid fa-code"></i> &nbsp; <strong>RB-A</strong></p> 
    </div> 
</div>
        </div>
        
        </div>

        

    </body>
</html>
