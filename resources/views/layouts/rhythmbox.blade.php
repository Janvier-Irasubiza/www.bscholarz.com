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
        <link rel="icon" type="image/png" href="{{ asset('images/BScholarz_Logo_edit.png') }}">

        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <style>

        body, .modal-content{
            margin: 0px;
            background-color: #F8FAFF;
            }

        .modal-xl {
            margin-left: auto;
            margin-right: 75px;
            width: 81.70%;
            z-index: 10;
        }

        .upload-button {
            font-size: 1.5em;
            position: relative;
            color: rgb(74, 128, 182);
        }

        .profile-file-input {
            position: absolute;
            font-size: 8px;
            opacity: 0;
            height: 2em;
            left: 0px;
            z-index: 0;
            width: 100%;
        }

        .p-image {
            position: relative; top: -25px; left: 0em; width: 1.65em;
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
            width: 100%;
            margin-left: auto;
            margin-right: 0px;
        }


        .cst-navigation-bar {
            padding: clamp(1vw, 2vw, 0.2rem) 0rem 0.2rem;
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

        ul li:before {
            content: '✓';
        }

        .upload-file{
          position: absolute;
          font-size: 8px;
          opacity: 0;
          height: 2em;
          z-index: 0;
          width: 25.8%;
        }

        .remove-file {
          display: none;
          z-index: 1;
          margin-top: 1px
        }

        .nav-buttons {
            padding: 6px 20px;
        }

        .nav-buttons.active {
            padding: 6px 20px;
            border-radius: 5px;
            background: #5AB8A4 !important;
            transition: background 0.3s ease-in-out;
            transition: font-weight 0.3s ease-in-out;
            color: ghostwhite
        }

        .nav-buttons:hover {
            font-weight: 600;
            color: #000
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


        <div class="min-h-screen">

        <div class="">
            @include('layouts.rhythmbox-nav')
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

            <div class="px-5" style="">
                {{ $slot }}
            </div>

                <div class="footer" style="">
                    @include('layouts.rhythmbox-footer')
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

$('.nav-buttons').click(function() {
    $('.nav-buttons').classToggle('active');
})

</script>

    </body>
</html>
