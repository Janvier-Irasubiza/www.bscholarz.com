<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BScholarz - @yield('title')</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('styles.css') }}?v={{ filemtime(public_path('styles.css')) }}">
    <link rel="stylesheet"
        href="{{ asset('bootstrap/css/bootstrap.min.css') }}?v={{ filemtime(public_path('bootstrap/css/bootstrap.min.css')) }}">
    <link rel="stylesheet"
        href="{{ asset('fa-icons/css/all.css') }}?v={{ filemtime(public_path('fa-icons/css/all.css')) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- TinyMCE Script -->
    <script src="https://cdn.tiny.cloud/1/7ytstwdjbe27dcidmq5rnasle0m9zq4pmgjn0txxs17vvbca/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '.textarea',
            content_css: "{{ asset('textarea.css') }}",
            plugins: 'charmap emoticons lists wordcount casechange autocorrect typography',
            toolbar: 'undo redo | bold italic underline | numlist indent outdent | emoticons charmap',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'BScholars',
            menubar: '',
        });
    </script>

    <!-- Custom Styles -->
    <style>
        body,
        .modal-content {
            margin: 0;
            background: url("data:image/svg+xml,%3Csvg viewBox='0 0 250 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='15.64' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E") #ccf2ff;
        }

        .modal-xl {
            margin: auto;
            width: 81.7%;
        }

        .active-sect {
            background: #ccf2ff;
            border-radius: 50px 0 0 50px;
            padding-left: 13px;
            width: 18rem;
        }

        .carousel-item {
            border-radius: 10px;
        }

        .sidebar {
            position: fixed;
            padding: 0;
            top: 0;
            bottom: 0;
            width: 20%;
            background: #d4e7ee;
            height: auto
        }

        .section-right {
            margin-top: -2.77rem;
            top: 88px;
            width: 80%;
        }

        .footer {
            position: absolute;
            bottom: 0;
            width: 80%;
        }

        .upload-file,
        .profile-file-input {
            position: absolute;
            font-size: 8px;
            width: 35px;
            left: -1px;
            opacity: 0;
            z-index: 0;
        }

        .remove-file {
            display: none;
            z-index: 1;
            margin-top: 1px;
        }

        .navigation-bar {
            width: 80%;
            margin-left: auto;
        }

        @media (max-width: 600px) {

            body,
            .modal-content {
                background: #ccf2ff;
            }
        }

        @media (max-width: 1290px) {
            .modal-xl {
                width: 84%;
            }
        }

        @media (max-width: 1200px) {
            .modal-xl {
                max-width: 85.4%;
            }
        }

        @media (max-width: 1150px) {
            .modal-xl {
                max-width: 85%;
            }
        }

        @media (max-width: 995px) {
            .modal-xl {
                max-width: 80.4%;
            }
        }

        @media (max-width: 900px) {
            .modal-xl {
                max-width: 78%;
            }
        }

        @media (max-width: 800px) {
            .modal-xl {
                max-width: 77%;
            }
        }

        @media (max-width: 700px) {
            .modal-xl {
                max-width: 73%;
            }
        }

        @media (max-width: 350px) {
            .modal-xl {
                max-width: 73%;
            }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Sidebar -->
    @if(Auth::user())
        @include('layouts.sidebar')
    @elseif(Auth::guard('staff')->check() && Auth::guard('staff')->user()->department == 'Marketing')
        @include('layouts.partials.md-sidebar')

        <!-- Marketing department -->
    @elseif(Auth::guard('staff')->check() && Auth::guard('staff')->user()->department == 'Accountability' || Auth::guard('staff')->user()->department == 'accountability')
        @include('layouts.acc-sidebar')

    @else
        @include('layouts.sidebar')
    @endif

    <div class="min-h-screen">
        <!-- Navigation -->
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
            <div class="section-right" style="padding: 0; margin-left: auto;">
                {{ $slot }}
            </div>

            <!-- Toast Notification -->
            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                <div class="toast" id="liveToastSent" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <strong class="me-auto">Mails were sent</strong>
                        <button type="button" class="" data-bs-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="fa fa-times"></span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Emails were successfully sent.
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- <users> -->
    <div class="modal fade" id="users" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: #fff !important;">
                <div class="p-3 d-flex justify-content-between align-items-center"
                    style="border-bottom: 1px solid #e6e6e6">
                    <div class="text-left">
                        <p class="m-0" style="font-size: 20px;">
                            <strong class="f-20">Recommend to Reply</strong>
                        </p>
                        <p class="text-muted f-15">Recommend this comment to</p>
                    </div>
                    <button class="btn btn-danger" data-bs-dismiss="modal"
                        style="font-weight: 500; font-size: 15px">CLOSE</button>
                </div>
                <div class="modal-body text-left" id="repliesBody">
                    <!-- Users -->
                </div>
            </div>
        </div>
    </div>
    <!-- </users> -->

    <!-- Scripts -->
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script> -->
    <script src="{{ asset('bootstrap/dist/js/popper.js') }}"></script>
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/dist/js/main.js') }}"></script>

    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('scripts/app.js') }}"></script>
    <!-- <script src="{{ asset('scripts/conv.js') }}"></script> -->
</body>

</html>