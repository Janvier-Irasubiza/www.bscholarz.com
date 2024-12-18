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

        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


    <style>

        body{
            margin: 0px;
            background:
                url("data:image/svg+xml,%3Csvg viewBox='0 0 250 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='15.64' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            background-color: #ccf2ff;
            }

      .content{
            margin: 0px;
          	padding: 30px 20px;
          	text-align: center
            }



      .apply-btn {
        padding: 5px 20px;
        background-color: #5AB8A4 !important;
        border-radius: 5px;
        transition: background-color 0.12s ease;
        left: auto;
        margin-right: 0px;
        color: ghostwhite;
        padding: 10px 30px;
      }

      .apply-btn:hover {
          background-color: #479c8a !important;
          font-weight: bold;
      }

        .footer {
            position: absolute;
            bottom: 0px;
            width: 100%;
            left: auto;
            right: 0px

        }

        ul {
            list-style: none;
            text-align: left;
        }

      	.body-content {
      		display: flex;
          	justify-content: center
      	}

        .mail-body {
            background-color: #ccf2ff9d;
            width: 90%;
            border-radius: 7px;
            text-align: left;
            padding: 30px
        }

      @media (max-width: 600px) {

        .mail-body {
            background-color: #ccf2ff9d;
            width: 100%;
            border-radius: 7px;
            text-align: left;
            padding: 30px
        }

      }

        </style>

        <!-- Scripts -->
    </head>
    <body class="font-sans antialiased">


        <div class="content text-center">

            <!-- Page Content -->

            <div class="">
                <div class="mb-4" style="">
                    <h4 style="font-size: 23px"><strong>{{ config('app.name') }}</strong></h4>
                </div>

              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                      <td align="center">
                            <div class="mail-body">
                                <div class="">
                                    {{ $slot }}
                                </div>

                            </div>
                      </td>
                  </tr>
              </table>

                <br>

                <div class="mt-3">

                    © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')

                </div>
            </div>

        </div>

    </body>
</html>
