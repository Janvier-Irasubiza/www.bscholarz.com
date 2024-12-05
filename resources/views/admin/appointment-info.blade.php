@section('title', 'Appintments')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">


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

            <a href="{{ route('admin.appointments') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>

            <div class="cards-container mt-3">
                <form action="{{ route('appointment.update') }}" method="post">
                    @csrf
                    <div href="">
                        <input type="text" name="app_id" value="{{ $app->app_id }}" hidden>
                        <div class="border rounded-lg p-4 mb-3">
                            <div class="d-flex align-items-center gap-2 justify-content-between">
                                <p class="mt-1 muted-text" style="font-size: 1.3em">
                                    {{ $app->discipline->discipline_name }}
                                </p>
                                <p class="text-muted" id="time">{{ $app->created_at }}</p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <div class="d-flex gap-3 align-items-center">
                                    <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->names }}</h2> |
                                    <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->email }}</h2> |
                                    <h2 class="text-muted mt-1" style="font-size: 1.2em">{{ $app->user->phone_number }}
                                    </h2>
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
                                <div class="d-flex justify-content-between mt-2">
                                    <div>
                                        <p class="text-muted">Time</p>
                                        <div class="d-flex gap-3">
                                            <p class="muted-text">
                                                {{ (new DateTime($app->time))->format('F j, Y, g:i A') }}
                                            </p>
                                        </div>
                                        <div class="mt-3 p-2 border rounded">
                                            <label for="time" class="w-full">Change Time</label>
                                            <input type="datetime-local" name="time" id="time"
                                                value="{{ old('time') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-muted">Address</p>
                                        <p class="muted-text">{{ $app->address }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-start align-items-center mt-2">
                                <div class="d-flex gap-4 align-items-center space-x-8 w-full">
                                    <div>
                                        <label class="w-full">Assigned Assistant</label>
                                        <select name="assistant" id="" class="w-full" required>
                                            @if (is_null($app->assistant))
                                                <option value="">-----------------------</option>
                                            @endif
                                            @foreach ($assistants as $ass)
                                                <option value="{{ $ass->id }}" {{ $app->assistant == $ass->id || old('assistant') == $ass->id ? 'checked' : '' }}>{{ $ass->names }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="d-block gap-3 space-x-8" style="display: block">
                                        @if ($app->status == 'Complete')
                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                Completed
                                            </span>
                                            <a href="{{ route('appointment.pending', ['appt' => $app->app_id]) }}"
                                                class="mt-5 underline">
                                                Undo
                                            </a>

                                        @else
                                            <a href="{{ route('appointment.served', ['appt' => $app->app_id]) }}"
                                                class="mt-5">
                                                <i class="fa-solid fa-square-check"></i>
                                                Mark Served
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('appointment.delete', ['appt' => $app->app_id]) }}"
                                        class="underline text-danger">Delete</a>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn continue-btn px-4 py-2 text-white">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>