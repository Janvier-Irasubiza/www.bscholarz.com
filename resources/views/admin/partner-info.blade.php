@section('title', 'Partners')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-10 px-5">
            <div class="d-flex gap-5 align-items-center mb-3">
                <a href="{{ route('admin.parteners') }}">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
                <div class="text-left">
                    <h1 style="font-size: 1.6em">{{ $partner->name }}</h1>
                    <p class="muted-text">Partner Info</p>
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
                    <form action="{{ route('admin.partners.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <label for="name" class="w-full">Name</label>
                            <input type="text" name="partner_id" value="{{ $partner->id }}" hidden>
                            <input type="text" name="name" id="" class="w-full" placeholder="Enter partner name"
                                required value="{{ old('name', $partner->name) }}">
                            <x-input-error :messages="$errors->get('name')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <label for="email" class="w-full">Email</label>
                            <input type="email" name="email" id="" class="w-full" placeholder="Enter partner email"
                                required value="{{ old('email', $partner->email) }}">
                            <x-input-error :messages="$errors->get('email')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <label for="phone" class="w-full">Phone</label>
                            <input type="text" name="phone" id="" class="w-full" placeholder="Enter partner phone"
                                required value="{{ old('phone', $partner->phone) }}">
                            <x-input-error :messages="$errors->get('phone')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <label for="description" class="w-full">Description</label>
                            <textarea type="text" name="description" id="" class="w-full"
                                placeholder="Enter short descriptoin"
                                required>{{ old('description', $partner->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <label for="website" class="w-full">Website</label>
                            <input type="text" name="website" id="" class="w-full" placeholder="Enter partner website"
                                value="{{ old('website', $partner->website) }}">
                            <x-input-error :messages="$errors->get('website')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <div class="d-flex gap-4 align-items-center">
                                <div class="" style="width: 60px; height: 30px">
                                    <img src="{{ asset('profile_pictures/' . $partner->poster) }}" alt="">
                                    &nbsp;
                                </div>
                                <div class="w-full">
                                    <label for="poster" class="w-full">Change Poster</label>
                                    <input type="file" name="poster" id="" class="w-full" value="{{ old('poster') }}">
                                    <input type="text" name="old_poster" value="{{ $partner->poster }}" hidden>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('poster')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="cst-primary-btn px-5 py-2 w-full mt-4">Add Partner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>