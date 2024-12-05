@section('title', 'Appintments')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <header class="dashboard-header text-left">
                    <h1>Service Appoitnments</h1>
                    <p>Home Delivery Requests.</p>
                </header>
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

            <div class="cards-container mt-3">
                @foreach ($appointments as $app)
                    @if(auth('staff')->user()->type == "admin")
                        <a href="{{ route('appointment.info', ['appt' => $app->app_id]) }}">
                            <div class="border rounded-lg p-4 mb-3">
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <p class="mt-1 muted-text" style="font-size: 1.3em">{{ $app->discipline->discipline_name }}
                                    </p>
                                    <p class="text-muted" id="time">
                                        {{ (new DateTime($app->created_at))->format('F j, Y, g:i A') }}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="d-flex gap-3 align-items-center">
                                        <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->names }}</h2> |
                                        <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->email }}</h2> |
                                        <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->phone_number }}</h2>
                                    </div>
                                    <div>
                                        <span
                                            class="badge {{ !is_null($app->transaction_id) ? 'bg-success' : 'bg-danger' }} rounded-pill px-3">
                                            {{ !is_null($app->transaction_id) ? 'Paid' : 'Payment Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3 border p-3 rounded alert alert-success ">
                                    <h1 style="font-size: 1.2em">Appointment Info</h1>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div>
                                            <p class="text-muted">Time</p>
                                            <p class="muted-text">{{ (new DateTime($app->time))->format('F j, Y, g:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-muted">Address</p>
                                            <p class="muted-text">{{ $app->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @else
                        <div>
                            <div class="border rounded-lg p-4 mb-3">
                                <div class="d-flex align-items-center gap-2 justify-content-between">
                                    <p class="mt-1 muted-text" style="font-size: 1.3em">{{ $app->discipline->discipline_name }}
                                    </p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="d-flex gap-3 align-items-center">
                                        <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->names }}</h2> |
                                        <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->email }}</h2> |
                                        <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->phone_number }}</h2>
                                    </div>
                                </div>
                                <div class="mt-3 border p-3 rounded alert alert-success ">
                                    <h1 style="font-size: 1.2em">Appointment Info</h1>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div>
                                            <p class="text-muted">Time</p>
                                            <p class="muted-text">{{ (new DateTime($app->time))->format('F j, Y, g:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-muted">Address</p>
                                            <p class="muted-text">{{ $app->address }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="mt-3 custom-pagination">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>