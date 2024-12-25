@section('title', 'Appintments')

<x-staff-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <header class="dashboard-header text-left">
                    <h1>Recommended Comments</h1>
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
                <div class="modal-body text-left mt-3" id="commentsBody">
                    <!-- comments -->
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>