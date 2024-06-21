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

        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


    <style>

        body, .modal-content{
            margin: 0px;
          	background-color: #F8FAFF
            }

        .modal-xl {
            margin-left: auto;
            margin-right: 75px;
            width: 81.70%;
            z-index: 10;
        } 
        
        .active-sect {
            position: absolute;
            background: 
                url("data:image/svg+xml,%3Csvg viewBox='0 0 250 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='15.64' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
            background-color: #ccf2ff;
            border-radius: 50px 0px 0px 50px;
            padding-left: 13px;
            border: none;
            width: 18rem;
            z-index: 10;
        }

        .sidebar-btn {
            border: 1px solid red
        }


        .carousel-item{
            float:none; 
            transition: 0s !important;
            border-radius: 10px
        }

        .modal-backdrop{
            z-index: 0;
        }

        .navigation-bar {
            width: 80%;
            margin-left: auto; 
            margin-right: 0px;
        }

        .sidebar {
            position: fixed;
            padding: 0px;
            top: 0px;
            bottom: 0px;
            width: 20%;
            background: #d4e7ee;
            z-index: 12;
            height: auto;
        }

        .section-right {
            margin-top: -2.77rem;
            top: 88px;
            width: 80%
        }

        .footer {
            position: absolute;
            bottom: 0px;
            width: 100%;
            left: auto;
            right: 0px

        } 

        /* The heart of the matter */

        .testimonial-group {
            overflow-x: hidden;
        }

        .testimonial-group > .row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
        }



        .testimonial-group > .row > .col-xs-4 {
            padding: 10px 0px;
            margin: 0px
        }

        .testimonial-group > .row::-webkit-scrollbar {
            display: none
        }

        /* Decorations */
        .col-xs-4 { 

        }

        ul {
            list-style: none;
            text-align: left;
        }
/* 
        ul li:before {
            content: '✓';
        }
         */

        .file-upload{
          position: absolute;
          font-size: 8px;
          opacity: 0; 
          height: 2em;
          left: 0px;
          z-index: 0;
          width: 25.8%;
        }

        .profile-file {
            position: absolute;
            font-size: 8px;
            opacity: 0; 
            height: 2em;
            left: 0px;
            z-index: 0;
            width: 100%;
        }

        .remove-file {
          display: none;
          z-index: 1;
          margin-top: 1px
        }

        .d-nav {
            padding: clamp(1vw, 2vw, 0.2rem) 2.78rem 0.2rem;
        }

        .client-body {
            width: 100%;
            margin-top: 5px;
            padding: clamp(1vw, 2vw, 0.7rem) 3.2rem 0.7rem;
        }

        .application-hold {
            width: 30%
        }

        .testimonial-group .row .mb-1 {
            margin: 0px
        }
      
      .profile-pic-cstm {
      
        max-width: 100%;
    	max-height: 100%;
      }
        

        @media (max-width: 600px) {
            .d-nav {
                padding: clamp(1vw, 2vw, 0.1rem) 0.4rem 0.1rem;
            }

            .client-body {
                margin-top: -8px;
                padding: clamp(1vw, 2vw, 0rem) 1rem 0rem;
            }

            .application-hold {
                width: 100%;
            }


            .testimonial-group > .row::-webkit-scrollbar {
                height: 2px;
                display: block;
                background-color:#a3ccdb;
                border-radius: 4px;
                
            }
            
        }

        @media (max-width: 1290px) { 
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                width: 84%;
            }
        }

         @media (max-width: 1200px){
            .modal-xl {
                margin-left: auto;
                margin-right: 65px;
                max-width: 85.40%;
            }
        }

        @media (max-width: 1150px){
            .modal-xl {
                margin-left: auto;
                margin-right: 64px;
                max-width: 85%;
            }

        }

        @media (max-width: 995px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 80.40%;
            }
        }

        @media (max-width: 900px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 78%;
            }
        }

        @media (max-width: 800px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 77%;
            }
        }

        @media (max-width: 700px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 73%;
            }
        }

        @media (max-width: 350px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 73%;
            }
        } 

        </style>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">


        <div class="min-h-screen">

        <div class="">
            @include('layouts.client-navigation')
        </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            

            <!-- Page Content -->
            <main>

            <div class="" style="">
                {{ $slot }}
            </div>

                <div class="footer" style="">
                    @include('layouts.client-footer')
                </div>
            </main>

        </div>

        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>  
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>  
        <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('bootstrap/dist/js/popper.js') }}"></script>
        <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bootstrap/dist/js/main.js') }}"></script>


    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(document).ready(function() {
    $('#myTable2').DataTable( {
      dom: "<'row'<'col-sm-12 col-md-4'><'col-sm-12 col-md-4'f><'col-sm-12 col-md-4'l>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
      
        "order": [[ 1, "asc" ]], // will it sort only for that page?
        // "paging":   false,
        "lengthMenu": [[10, 50, 100, 150], [10, 50, 100, 150]] ,
        // scrollY: 400
        language: {
        searchPlaceholder: "Search records",
        search: "",
      },
      // "dom": '<"myCustomClass">rt<"top"lp><"clear">', // Positions table elements

    } );
    
} );
</script>

    </body>
</html>
