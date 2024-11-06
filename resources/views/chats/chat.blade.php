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
                <div class="flex items-center gap-1 mt-2 mb-3">
                    <button class="ctm-button px-3 py-1 rounded f-12 text-muted">All</button>
                    <button class="ctm-button px-3 py-1 rounded f-12 text-muted">By me</button>
                    <button class="ctm-button px-3 py-1 rounded f-12 text-muted">To me</button>
                </div>
            </div>

            <!-- new chat -->
            <div class="new-chat-container">
            </div>
            <!-- /new chat -->
            
            <!-- Chat List -->
            <div class="chat-list">
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area flex-1">
            <!-- Chat content area -->
        </div>
    </div>
</x-app-layout>
