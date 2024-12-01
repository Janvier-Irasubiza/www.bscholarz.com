@section('title', 'Support')

<x-dev-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <header class="dashboard-header text-left">
                    <h1>Welcome to the Support Page</h1>
                    <p>Here you'll find all requested support.</p>
                </header>
                <!-- <a href="{{ route('support.new') }}" class="continue-btn px-4 py-2 text-white">Request Support</a> -->
            </div>

            @if(Session::has('success'))

                        <div class="alert alert-success p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                            style="font-size: 17px" role="alert">
                            <div>
                                {{ Session::get('success') }}
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
                            </button>
                        </div>

                        @php

                            Session::forget('success');

                        @endphp

            @endif

            <div class="cards-container mt-5">
                @foreach ($messages as $message)
                    @if ($message->replies->count() > 0)
                        <a href="{{ route('dev.chat', ['chat' => $message->uuid]) }}"
                            style="{{ $message->latestReply && $message->latestReply->status === 'unread' ? 'font-weight: 600;' : '' }}">
                            <div class="border rounded-lg p-4 mb-3">
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <h2 class="muted-text" style="font-size: 1.4em">{{ $message->issue }}</h2>
                                    <p class="text-muted" id="time-{{ $message->latestReply->id }}"></p>
                                    <script>
                                        document.getElementById("time-{{ $message->id }}").innerHTML = new Date('{{ $message->latestReply->created_at }}').toLocaleTimeString();
                                    </script>

                                </div>
                                <p class="text-muted mt-1" style="font-size: 1em">{{ $message->latestReply->reply }}</p>
                            </div>
                        </a>
                    @endif
                @endforeach

                <div class="mt-3 custom-pagination">
                    {{ $messages->links() }}
                </div>

            </div>
        </div>
    </div>
</x-dev-layout>