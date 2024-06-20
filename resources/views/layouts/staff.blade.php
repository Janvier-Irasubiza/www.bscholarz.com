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

    <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>

    @if($errors -> has('email') || $errors -> has('password'))
    <script>
        $(window).on('load', function() {
      $('#createNewStudent').modal('show');
      });
    </script>
    @endif

    <style>

        body, .modal-content{
            margin: 0px;
            background-color: #EBF0FF
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
            width: 80%;
            left: auto;
            right: 0px

        } 
      
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
      
      	 .profile-pic-cstm {
      
        max-width: 100%;
    	max-height: 100%;
      }
        

        #txt-custom {
            display: none
        }

        #customActivityCost {
            display: none
        }

        #amountPaid {
            display: none
        }

        #partialDeptPayment {
            display: none;
        }

        .undo {
            display: none
        }

        

        @media only screen and (max-width: 1290px) { 
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                width: 84%;
            }
        }

         @media only screen and (max-width: 1200px){
            .modal-xl {
                margin-left: auto;
                margin-right: 65px;
                max-width: 85.40%;
            }
        }

        @media only screen and (max-width: 1150px){
            .modal-xl {
                margin-left: auto;
                margin-right: 64px;
                max-width: 85%;
            }

        }

        @media only screen and (max-width: 995px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 80.40%;
            }
        }

        @media only screen and (max-width: 900px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 78%;
            }
        }

        @media only screen and (max-width: 800px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 77%;
            }
        }

        @media only screen and (max-width: 700px){
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 73%;
            }
        }

        @media only screen and (max-width: 350px){
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

    @include('layouts.staff-sidebar')

        <div class="min-h-screen">

        <div class="navigation-bar">
            @include('layouts.navigation')
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

            <div class="section-right" style="padding: 0px; margin-left: auto; right: 0px">
                {{ $slot }}
            </div>
            
                <!-- <div class="footer">
                    @include('layouts.footer')
                </div> -->
            </main>

        </div>

        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>  
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>  
        <script src="{{ asset('bootstrap/dist/js/popper.js') }}"></script>
        <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bootstrap/dist/js/main.js') }}"></script>


    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
