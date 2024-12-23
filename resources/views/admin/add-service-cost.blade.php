@section('title', 'New Service Cost')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">
            <div class="d-flex gap-5 align-items-center mb-3">
                <a href="{{ route('admin.services-costs') }}">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <div class="text-left">
                    <h1 style="font-size: 1.6em">New Service Cost</h1>
                    <p class="muted-text">Add new service cost</p>
                </div>
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
                            Session::forget('error');
                        @endphp
            @endif

            <div class="cards-container">
                <div class="border rounded-lg p-4 mb-3">
                    <form action="{{ route('admin.add-new-service-cost') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <label for="name" class="w-full">Service Name</label>
                            <input type="text" name="name" id="" class="w-full" placeholder="Enter service name"
                                required value="{{ old('name') }}">
                            <x-input-error :messages="$errors->get('name')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <label for="cost" class="w-full">Service Cost</label>
                            <input type="number" name="cost" id="" class="w-full" placeholder="Enter service cost"
                                required value="{{ old('cost') }}">
                            <x-input-error :messages="$errors->get('cost')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="cst-primary-btn px-5 py-2 w-full mt-4">Add Service Cost</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
