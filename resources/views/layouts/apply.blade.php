<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BScholarz - @yield('title')</title>

    <link rel="stylesheet" href="{{ asset('styles.css') }}?v={{ filemtime(public_path('styles.css')) }}">
    <link rel="stylesheet"
        href="{{ asset('bootstrap/css/bootstrap.min.css') }}?v={{ filemtime(public_path('bootstrap/css/bootstrap.min.css')) }}">
    <link rel="stylesheet"
        href="{{ asset('fa-icons/css/all.css') }}?v={{ filemtime(public_path('fa-icons/css/all.css')) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
    <link rel="icon" type="image/png" href="{{ asset('images/BScholarz_Logo_edit.png') }}">

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">


    <style>
        body,
        .modal-content {
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


        .carousel-item {
            float: none;
            transition: 0s !important;
            border-radius: 10px
        }

        .modal-backdrop {
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
        .testimonial-group>.row {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
        }



        .testimonial-group>.row>.col-xs-4 {
            padding: 10px 0px;
            margin: 0px
        }

        .testimonial-group>.row::-webkit-scrollbar {
            display: none
        }

        /* Decorations */
        .col-xs-4 {}

        ul {
            list-style: none;
            text-align: left;
        }

        /*
        ul li:before {
            content: '✓';
        }
         */

        .file-upload {
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
            padding: clamp(1vw, 2vw, 0.7rem) 2.78rem 0.7rem;
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

        .padding {
            padding: 2em 8em
        }

        .s-font {
            font-size: 30px
        }

        .sm-section {
            margin: auto;
            width: 60%;
            display: block;
            align-items: center;
        }

        .phone-form {
            display: none
        }

        .phone-form.show {
            display: block
        }

        .card-form {
            display: none
        }

        .confirm {
            display: none
        }

        .confirm.show {
            display: block
        }

        .paybtn {
            border: 1px solid;
            border-radius: 5px
        }


        .paybtn:focus {
            border: 2px solid
        }


        @media (max-width: 600px) {

            .sm-section {
                margin: auto;
                width: 85%;
            }

            .s-font {
                font-size: 20px;
                font-weight: 600
            }

            .padding {
                padding: 5em 9em
            }

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


            .testimonial-group>.row::-webkit-scrollbar {
                height: 2px;
                display: block;
                background-color: #a3ccdb;
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

        @media (max-width: 1200px) {
            .modal-xl {
                margin-left: auto;
                margin-right: 65px;
                max-width: 85.40%;
            }
        }

        @media (max-width: 1150px) {
            .modal-xl {
                margin-left: auto;
                margin-right: 64px;
                max-width: 85%;
            }

        }

        @media (max-width: 995px) {
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 80.40%;
            }
        }

        @media (max-width: 900px) {
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 78%;
            }
        }

        @media (max-width: 800px) {
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 77%;
            }
        }

        @media (max-width: 700px) {
            .modal-xl {
                margin-left: auto;
                margin-right: 70px;
                max-width: 73%;
            }
        }

        @media (max-width: 350px) {
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

<body class="font-sans antialiased border p-0">

    <nav class="" style="margin-top: -1px">
        <div class="container-fluid">

        <div class="nav-wrapper">

            <div class="d-flex gap-3 justify-content-between align-items-center">
                <button class="nav-drawer" href="">
                    <i class="fa-solid fa-bars dft-btn"></i>
                </button>

                <button class="aft-btn" href="">
                    <i class="fa-solid fa-arrow-up"></i>
                </button>

                <div class="bbg-logo col-lg-12 d-flex align-items-center">
                    <img src="{{ asset('images') }}/{{ 'BScholarz_Logo.png' }}" class="img-responsive" alt="Logo">
                </div>
            </div>

            <div style="padding: 0px;" class="nav-container container-fluid">
                <div class="d-flex justify-content-between align-items-center" style="margin-left: 10px; width: 100%;">

                    <div style="padding: 0px" class="nav-links-contianer">
                        <ul style="margin: 0px;">
                            <li class="navigator">
                                <a class="{{ request()->routeIs('home') ? 'active-navigator' : '' }}"
                                    href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="navigator">
                                <a class="{{ request()->routeIs('BeScholar') || (request()->is('learnMore/*') && request()->segment(2) === 'scholar') ? 'active-navigator' : '' }}"
                                    href="{{ route('BeScholar') }}">Be a Scholar</a>
                            </li>
                            <li class="navigator">
                                <a class="{{ request()->routeIs('get-employed') || (request()->is('learnMore/*') && request()->segment(2) === 'employed') ? 'active-navigator' : '' }}"
                                    href="{{ route('get-employed') }}">Get Employed</a>
                            </li>
                            <li class="navigator">
                                <a class="{{ request()->routeIs('fellowships-trainings') || (request()->is('learnMore/*') && request()->segment(2) === 'fellowships') ? 'active-navigator' : '' }}"
                                    href="{{ route('fellowships-trainings') }}">Fellowships & Trainings</a>
                            </li>

                            <li class="navigator"><a
                                    class="{{ request()->routeIs('about-us') ? 'active-navigator' : '' }}"
                                    href="{{ route('about-us') }}">About Us</a></li>
                            <li class="navigator"><a
                                    class="{{ request()->routeIs('contact-us') ? 'active-navigator' : '' }}"
                                    href="{{ route('contact-us') }}">Contact Us</a>
                            </li>
                            <li class="navigator"><a
                                    class="{{ request()->routeIs('membership') || (request()->is('membership/*')) ? 'active-navigator' : '' }}"
                                    href="{{ route('membership') }}">Membership</a>
                            </li>
                        </ul>
                    </div>

                    <div class="nav-section-right" style="padding: 0px;">
                        <div class="d-flex gap-3 justify-content-end align-items-center" style="padding: 0px;">

                            <div class="d-flex align-items-center" style="margin-right: 10px;">

                                <button style="padding: 0px; border: none; background: none; font-size: 1.2rem; color: #646464" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true" style="">
                                    <div class="modal-dialog modal-xl" style="z-index: 1000;" role="document">
                                        <div class="modal-content">
                                            <div style="" class="modal-header">
                                                <form action="{{ route('search') }}" class="w-full">
                                                    <div class="d-flex">
                                                        <input id="searchBox" class="input-box" type="text"
                                                            placeholder="Type here....." name="search_keyword"
                                                            required autofocus />
                                                        <button class="search-sub-btn">
                                                            <span class="fa-solid fa-magnifying-glass"></span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>

                                            @php $sugs = DB::table('search_suggestions')->where('count', '>', 2)->get(); @endphp

                                            @if($sugs)

                                                <div class="modal-body">
                                                    <h5>Suggestions:</h5>
                                                    <div style="padding: 0px;" class="">
                                                        <ul style="margin: 0px; padding: 0px">


                                                            @foreach($sugs as $sug)

                                                                <li class="sugest-navigator mb-1"><a
                                                                        href="{{ route('search', ['search_keyword' => $sug->keyword]) }}">
                                                                        <small>#</small> {{ $sug->keyword }}</a></li>

                                                            @endforeach

                                                        </ul>
                                                    </div>
                                                </div>

                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <!-- End of modal -->

                            </div>

                        <a href="{{ route('payment') }}" class="apply-btn py-2 pay-btn" style="border: none;">
                            Pay
                        </a>

                            <a
                                href="{{ Auth::guard('client')->user() ? route('client.client-dashboard') : route('login') }}" class="snd-apply-btn py-2">


                                @if(Auth::guard('client')->user() && Auth::guard('client')->user()->profile_picture)
                                    <div class="user-profile">

                                        <img src="{{ asset('profile_pictures') }}/{{ Auth::guard('client')->user()->profile_picture }}"
                                            alt="">
                                    </div>
                                @else
                                    Join Us
                                @endif
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            </div>
        </div>

        @if(Session::has('failed_req'))

                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast"
                    style="position: absolute; top: 15px; right: 18px; z-index: 10">
                    <div class="toast-header justify-content-between">
                        <div class="d-flex gap-3 align-items-center">
                            <span class="fa-solid fa-square-xmark"
                                style="color: #CC0000; border-radius: 5px; font-size: 25px"></span>
                            <span><strong class="mr-auto">Failed to send you request!</strong></span>
                        </div>
                        <button type="button" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none"
                            data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ Session::get('failed_req') }} <a class="apply-btn ml-1"
                            style="text-decoration: none; color: ghostwhite"> retry </a>
                    </div>
                </div>

                @php
                    session()->forget('failed_req');
                    session()->flush();
                  @endphp

        @endif

        @if(Session::has('exist'))

                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="toast"
                    style="position: absolute; top: 15px; right: 18px; z-index: 10">
                    <div class="toast-header justify-content-between">
                        <div class="d-flex gap-3 align-items-center">
                            <span class="fa-solid fa-square-xmark"
                                style="color: #CC0000; border-radius: 5px; font-size: 25px"></span>
                            <span><strong class="mr-auto">Request already exist!</strong></span>
                        </div>
                        <button type="button" class="ml-2 mb-1 close" style="border: none; font-size: 20px; background: none"
                            data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{ Session::get('exist') }}
                    </div>
                </div>

                @php
                    session()->forget('exist');
                    session()->flush();
                  @endphp

        @endif

    </nav>

    <div style="padding: 0px; z-index: 10" class="nav-links-drawer">
        <ul style="margin: 0px; padding: 3px 0px">
            <li class="small-navigator"><a href="{{ route('home') }}">Home</a></li>
            <li class="small-navigator"><a href="{{ route('BeScholar') }}">Be a Scholar</a></li>
            <li class="small-navigator"><a href="{{ route('get-employed') }}">Get Employed</a></li>
            <li class="small-navigator"><a href="{{ route('fellowships-trainings') }}">Fellowship & Trainings</a></li>
            <li class="small-navigator"><a href="{{ route('about-us') }}">About Us</a></li>
            <li class="small-navigator"><a href="{{ route('contact-us') }}">Contact Us</a></li>
        </ul>
    </div>


    <div class="min-h-screen">
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

        </main>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

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

        $('#toast').toast({ delay: 30000 });
        $('#toast').toast('show');

        $(document).ready(function () {
            $('#submitPayment').on('click', function (e) {
                e.preventDefault();

                const phoneInput = $('#phone');
                const phoneValue = phoneInput.val();

                phoneInput.removeClass('is-invalid');
                $('.response').html('');

                if (!phoneValue) {
                    phoneInput.addClass('is-invalid');
                    $('.response').html(`
            <div class="alert alert-danger mt-3" role="alert">
                <p>Phone number is required.</p>
            </div>
        `);
                    $(this).text('Proceed with MoMo').prop('disabled', false);
                    return;
                }

                $(this).text('Processing...').prop('disabled', true);

                const action = $('#momoPaymentForm').attr('action');
                const payment_method = $('input[name="payment_method"]:checked').val();

                const form = document.getElementById('momoPaymentForm');
                const formData = new FormData(form);
                const jsonData = Object.fromEntries(formData.entries());

                // {
                //     app_id: $('#app_id').val(),
                //     identifier: $('#identifier').val(),
                //     applicant: $('#applicant').val(),
                //     amount: $('#amount').val(),
                //     phone: $('#phone').val(),
                //     payment_method: payment_method,
                // };

                const responseDiv = document.querySelector('.response');

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(jsonData),
                })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status === 200) {
                            window.location.replace(data.redirect_uri);
                        } else {
                            responseDiv.innerHTML = `
                            <div class="alert alert-danger mt-3" role="alert">
                                <p>${data.message}</p>
                            </div>`;
                        }

                        $('#submitPayment').text('Proceed with momo').prop('disabled', false);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        responseDiv.innerHTML = `
                        <div class="alert alert-danger mt-3" role="alert">
                            <p>An error occurred. Please try again.</p>
                        </div>`;

                        $('#submitPayment').text('Proceed with MoMo').prop('disabled', false);
                    });
            });

            $('#cardPayment').on('click', function (e) {
                e.preventDefault();

                $(this).text('Processing...').prop('disabled', true);
                const action = $('#cardPaymentForm').attr('action');
                const payment_method = $('input[name="payment_method"]:checked').val();

                const form = document.getElementById('cardPaymentForm');
                const formData = new FormData(form);
                const jsonData = Object.fromEntries(formData.entries());

                // const formData = {
                //     app_id: $('#app_id').val(),
                //     identifier: $('#identifier').val(),
                //     applicant: $('#applicant').val(),
                //     amount: $('#amount').val(),
                //     phone: $('#phone').val(),
                //     payment_method: payment_method,
                // };

                const responseDiv = document.querySelector('.cc-response');

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(jsonData),
                })
                    .then(response => response.json())
                    .then(data => {

                        if (data.status === 200) {
                            window.location.replace(data.link);
                        } else {
                            responseDiv.innerHTML = `
                            <div class="alert alert-danger mt-3" role="alert">
                                <p>${data.message}</p>
                            </div>`;
                        }

                    })
                    .catch(error => {
                        console.error('Error:', error);
                        responseDiv.innerHTML = `
                        <div class="alert alert-danger mt-3" role="alert">
                            <p>An error occurred. Please try again.</p>
                        </div>`;

                        $('#cardPayment').text('Proceed with card').prop('disabled', false);
                    });
            });



        });

        $(document).ready(function () {
            $('.phone-form').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                $('#submitLinkPayment').text('Processing...').prop('disabled', true);

                const formData = {
                    identifier: $('#service').val(),
                    amount: $('#amount').val(),
                    phone: $('#phone').val(),
                    payment_method: $('input[name="payment_method"]:checked').val(),
                    email: $('#email').val(),
                };

                const responseDiv = document.querySelector('.response');

                fetch('{{ route('link.pay') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(formData),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 200) {
                            window.location.replace("{{ route('link-pay.success') }}");
                        } else {
                            responseDiv.innerHTML = `
                            <div class="alert alert-danger mt-3" role="alert">
                                <p>${data.message}</p>
                            </div>`;
                        }

                        $('#submitLinkPayment').text('Pay service').prop('disabled', false);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        responseDiv.innerHTML = `
                        <div class="alert alert-danger mt-3" role="alert">
                            <p>An error occurred. Please try again.</p>
                        </div>`;
                        $('#submitLinkPayment').text('Pay service').prop('disabled', false);
                    });
            });
        });

        $(document).ready(function () {
            $('.card-form').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                $('#submitLinkPayment').text('Processing...').prop('disabled', true);

                const formData = {
                    identifier: $('#service').val(),
                    amount: $('#amount').val(),
                    phone: $('#phone').val(),
                    payment_method: $('input[name="payment_method"]:checked').val(),
                    email: $('#email').val(),
                };

                const responseDiv = document.querySelector('.cc-response');

                fetch('{{ route('link.pay') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(formData),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 200) {
                            window.location.replace(data.link);
                        } else {
                            responseDiv.innerHTML = `
                            <div class="alert alert-danger mt-3" role="alert">
                                <p>${data.message}</p>
                            </div>`;
                        }

                        $('#submitLinkPayment').text('Pay service').prop('disabled', false);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        responseDiv.innerHTML = `
                        <div class="alert alert-danger mt-3" role="alert">
                            <p>An error occurred. Please try again.</p>
                        </div>`;
                        $('#submitLinkPayment').text('Pay service').prop('disabled', false);
                    });
            });
        });

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

        $(document).ready(function () {
            $('#myTable2').DataTable({
                dom: "<'row'<'col-sm-12 col-md-4'><'col-sm-12 col-md-4'f><'col-sm-12 col-md-4'l>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

                "order": [[1, "asc"]], // will it sort only for that page?
                // "paging":   false,
                "lengthMenu": [[10, 50, 100, 150], [10, 50, 100, 150]],
                // scrollY: 400
                language: {
                    searchPlaceholder: "Search records",
                    search: "",
                },
                // "dom": '<"myCustomClass">rt<"top"lp><"clear">', // Positions table elements

            });

        });

        const momobtn = document.getElementById('momobtn');
        const momochk = document.getElementById('momochk');
        const visabtn = document.getElementById('visabtn');
        const visachk = document.getElementById('visachk');

        const phoneForm = document.querySelector('.phone-form');
        const cardForm = document.querySelector('.card-form');
        const confirm = document.querySelector('.confirm');

        window.onload = function () {
            momobtn.style.border = "2px solid";
            momochk.checked = true;
            phoneForm.style.display = 'block';
            confirm.style.display = 'block';
        };

        visachk.addEventListener('change', function () {
            visabtn.style.border = "2px solid";
        });

        momobtn.addEventListener('click', function () {
            momochk.checked = true;
            momobtn.style.border = "2px solid";
            visabtn.style.border = "1px solid";
            phoneForm.style.display = 'block';
            cardForm.style.display = 'none';
            confirm.style.display = 'block';
        });

        visabtn.addEventListener('click', function () {
            visachk.checked = true;
            momobtn.style.border = "1px solid";
            visabtn.style.border = "2px solid";
            phoneForm.style.display = 'none';
            cardForm.style.display = 'block';
            confirm.style.display = 'block';
        });

    </script>

</body>

</html>
