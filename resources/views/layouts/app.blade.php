<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>BScholarz - @yield('title')</title>

        <!-- Stylesheets -->
        <link rel="stylesheet" href="{{ asset('styles.css') }}?v={{ filemtime(public_path('styles.css')) }}">
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}?v={{ filemtime(public_path('bootstrap/css/bootstrap.min.css')) }}">
        <link rel="stylesheet" href="{{ asset('fa-icons/css/all.css') }}?v={{ filemtime(public_path('fa-icons/css/all.css')) }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <!-- TinyMCE Script -->
        <script src="https://cdn.tiny.cloud/1/7ytstwdjbe27dcidmq5rnasle0m9zq4pmgjn0txxs17vvbca/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
            body, .modal-content {
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
            .carousel-item { border-radius: 10px; }
            .sidebar { position: fixed; padding: 0; top: 0; bottom: 0; width: 20%; background: #d4e7ee; height: auto}
            .section-right { margin-top: -2.77rem; top: 88px; width: 80%; }
            .footer { position: absolute; bottom: 0; width: 80%; }
            .upload-file, .profile-file-input {
                position: absolute; font-size: 8px; opacity: 0; z-index: 0;
            }
            .remove-file { display: none; z-index: 1; margin-top: 1px; }
            .navigation-bar { width: 80%; margin-left: auto; }

            @media (max-width: 600px) {
                body, .modal-content { background: #ccf2ff; }
            }
            @media (max-width: 1290px) { .modal-xl { width: 84%; } }
            @media (max-width: 1200px) { .modal-xl { max-width: 85.4%; } }
            @media (max-width: 1150px) { .modal-xl { max-width: 85%; } }
            @media (max-width: 995px) { .modal-xl { max-width: 80.4%; } }
            @media (max-width: 900px) { .modal-xl { max-width: 78%; } }
            @media (max-width: 800px) { .modal-xl { max-width: 77%; } }
            @media (max-width: 700px) { .modal-xl { max-width: 73%; } }
            @media (max-width: 350px) { .modal-xl { max-width: 73%; } }
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
        @elseif(Auth::guard('staff')->check() && Auth::guard('staff')->user()->department == 'Accountability' || department == 'accountability')
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
        <div class="modal fade" id="users" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background: #fff !important;">
                    <div class="p-3 d-flex justify-content-between align-items-center" style="border-bottom: 1px solid #e6e6e6">
                        <div class="text-left">
                            <p class="m-0" style="font-size: 20px;">
                                <strong class="f-20">Recommend to Reply</strong>
                            </p>
                            <p class="text-muted f-15">Recommend this comment to</p>
                        </div>
                        <button class="btn btn-danger" data-bs-dismiss="modal" style="font-weight: 500; font-size: 15px">CLOSE</button>
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
        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

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

        <script>

            $(document).ready(function() {

                loadComments();

                $('#replyBtn').click(function() {
                    $('.reply-div').toggleClass('show');
                    console.log('clicked');
                });

                $('#example1').DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

                $('#example2').DataTable({
                    paging: true,
                    lengthChange: false,
                    searching: false,
                    ordering: true,
                    info: true,
                    autoWidth: false,
                    responsive: true,
                });
            });

            function timeAgo(time) {
                const now = new Date();
                const commentTime = new Date(time);
                const diff = Math.abs(now - commentTime) / 1000; // Difference in seconds

                if (diff < 60) return 'now';
                if (diff < 3600) return `${Math.floor(diff / 60)} minute${Math.floor(diff / 60) > 1 ? 's' : ''} ago`;
                if (diff < 86400) return `${Math.floor(diff / 3600)} hour${Math.floor(diff / 3600) > 1 ? 's' : ''} ago`;

                // For comments older than 1 day
                const days = Math.floor(diff / 86400);
                if (days === 1) return 'yesterday';
                return `${days} day${days > 1 ? 's' : ''} ago`;
            }

            function loadComments() {
                // Make an AJAX request to the 'comments' route
                fetch('/md/app/comments')
                    .then(response => response.json())
                    .then(data => {
                        const modalBody = document.getElementById('commentsBody');
                        modalBody.innerHTML = ''; // Clear previous content

                        // Loop through comments and display them
                        data.forEach(comment => {
                            const commentDiv = document.createElement('div');
                            commentDiv.className = 'border-bottom p-2';

                            // Generate replies HTML
                            let repliesHTML = '';
                            comment.replies.forEach(reply => {
                                repliesHTML += `
                                    <div class="d-flex gap-2 mb-3">
                                        <div class="w-full text-left">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="">
                                                    <p class="f-15" style="font-weight: 700">${reply.user_name}</p>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-muted f-13">${timeAgo(reply.created_at)}</p>
                                                </div>
                                            </div>
                                            <p class="f-13">${reply.reply}</p>
                                            <button class="f-13 muted-btn" onclick="deleteReply(${reply.id})">Delete</button>
                                        </div>
                                    </div>`;
                            });

                            // Comment HTML with replies included
                            commentDiv.innerHTML = `
                                <div class="d-flex gap-3">
                                    <div>
                                        <div class="user-profile">
                                            ${comment.profile ?
                                            `<img src="/profile_pictures/${comment.profile}" alt="User-Account" class="profile-pic">` :
                                            `<img src="/images/profile.png" alt="Default User-Account">`}
                                        </div>
                                    </div>
                                    <div class="w-full text-left">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="f-16" style="font-weight: 700">${comment.name}</p>
                                                <p class="text-muted f-12">${timeAgo(comment.created_at)}</p>
                                            </div>
                                            <div>
                                                ${comment.status == 'inactive' ?
                                                `<span class="btn btn-danger badge badge-danger" disabled>${comment.status}</span>` :
                                                `<span class="btn btn-success badge badge-success" disabled>${comment.status}</span>`}
                                            </div>
                                        </div>
                                        <p class="mt-1">${comment.comment}</p>
                                        ${repliesHTML != '' ?
                                        `<div class="mt-3 mb-3 pl-3 d-flex gap-3 align-items-start">
                                            <i class="fa-solid fa-reply f-18 text-muted" style="transform: rotate(180deg);"></i>
                                            <div class="w-full">${repliesHTML}</div>
                                        </div>` : ''}

                                        <div id="reply-${comment.id}" class="reply-div" style="display: none;">
                                            <form action="{{ route('app.comments.reply') }}" method="POST">
                                            @csrf
                                            <div class="d-flex gap-2 justify-content-between align-items-center mt-3 mb-3">
                                                <input type="hidden" name="comment_id" class="form-control py-1" value="${comment.id}" readonly>
                                                <input type="text" name="reply" class="form-control py-1" placeholder="Reply to ${comment.name}" autofocus required>
                                                <button type="submit" class="cst-primary-btn px-4 py-1" onclick="replyToComment(${comment.id})">Reply</button>
                                            </div>
                                            </form>
                                        </div>

                                        <div class="flex gap-4 mt-2">
                                            <button class="f-15 muted-btn reply-btn" data-comment-id="${comment.id}">Reply</button>
                                            <button class="f-15 muted-btn" data-comment="${comment.id}" data-bs-toggle="modal" data-bs-target="#users">Recommend to Reply</button>

                                            ${comment.status == 'inactive' ?
                                            `<button class="f-15 muted-btn" onclick="updateStatus(${comment.id}, 'active')">Post</button>` :
                                            `<button class="f-15 muted-btn" onclick="updateStatus(${comment.id}, 'inactive')">Unpost</button>`}
                                            <button class="f-15 muted-btn" onclick="deleteComment(${comment.id})">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                            modalBody.appendChild(commentDiv);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching comments:', error);
                        document.getElementById('commentsBody').innerHTML = '<p>Error loading comments.</p>';
                    });
            }

            $(document).on('click', '.reply-btn', function() {
                const commentId = $(this).data('comment-id');
                const replyDiv = $(`#reply-${commentId}`);
                const button = $(this);

                replyDiv.toggle();

                if (button.text() === "Reply") {
                    button.text("Cancel");
                } else {
                    button.text("Reply");
                }
            });

            // Listen for the modal show event
            var repliesModal = document.getElementById('users');
                repliesModal.addEventListener('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var commentId = button.data('comment');
                    handleRecommendToReply(commentId);
            });

            function handleRecommendToReply(commentId) {
                const repliesBody = document.getElementById('repliesBody');

                fetch(`/users/${commentId}`)
    .then(response => response.json())
    .then(users => {
        repliesBody.innerHTML = ''; // Clear previous content

        users.forEach(user => {
            // Create user button
            const userDiv = document.createElement('div');
            userDiv.classList.add('user');

            // Set button class based on the recommended status
            const isActive = user.recommended ? 'active' : '';

            userDiv.innerHTML = `
                <button class="w-full p-2 rounded mb-2 ctm-button ${isActive}" id="user-${user.id}" data-user-id="${user.id}" data-comment-id="${commentId}">
                    <div class="d-flex align-items-center gap-3">
                        <div>
                            <div class="user-profile">
                                ${user.profile_picture ?
                                `<img src="/images/${user.profile_picture}" alt="User Image">` :
                                `<img src="/images/profile.png" alt="Default User-Account">`}
                            </div>
                        </div>
                        <div class="flex-grow-1 text-left">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="f-16 fw-bold">${user.names} - <span class="text-muted">${user.type}</span></p>
                                    <p class="text-muted f-15">${user.role}</p>
                                </div>
                                <div class="text-center" id="check-${user.id}">
                                    ${user.recommended ? `
                                        <div>
                                            <i class="fa-solid fa-circle-check f-20 text-success"></i>
                                        </div>
                                        <a class="f-12 muted-btn cancel-link" data-user-id="${user.id}" data-comment-id="${commentId}">Cancel</a>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </button>
            `;

            // Append user button to repliesBody
            repliesBody.appendChild(userDiv);

                            // Add click event listener to each button
                            const userButton = userDiv.querySelector(`#user-${user.id}`);
                            userButton.addEventListener('click', function() {
                                const actionUrl = `/comments/${commentId}/recommend`;
                                // Send update request to the server
                                fetch(actionUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                                    },
                                    body: JSON.stringify({ user_id: user.id, recmmend: true })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Remove active class and check icon/content from all buttons
                                        const allButtons = document.querySelectorAll('.ctm-button');
                                        allButtons.forEach(button => {
                                            button.classList.remove('active');
                                            const checkDiv = button.querySelector('.text-center');
                                            if (checkDiv) {
                                                checkDiv.innerHTML = ''; // Clear the check content for other buttons
                                            }
                                        });

                                        // Add active class and check icon/content to the clicked button
                                        userButton.classList.add('active');
                                        const checkDiv = document.getElementById(`check-${user.id}`);
                                        checkDiv.innerHTML = `
                                            <div>
                                                <i class="fa-solid fa-circle-check f-20 text-success"></i>
                                            </div>
                                            <a class="f-12 muted-btn cancel-link" data-user-id="${user.id}">Cancel</a>
                                        `;
                                    } else {
                                        console.error('Error updating recommendation:', data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error updating recommendation:', error);
                                });
                            });

                            // Event delegation for cancel functionality
                            userDiv.addEventListener('click', (event) => {
                                if (event.target.classList.contains('cancel-link')) {
                                    const userId = event.target.getAttribute('data-user-id');
                                    const checkDiv = document.getElementById(`check-${userId}`);
                                    checkDiv.innerHTML = '';
                                    const button = document.getElementById(`user-${userId}`);
                                    button.classList.remove('active');
                                }
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching users:', error);
                        repliesBody.innerHTML = '<p>Error loading users.</p>';
                    });
            }

            // Delegated event listener for Cancel link
            document.getElementById('repliesBody').addEventListener('click', function(event) {
                if (event.target.classList.contains('cancel-link')) {
                    const userId = event.target.getAttribute('data-user-id');
                    const commentId = event.target.getAttribute('data-comment-id');
                    cancelSelection(userId, commentId);
                }
            });

            // Function to handle cancel selection
            function cancelSelection(userId, commentId) {
                // Clear the check div content for the specified user
                const checkDiv = document.getElementById(`check-${userId}`);
                const actionUrl = `/comments/${commentId}/recommend`;

                // Call the API to cancel recommendation
                fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ user_id: userId, recommend: false }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(data.message);
                        const checkDiv = document.getElementById(`check-${userId}`);

                        if (checkDiv) {
                            checkDiv.innerHTML = '';
                        }

                        // Find and reset the button to inactive state
                        const userButton = document.getElementById(`user-${userId}`);
                        if (userButton) {
                            userButton.classList.remove('active');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }


            // Function to update the status of the comment
            function updateStatus(commentId, status) {
                fetch(`/md/comments/${commentId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadComments();
                    } else {
                        alert('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the status');
                });
            }

            // Function to delete the comment
            function deleteComment(commentId) {
                if (confirm('Are you sure you want to delete this comment?')) {
                    fetch(`/md/comments/${commentId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadComments();
                        } else {
                            alert('Failed to delete comment');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the comment');
                    });
                }
            }

            // Function to delete the reply
            function deleteReply(replyId) {
                if (confirm('Are you sure you want to delete this reply?')) {
                    fetch(`/md/reply/${replyId}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadComments();
                        } else {
                            alert('Failed to delete reply');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the reply');
                    });
                }
            }

        </script>
    </body>
</html>
