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
    fetch('/md/app/comments') 
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
            console.log("Server response:", data);

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


// Suscribtions
function toggleActive(type) {
    // Get the button, check element, and text element
    const button = document.getElementById('user-' + type);
    const checkElement = document.getElementById('check-' + type);
    const textElement = button.querySelector('.select-text');
    const hiddenInput = document.getElementById('selected-plan-' + type.toLowerCase());    

    if (button.classList.contains('active')) {
        // If already active, remove active class, hide check element, and update text
        button.classList.remove('active');
        checkElement.style.display = 'none';
        textElement.textContent = 'Click to select';
        hiddenInput.disabled = true;
    } else {
        // If not active, add active class, show check element, and update text
        button.classList.add('active');
        checkElement.style.display = 'block';
        textElement.textContent = 'Click to unselect';
        hiddenInput.disabled = false;
    }
}

function removeActive(type) {
    // Remove active class, hide check element, and reset text to "Click to select"
    const button = document.getElementById('user-' + type);
    const checkElement = document.getElementById('check-' + type);
    const textElement = button.querySelector('.select-text');

    button.classList.remove('active');
    checkElement.style.display = 'none';
    textElement.textContent = 'Click to select';
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#composeMessageForm');
    const sendButton = form.querySelector('button[type="submit"]');

    if (!form) {
        console.error("Form with id 'composeMessageForm' not found.");
        return;
    }

    form.addEventListener('submit', function(event) {
        event.preventDefault(); 

        const buttons = document.querySelectorAll('.ctm-button');
        const errorMessage = document.getElementById('subscription-error');
        const contactErrorMessage = document.getElementById('contact-method-error');
        const isAnyButtonSelected = Array.from(buttons).some(button => button.classList.contains('active'));
        const checkboxes = document.querySelectorAll('input[name="contact_methods[]"]');
        const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        const successAlert = document.querySelector('#successMsgDiv');
        const alertBox = successAlert.querySelector('.alert');
        const successMessage = document.getElementById('successMessage');

        // Show error if no button is selected
        errorMessage.style.display = isAnyButtonSelected ? 'none' : 'block';

        // Show error if no contact method is selected
        contactErrorMessage.style.display = isChecked ? 'none' : 'block';

        // Only proceed with AJAX if all validation passes
        if (isAnyButtonSelected && isChecked) {
            const selectedPlans = Array.from(buttons)
                .filter(button => button.classList.contains('active'))
                .map(button => button.id.replace('user-', ''));

            const selectedContactMethods = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            const formData = new FormData(form);
            formData.append('selected_plans', JSON.stringify(selectedPlans));
            formData.append('contact_methods', JSON.stringify(selectedContactMethods));

            // Change button to show loading animation
            sendButton.textContent = "SENDING";
            sendButton.disabled = true;

            // Create a function to animate dots
            let dotCount = 0;
            const animateDots = setInterval(() => {
                sendButton.textContent = `SENDING${'.'.repeat(dotCount % 4)}`;
                dotCount++;
            }, 500); // Change dots every 0.5 seconds

            // Send AJAX request using fetch
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                // Stop the loading animation
                clearInterval(animateDots);
                sendButton.textContent = "SEND MESSAGE";
                sendButton.disabled = false;

                // Display the response in the alert div
                successAlert.style.display = 'block';

                // Clear both success and error classes on the inner alert div
                alertBox.classList.remove('alert-success', 'alert-danger');

                if (data.status === 'success') {
                    successMessage.textContent = data.message;
                    alertBox.classList.add('alert-success');

                    // Reset form fields on success
                    form.reset();
                    buttons.forEach(button => button.classList.remove('active'));
                    document.getElementById('check-basic').style.display = 'none';
                    document.getElementById('check-standard').style.display = 'none';
                    document.getElementById('check-premium').style.display = 'none';
                } else {
                    successMessage.textContent = data.message;
                    alertBox.classList.add('alert-danger');
                }
            })
            .catch(error => {
                console.error("Error:", error);

                // Stop the loading animation
                clearInterval(animateDots);
                sendButton.textContent = "SEND MESSAGE";
                sendButton.disabled = false;

                // Display the error message
                successMessage.textContent = "An unexpected error occurred. Please try again later.";
                successAlert.style.display = 'block';

                alertBox.classList.remove('alert-success', 'alert-danger');
                alertBox.classList.add('alert-danger');
            });
        }
    });
});

