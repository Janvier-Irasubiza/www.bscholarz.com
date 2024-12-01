@section('title', $message->issue)

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white h-screen">
        <div class="dashboard-container col-lg-10 px-5">
            <header class="dashboard-header">
                <div class="d-flex align-items-center gap-2 justify-content-between">
                    <div class="d-flex gap-4 align-items-center">
                        <a href="{{ route('chats.index') }}">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                        <h2 class="muted-text" style="font-size: 1.4em">{{ $message->issue }}</h2>
                    </div>
                    <p class="text-muted" id="time-{{ $message->id }}"></p>
                    <script>
                        document.getElementById("time-{{ $message->id }}").innerHTML = new Date('{{ $message->created_at }}').toLocaleTimeString();
                    </script>
                </div>
            </header>

            <div class="border rounded-lg p-3">
                <div class="chat-messages overflow-y-auto" style="flex-grow: 1; margin: 0px" id="replies-container">
                    @foreach ($message->replies as $reply)
                        <div class="px-4">
                            <div
                                class="flex {{ $reply->user_id === auth()->guard('staff')->user()->id ? 'justify-end' : 'justify-start' }} mb-3">
                                <div
                                    class="p-3 col-md-9 {{ $reply->user_id === auth()->guard('staff')->user()->id ? 'out-bg' : 'in-bg' }} rounded">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="f-15 muted-text" style="font-weight: 600">{{ $reply->user->names }}
                                            </p>
                                            <p class="text-muted mb-2 f-13">{{ $reply->user->role }}</p>
                                        </div>
                                        <p class="f-13 text-muted text-right" id="reply-id-{{ $reply->id }}">
                                            <script>
                                                document.getElementById("reply-id-{{ $reply->id }}").innerHTML = new Date('{{ $reply->created_at }}').toLocaleTimeString();
                                            </script>
                                        </p>
                                    </div>
                                    <p class="muted-text f-15">{{ $reply->reply }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="chat-input-container">
                    <form action="{{ route('chat.reply') }}" method="post">
                        @csrf
                        <input type="hidden" name="chat" value="{{ $message->id }}" class="w-full">
                        <div class="flex gap-3 mt-3 ">
                            <textarea name="message" rows="1" placeholder="Type here..." class="chat-input w-full p-2"
                                autofocus></textarea>
                            <button type="submit" class="cst-primary-btn px-4 py-1">Send</button>
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