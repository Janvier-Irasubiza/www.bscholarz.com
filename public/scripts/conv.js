// new chat
document.addEventListener('DOMContentLoaded', function () {

    function getIssues() {
        fetch('/issues/get', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = '/authenticate';
                throw new Error('Unauthenticated');
            }
            return response.json();        
        })
        .then(data => {
            let chats = '';
            data.forEach(chat => {
                let messageText = chat.lastReply.reply.length > 40 ? chat.lastReply.reply.substring(0, 40) + '...' : chat.lastReply.reply;
                let issue = chat.issue.length > 20 ? chat.issue.substring(0, 20) + '...' : chat.issue;
                let sender = chat.sender.names.length > 15 ? chat.sender.names.substring(0, 15) + '...' : chat.sender.names;
                let receiver = chat.receiver.names.length > 15 ? chat.receiver.names.substring(0, 15) + '...' : chat.receiver.names;
                chats += `
                    <button data-chat="${chat.id}" data-issue="${chat.issue}" data-sender="${chat.sender.names}" data-receiver="${chat.receiver.names}" class="p-0 m-0 py-2 ctm-button px-3 w-full chat-btn" style="border-left: none; border-top: none; border-right: none">
                        <div class="flex justify-between items-center mb-2">
                            <p class="f-18 text-left">${issue}</p>
                            <p class="f-13 text-muted text-right">${chat.created_at ? timeAgo(chat.lastReply.created_at) : ''}</p>
                        </div>
                        <div class="text-muted f-14 text-left mb-2">
                            ${messageText}
                        </div>
                        <div class="flex gap-2 mb-2">
                            <span class="f-11 text-muted px-2 py-1 ctm-button rounded" style="background: none">${sender}</span>
                            <span class="f-11 text-muted ctm-button px-2 py-1 rounded" style="background: none">${receiver}</span>
                        </div>
                    </button>
                `;
            });
            $('.chat-list').html(chats);
        })
        .catch(error => console.error("Error:", error));
    }

    function getIssueContent(chatID) {
        fetch(`/issue/${chatID}/conv`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = '/authenticate';
                throw new Error('Unauthenticated');
            }
            return response.json();
        })
        .then(data => {
            const contentDiv = document.querySelector('.chat-messages');
            let issueContent = '';
        
            data.content.forEach(conv => {
                issueContent += 
                `<div class="flex ${conv.user_id === data.user ? 'justify-end' : 'justify-start'} mb-3">
                    <div class="p-3 col-md-9 ${conv.user_id === data.user ? 'out-bg' : 'in-bg'} rounded">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="f-17" style="font-weight: 600">${conv.user.names}</p>
                                <p class="text-muted mb-2 f-14">${conv.user.role}</p>
                            </div>
                            <p class="f-14 text-muted text-right">${timeAgo(conv.created_at)}</p>
                        </div>
                        <p class="muted-text">${conv.reply}</p>
                    </div>
                </div>`;
            });
            contentDiv.innerHTML = issueContent;
        })        
        .catch(error => {
            $('.chat-area').html(
                `<div class="flex justify-center items-center h-full">
                    <p class="text-center teext-danger f-25 text-muted">Something went wrong</p>
                </div>`
            );
            console.log(error);
        })
    }

    const defaultContent = `
        <div class="flex justify-center items-center h-full">
            <p class="text-center f-25 text-muted">Click a chat to open</p>
        </div>`;

    $('.chat-area').html(defaultContent);

    getIssues();

    $(document).on('click', '.chat-btn', function () {

        let issue = $(this).data('issue').length > 40 ? $(this).data('issue').substring(0, 40) + '...' : $(this).data('issue');
        let sender = $(this).data('sender').length > 15 ? $(this).data('sender').substring(0, 15) + '...' : $(this).data('sender');
        let receiver = $(this).data('receiver').length > 15 ? $(this).data('receiver').substring(0, 15) + '...' : $(this).data('receiver');
        const chatID = $(this).data('chat'); 

        $('.chat-area').html(
            `<div class="chat-header border-b">
                    <div class="flex justify-between p-3 items-center bg-white">
                        <div class="flex gap-3">
                            <div>
                                <p class="f-20 mb-1">${issue}</p>
                                <span class="f-13 text-muted p-2 ctm-button rounded" style="background: none">${sender}</span>
                                <span class="f-13 text-muted ctm-button p-2 rounded" style="background: none">${receiver}</span>
                            </div>
                        </div>
                        <button class="f-25 px-3 close-chat">
                            <i class="fa-regular fa-circle-xmark"></i>
                        </button>
                    </div>
                    <div class="px-3 py-2">
                        <p class="f-15 mb-1">${$(this).data('issue')}</p>
                    </div>
                </div>
                
                <div class="chat-messages p-4 overflow-y-auto" style="flex-grow: 1;">
                </div>

                <div class="chat-input-container border-t">
                    <form action="" method="post">

                        <!-- tags -->
                        <div class="flex gap-2 items-center">
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button" id="user-premium" onclick="toggleActive('premium')">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Request</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button" id="user-premium" onclick="toggleActive('premium')">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Transaction</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button" id="user-premium" onclick="toggleActive('premium')">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Account</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button" id="user-premium" onclick="toggleActive('premium')">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">User Account</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button" id="user-premium" onclick="toggleActive('premium')">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Subscription</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <!-- /tags -->

                        <!-- tagger -->
                        <div class="tag-div">
                            <div class="tag-header">
                                <div>
                                    <p class="text-muted mt-1 f-15 tag-h-content">Request</p>
                                </div>
                                <button type="button" class="f-15 close-tagger">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </button>
                            </div>
                            <div class="tag-body mt-3">
                                <input type="text" rows="1" placeholder="Enter request ID" class="chat-input w-full px-2 py-1">
                                <button class="f-15 py-1 btn btn-primary">Enter</button>
                            </div>
                        </div>
                        <!-- /tagger -->

                        <div class="flex gap-3">
                            <textarea type="text" rows="1" placeholder="Type here..." class="chat-input w-full p-2" autofocus></textarea>
                            <button class="f-20">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>`
        );
        getIssueContent(chatID);
        $('.close-tagger').on('click', function () {
            $('.tag-div').toggleClass('show');
        });
    });

    $(document).on('click', '.close-chat', function () {
        $('.chat-area').html(defaultContent);
    });

    $(document).on('click', '.btn-new-chat', function (event) {
        event.stopPropagation();
        $('.new-chat-container').toggleClass('show');

        fetch('/get-users', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = '/authenticate';
                throw new Error('Unauthenticated');
            }
            return response.json();
        })
        .then(data => {    
            let users = '';        
            data.forEach(user => {
                users +=
                    `<button data-user="${user.uuid}" class="flex items-center justify-between gap-2 p-0 m-0 py-2 ctm-button px-3 w-full" style="border-left: none; border-top: none; border-right: none">
                        <div>
                            <div class="flex justify-between items-center">
                                <p class="f-15 text-semibold text-left">${user.names && user.names.length > 25 ? user.names.substring(0, 25) + '...' : user.names || ''}</p>
                            </div>
                            <div class="text-muted text-left f-13">
                                ${user.role}
                            </div>
                        </div>
                        <span class="${user.status === 'Online' ? 'success' : 'secondary'}-badge f-10">${user.status}</span>
                    </button>`;
            });
            $('.new-chat-container').html(users);
        })
        .catch(error => {
            $('.new-chat-container').toggleClass('error');
            $('.new-chat-container').html('<p class="text-muted">Something went wrong, try again later!</p>');
            console.error("Error:", error);
        });
    });

    $(document).on('click', function (event) {
        if (!$(event.target).closest('.new-chat-container').length && !$(event.target).is('.btn-new-chat')) {
            $('.new-chat-container').removeClass('show');
        }
    });

    // Chats
    document.querySelector('.chat-input')?.addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            let message = e.target.value.trim();
            if (message === '') return;

            e.target.value = '';
            
            const messagesContainer = document.querySelector('.chat-messages');
            
            const messageContainer = document.createElement('div');
            messageContainer.classList.add('flex', 'justify-end', 'mb-3');

            const newMessage = document.createElement('div');
            newMessage.classList.add('p-3', 'col-md-9', 'out-bg', 'rounded');
            newMessage.textContent = message;

            messageContainer.appendChild(newMessage);
            messagesContainer.appendChild(messageContainer);

            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    });

});


