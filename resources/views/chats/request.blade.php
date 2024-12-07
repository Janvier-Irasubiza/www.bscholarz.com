@section('title', 'Request Support')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white ">
        <div class="dashboard-container col-lg-10 px-5">
            <header class="dashboard-header">
                <div class="d-flex align-items-center gap-2 justify-content-between">
                    <div class="d-flex gap-4 align-items-center">
                        <a href="{{ route('chats.index') }}">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                        <h2 class="muted-text" style="font-size: 1.4em">Start New Chat</h2>
                    </div>
                    <p class="text-muted" id="time-">Now</p>
                </div>
            </header>

            <div class="border rounded-lg p-3">

                <div class="">
                    <form action="{{ route('support.request') }}" method="post">
                        @csrf
                        <label for="issue">What is the issue</label>
                        <input type="text" name="issue" class="w-full" placeholder="Briely, Enter the issue" required
                            autocorrect autofocus autocomplete="issue" value="{{ old('issue') }}" />
                        <x-input-error :messages="$errors->get('issue')" class="mb-3 text-left text-danger" />
                        <div class="gap-3 mt-3 ">
                            <label for="issue_desc">Describe the issue</label>
                            <textarea name="issue_desc" rows="4" placeholder="Describe the issue in details"
                                class="chat-input w-full p-2" required autocorrect
                                autocomplete="issue_desc">{{ old('issue_desc') }}</textarea>
                            <x-input-error :messages="$errors->get('issue_desc')" class="mb-3 text-left text-danger" />
                            <div class="gap-3 align-items-center mt-3">
                                <label for="receiver">Receiver</label>
                                <div class="relative w-full">
                                    <input type="hidden" id="receiver" name="receiver" class="w-full" required
                                        value="{{ old('receiver') }}" />
                                    <button type="button" id="dropdownButton"
                                        class="w-full border bg-white rounded px-4 py-2 text-left"
                                        onclick="toggleDropdown()">
                                        Select a Receiver
                                    </button>

                                    <!-- Dropdown options -->
                                    <div id="dropdown"
                                        class="absolute hidden border bg-white rounded w-full mt-1 overflow-auto"
                                        style="height: 150px">
                                        @foreach ($staff as $user)
                                            <div class="px-4 py-2 cursor-pointer hover:bg-gray-100"
                                                onclick="selectReceiver('{{ addslashes($user->id) }}', '{{ addslashes($user->names) }}', '{{ addslashes($user->role) }}')">
                                                <p class="font-bold">{{ $user->names }}</p>
                                                <p class="text-sm text-gray-500">{{ $user->role }}</p>
                                            </div>
                                        @endforeach

                                    </div>
                                    <x-input-error :messages="$errors->get('receiver')"
                                        class="mb-3 text-left text-danger" />
                                </div>

                                <script>
                                    function toggleDropdown() {
                                        const dropdown = document.getElementById('dropdown');
                                        dropdown.classList.toggle('hidden');
                                    }

                                    let receiver = document.getElementById('receiver');

                                    function selectReceiver(id, name, role) {
                                        receiver.value = id;
                                        const dropdownButton = document.getElementById('dropdownButton');
                                        dropdownButton.innerHTML = `
            <p class="font-bold">${name}</p>
            <p class="text-sm text-gray-500">${role}</p>
        `;
                                        toggleDropdown();
                                    }
                                </script>
                            </div>
                            <button type="submit" class="cst-primary-btn px-5 py-2 w-full mt-4">Start New Chat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Scroll to the bottom of the replies container
        const repliesContainer = document.getElementById('replies-container');
        repliesContainer.scrollTop = repliesContainer.scrollHeight;

        // Optionally, call this after appending new replies dynamically
        function scrollToBottom() {
            repliesContainer.scrollTop = repliesContainer.scrollHeight;
        }
    </script>
</x-app-layout>