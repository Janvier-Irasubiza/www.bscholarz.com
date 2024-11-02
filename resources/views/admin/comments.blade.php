@section('title', 'Application info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">
        <div class="container-fluid">
            <div class="card-header-tab card-header py-3 d-flex align-items-center justify-content-between" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    <h1 class="f-25 f-600">{{ $app_info -> discipline_name }}</h1>
                    <p class="text-muted mt-2 f-16">Comments</p>
                </div>
                <a href="{{ auth()->user() ? route('admin.applications') : route('md.apps') }}" class="btn btn-danger" style="font-weight: 500; font-size: 13px">CLOSE</a>
            </div>

            <div class="modal-body text-left mt-3" id="commentsBody">
                <!-- comments -->
            </div>

        </div>
    </div>
</div>

</x-app-layout>