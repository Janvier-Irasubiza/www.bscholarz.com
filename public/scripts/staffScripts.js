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
    const diff = Math.abs(now - commentTime) / 1000;

    if (diff < 60) return 'now';
    if (diff < 3600) return `${Math.floor(diff / 60)} minute${Math.floor(diff / 60) > 1 ? 's' : ''} ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)} hour${Math.floor(diff / 3600) > 1 ? 's' : ''} ago`;

    const days = Math.floor(diff / 86400);
    if (days === 1) return 'yesterday';
    return `${days} day${days > 1 ? 's' : ''} ago`;
}

function loadComments() {
    fetch('/staff/app/comments') 
        .then(response => response.json())
        .then(data => {
            const modalBody = document.getElementById('commentsBody');
            modalBody.innerHTML = ''; 

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
                            </div>
                            <p class="mt-1">${comment.comment}</p>
                            ${repliesHTML != '' ?
                            `<div class="mt-3 mb-3 pl-3 d-flex gap-3 align-items-start">
                                <i class="fa-solid fa-reply f-18 text-muted" style="transform: rotate(180deg);"></i>
                                <div class="w-full">${repliesHTML}</div>
                            </div>` : ''}
                            
                            <div id="reply-${comment.id}" class="reply-div" style="display: none;">
                                <form action="{{ route('app.comments.reply') }}" method="POST"> 
                                <div class="d-flex gap-2 justify-content-between align-items-center mt-3 mb-3">
                                    <input type="hidden" name="comment_id" class="form-control py-1" value="${comment.id}" readonly>
                                    <input type="text" name="reply" class="form-control py-1" placeholder="Reply to ${comment.name}" autofocus required>
                                    <button type="submit" class="cst-primary-btn px-4 py-1" onclick="replyToComment(${comment.id})">Reply</button>
                                </div>
                                </form>
                            </div>
                            
                            <div class="flex gap-4 mt-2">
                                <button class="f-15 muted-btn reply-btn" data-comment-id="${comment.id}">Reply</button>
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

function replyToComment(commentId) {
    // Find the reply input and the form for the given comment ID
    const replyInput = document.querySelector(`#reply-${commentId} input[name="reply"]`);
    const form = document.querySelector(`#reply-${commentId} form`);
    

    // Get the reply text
    const replyText = replyInput.value.trim();

    if (!replyText) {
        alert("Reply cannot be empty!"); // Validation
        return;
    }

    // Prepare form data for submission
    const formData = new FormData(form);

    // Disable the button to prevent duplicate submissions
    const submitButton = document.querySelector(`#reply-${commentId} button[type="submit"]`);
    submitButton.disabled = true;

    // Send a POST request using fetch
    fetch("/md/app/comments/reply", {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest', // Indicates an AJAX request
            'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token if needed
        },
        body: formData, // Form data to send
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            loadComments();

            // Optionally hide the reply input and reset the form
            document.querySelector(`#reply-${commentId}`).style.display = 'none';
            form.reset();
            document.querySelector(`button[data-comment-id="${commentId}"]`).textContent = "Reply";
        })
        .catch(error => {
            // Handle error
            alert("Failed to submit reply. Please try again.");
            console.error("Error:", error);
        })
        .finally(() => {
            // Re-enable the submit button
            submitButton.disabled = false;
        });
}


// Listen for the modal show event
var repliesModal = document.getElementById('users');
    repliesModal.addEventListener('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var commentId = button.data('comment');
        handleRecommendToReply(commentId);
}); 

// Delegated event listener for Cancel link
document.getElementById('repliesBody').addEventListener('click', function(event) {
    if (event.target.classList.contains('cancel-link')) {
        const userId = event.target.getAttribute('data-user-id');
        const commentId = event.target.getAttribute('data-comment-id');
        cancelSelection(userId, commentId);
    }
});
