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

    function getIssueContent(chatID, issue) {

        function fetchChatTags() {
            fetch(`/tags/${chatID}`, {
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
                let tags = '';

                if (data.app) {
                    tags += `<a href="${data.app}" class="btns muted-btn underline p-0 f-15">Service</a>`;
                }
                if (data.request) {
                    tags += `<a href="${data.request}" class="btns muted-btn underline p-0 f-15">Request</a>`;
                }
                if (data.account) {
                    tags += `<a href="${data.account}" class="btns muted-btn underline p-0 f-15">Account</a>`;
                }
                if (data.user) {
                    tags += `<a href="${data.user}" class="btns muted-btn underline p-0 f-15">User Account</a>`;
                }
                if (data.advert) {
                    tags += `<a href="${data.advert}" class="btns muted-btn underline p-0 f-15">Advert</a>`;
                }
                if (data.subscriber_id) {
                    tags += `<a href="${data.subscriber_id}" class="btns muted-btn underline p-0 f-15">Subscriber</a>`;
                }
                if (data.sub_plan_id) {
                    tags += `<a href="${data.sub_plan_id}" class="btns muted-btn underline p-0 f-15">Subscription Plan</a>`;
                }
                if (data.sub_service_id) {
                    tags += `<a href="${data.sub_service_id}" class="btns muted-btn underline p-0 f-15">Subscription Service</a>`;
                }
                document.querySelector('.tags').innerHTML = tags;
            })
            .catch(error => console.error("Error:", error));
        }

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

            contentDiv.innerHTML = `
                    <div class="px-3 py-2 mb-3" style="position: sticky; top: 0px; background-color: #f0f0f049;">
                        <p class="f-15 mb-1">${issue}</p>
                        <div class="tags mt-2"></div>
                    </div>`;

            let issueContent = '';
            fetchChatTags();
        
            data.content.forEach(conv => {
                issueContent += 
                `<div class="px-4">
                    <div class="flex ${conv.user_id === data.user ? 'justify-end' : 'justify-start'} mb-3">
                        <div class="p-3 col-md-9 ${conv.user_id === data.user ? 'out-bg' : 'in-bg'} rounded">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="f-15 muted-text" style="font-weight: 600">${conv.user.names}</p>
                                    <p class="text-muted mb-2 f-13">${conv.user.role}</p>
                                </div>
                                <p class="f-13 text-muted text-right">${timeAgo(conv.created_at)}</p>
                            </div>
                            <p class="muted-text f-15">${conv.reply}</p>
                        </div>
                    </div>
                </div>`;
            });
            contentDiv.innerHTML += issueContent;
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
        $('.chat-btn').not(this).removeClass('active-chat');
        $(this).addClass('active-chat');

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
                </div>
                
                <div class="chat-messages overflow-y-auto" style="flex-grow: 1;">
                </div>

                <div class="chat-input-container">
                
                <!-- tagger -->
                        <div class="tag-div">
                            <div class="tag-header">
                                <div>
                                    <p class="text-muted mt-1 f-15 tag-h-content" style="font-weight: 600"></p>
                                </div>
                                <button type="button" class="f-15 close-tagger">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </button>
                            </div>
                            <div class="tag-body mt-3">
                                <input type="text" rows="1" placeholder="" class="w-full px-2 py-1 tag-input">
                                <button class="f-15 py-1 btn enter-tag-btn">Enter</button>
                            </div>
                        </div>
                        <!-- /tagger -->

                    <div class="">
                    <form action="" method="post" style="background-color: #f0f0f0;" class="p-3">

                        <!-- tags -->
                        <div class="flex gap-2 items-center">
                        <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="Service" data-field="app" data-value="">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Service</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="Request" data-field="request" data-value="">
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
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="Account" data-field="account" data-value="">
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
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="User Account" data-field="user" data-value="">
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
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="Advert" data-field="advert" data-value="">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Advert</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="Subscriber" data-field="subscriber_id" data-value="">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Subscriber</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="Subscription Plan" data-field="sub_plan_id" data-value="">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Subscription Plan</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                            <button type="button" class="px-3 py-1 rounded mb-2 ctm-button tag-btn" data-text="Subscription Service" data-field="sub_service_id" data-value="">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1 text-left">
                                        <div class="d-flex justify-content-between gap-3 align-items-center">
                                            <div>
                                                <p class="f-12 text-muted">Subscription Service</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        </div>
                        <!-- /tags -->

                        <div class="flex gap-3">
                            <input type="hidden" name="app" id="app">
                            <input type="hidden" name="request" id="request">
                            <input type="hidden" name="account" id="account" >
                            <input type="hidden" name="user" id="user" >
                            <input type="hidden" name="advert" id="advert" >
                            <input type="hidden" name="subscriber_id" id="subscriber_id" >
                            <input type="hidden" name="sub_plan_id" id="sub_plan_id" >
                            <input type="hidden" name="sub_service_id" id="sub_service_id" >
                            <textarea rows="1" placeholder="Type here..." class="chat-input w-full p-2" autofocus></textarea>
                            <button class="f-20">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    </div>
                </div>`
        );
        getIssueContent(chatID, $(this).data('issue'));
        $('.close-tagger').on('click', function () {
            $('.tag-div').toggleClass('show');
        });

        const textarea = document.querySelector('.chat-input');

        // Set initial rows and max rows
        const minRows = 1;
        const maxRows = 4;

        // Listen for input changes in the textarea
        textarea.addEventListener('input', () => {
            // Reset rows to minimum before recalculating
            textarea.rows = minRows;
            
            // Calculate the number of rows based on scrollHeight and lineHeight
            const lineHeight = parseFloat(getComputedStyle(textarea).lineHeight);
            const rows = Math.floor(textarea.scrollHeight / lineHeight);

            // Set rows to be between minRows and maxRows
            textarea.rows = Math.min(rows, maxRows);
        });

        // Listen for Enter key to trigger row adjustment
        textarea.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                if (textarea.rows < maxRows) {
                    textarea.rows++;
                }
            }
        });

        //     // Chats
        // textarea?.addEventListener('keypress', function (e) {
        //     if (e.key === 'Enter') {
        //         e.preventDefault();
                
        //         let message = e.target.value.trim();
        //         if (message === '') return;

        //         e.target.value = '';
                
        //         const messagesContainer = document.querySelector('.chat-messages');
                
        //         const messageContainer = document.createElement('div');
        //         messageContainer.classList.add('flex', 'justify-end', 'mb-3');

        //         const newMessage = document.createElement('div');
        //         newMessage.classList.add('p-3', 'col-md-9', 'out-bg', 'rounded');
        //         newMessage.textContent = message;

        //         messageContainer.appendChild(newMessage);
        //         messagesContainer.appendChild(messageContainer);

        //         messagesContainer.scrollTop = messagesContainer.scrollHeight;
        //     }
        // });
    });

    $(document).on('click', '.tag-btn', function () {
        $('.tag-div').addClass('show');
        $('.tag-h-content').text($(this).data('text'));
        $('.tag-input').attr('placeholder', 'Enter ' + $(this).data('text') + ' ID').focus();
        $('.tag-input').data('id', $(this).data('field'));
    
        const targetFieldValue = $(`#${$(this).data('field')}`).val();
        $('.tag-input').val(targetFieldValue !== '' ? targetFieldValue : '');
    
        if (targetFieldValue === '') {
            $('.enter-tag-btn').text('Enter').removeClass('btn-danger').addClass('btn-primary');
        } else {
            $('.enter-tag-btn').text('Remove').removeClass('btn-primary').addClass('btn-danger');
        }
    });
    
    $('.tag-input').on('keypress', function (e) {
        if (e.key === 'Enter') {
            enterTagId();
        }
    });    
    
    function enterTagId() {        
        let tagId = $('.tag-input');
        if (tagId.val() === '') return;
        $(`#${tagId.data('id')}`).val(tagId.val());
        $(`[data-field="${tagId.data('id')}"]`).addClass('active');
    }

    $(document).on('click', '.enter-tag-btn', enterTagId);

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

});


