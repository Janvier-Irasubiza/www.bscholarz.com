@section('title', 'Chats')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex">
        <!-- Sidebar -->
        <div class="chat-sidebar w-1/2 bg-gray-200 overflow-y-auto" style="height: calc(100vh - 5.3rem);">
            <div class="p-3 pb-0">
                <div class="flex justify-between items-center mb-3 border-bottom pb-2">
                    <h3 class="f-20">Chats</h3>
                    <button class="f-20 border px-3 rounded btn-new-chat ctm-button">+</button>
                </div>
                <input type="text" placeholder="Search..." class="search-input p-2 py-1 w-full">
                <div class="flex items-center gap-2 mt-3 mb-3">
                    <button class="ctm-button px-3 rounded f-15 text-muted">All</button>
                    <button class="ctm-button px-3 rounded f-15 text-muted">By me</button>
                    <button class="ctm-button px-3 rounded f-15 text-muted">To me</button>
                </div>
            </div>
            
            <!-- Chat List -->
            @for ($i = 0; $i < 10; $i++)
                <button class="flex gap-2 p-0 m-0 py-2 ctm-button px-3 w-full" style="border-left: none; border-top: none; border-right: none">
                    <div class="user-profile m-0">
                        <img src="{{ asset('images/profile.png') }}" alt="">
                    </div>
                    <div>
                        <div class="mb-1 flex justify-between items-center">
                            <p class="f-18">Names</p>
                            <p class="f-15 text-muted">date</p>
                        </div>
                        <div class="mb-1">
                            <span class="badge badge-success f-15">Apps</span>
                            <span class="badge badge-success f-15">Payment</span>
                            <span class="badge badge-success f-15">Account</span>
                        </div>
                        <div class="text-muted text-left">
                            Message
                        </div>
                    </div>
                </button>
            @endfor
        </div>

        <!-- Chat Area -->
        <div class="chat-area flex-1">
            @php
                // Variable to track if a chat is selected; set it to false by default
                $chatSelected = false;
            @endphp

            @if ($chatSelected)
                <div class="flex justify-center items-center h-full">
                    <p class="text-center f-25 text-muted">Click a chat to open</p>
                </div>
            @else
                <div>
                    <div class="chat-header bg-white p-3 border-b flex justify-between items-center">
                        <div class="flex gap-3">
                            <div class="user-profile m-0">
                                <img src="{{ asset('images/profile.png') }}" alt="">
                            </div>
                            <div>
                                <p class="f-18">Names</p>
                                <p class="text-muted">role</p>
                            </div>
                        </div>
                        <button class="f-25 px-3 btn-new-chat">
                            <i class="fa-regular fa-circle-xmark"></i>
                        </button>
                    </div>

                    <div class="chat-messages p-4 overflow-y-auto" style="flex-grow: 1;">
                        <!-- Messages -->
                        @for ($i = 0; $i <= 3; $i++)
                            <div class="flex justify-start mb-3">
                                <div class="p-3 col-md-9 in-bg rounded">

                                    <div class="flex gap-2 mb-2">
                                        <span class="f-12 text-muted px-2 py-1 ctm-button rounded" style="background: none">Apps</p></span>
                                        <span class="f-12 text-muted ctm-button px-2 py-1 rounded" style="background: none">Payment</p></span>
                                        <span class="f-12 text-muted ctm-button px-2 py-1 rounded" style="background: none">Account</p></span>
                                    </div>

                                    <span class="badge badge-success f-15">Apps</span>

                                    <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
                                </div>
                            </div>
                            <div class="flex justify-end mb-3">
                                <div class="p-3 col-md-9 out-bg rounded">

                                    <div class="flex gap-2 mb-2">
                                        <span class="f-12 text-muted px-2 py-1 ctm-button rounded" style="background: none">Apps</p></span>
                                        <span class="f-12 text-muted ctm-button px-2 py-1 rounded" style="background: none">Payment</p></span>
                                        <span class="f-12 text-muted ctm-button px-2 py-1 rounded" style="background: none">Account</p></span>
                                    </div>

                                    <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.</p>
                                </div>
                            </div>
                        @endfor
                    </div>

                    <div class="chat-input-container border-t">
                        <form action="" method="post">
                            <div class="flex gap-2 items-center">
                                <button type="button" class="px-3 py-1 rounded mb-2 ctm-button" id="user-premium" onclick="toggleActive('premium')">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="flex-grow-1 text-left">
                                            <div class="d-flex justify-content-between gap-3 align-items-center">
                                                <div>
                                                    <p class="f-12 text-muted">Apps</p>
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
                                                    <p class="f-12 text-muted">Payment</p>
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
                            </div>
                            <div class="flex gap-3">
                                <textarea type="text" rows="1" placeholder="Type here..." class="chat-input w-full p-2"></textarea>
                                <button class="f-20">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
