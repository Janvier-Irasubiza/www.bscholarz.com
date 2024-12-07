@section('title', 'Support')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <header class="dashboard-header text-left">
                    <h1>Departments</h1>
                    <p>You can, change, create, or delete a department</p>
                </header>
                <a href="{{ route('dpt.new') }}" class="continue-btn px-4 py-2 text-white">New Department</a>
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

            @if(Session::has('error'))

                        <div class="alert alert-danger p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                            style="font-size: 17px" role="alert">
                            <div>
                                {{ Session::get('error') }}
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
                            </button>
                        </div>

                        @php

                            Session::forget('errror');

                        @endphp

            @endif

            <div class="cards-container mt-5">
                @foreach ($departments as $department)
                    <div class="border rounded-lg p-4 mb-3">
                        <div class="d-flex align-items-center  justify-content-between">
                            <div class="gap-2 justify-content-between">
                                <h2 class="muted-text" style="font-size: 1.4em">{{ $department->name }}</h2>
                                <p class="text-muted mt-1" style="font-size: 1em">{{ $department->status }}</p>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <a href="{{ route('dpt.edit', ['dpt' => $department->id]) }}">Edit</a>
                                @if ($department->status == 'active')
                                    <a href="{{ route('dpt.close', ['dpt' => $department->id]) }}"
                                        class="text-danger">De-activate</a>
                                @endif
                                @if ($department->status != 'active')
                                    <a href="{{ route('dpt.open', ['dpt' => $department->id]) }}"
                                        class="text-success">Activate</a>
                                @endif

                                <a href="{{ route('dpt.delete', ['dpt' => $department->id]) }}"
                                    class="text-danger">Delete</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>