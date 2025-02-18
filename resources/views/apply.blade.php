@section('title', 'Request Service')

<x-apply-layout>

    <div class="client-body w-full h-middle py-5">

        <div class="mb-4 px-5 border-b py-3" style="">
            <div class="flex-section gap-5 align-items-center">
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-arrow-left"></i> &nbsp; Back
                </a>
                <div>
                    <h2 style="font-size: 1.6em" class="mb-2 s-font muted-text mt-4">
                        {{ $discipline_info->discipline_name }}
                    </h2>
                    <p class="text-muted" style="font-size: 1.2em">{{ $discipline_info->country }}</p>
                </div>
            </div>
        </div>

        <div class="flex-section justify-content-center mt-5">
            <div style="background: none; border-radius: 8px" class="overflow-hidden w-full mb-5 mpx">
                <form method="POST" action="{{ route('user-request-application') }}" enctype="multipart/form-data">
                    <div class="">
                        <div class="px-4 pt-1">
                            @csrf

                            <div class="col-lg-4 mt-3">
                                @if($discipline_info)
                                    <input id="application_info" class="block mt-1 w-full" type="hidden"
                                        name="application_info" value="{{ $discipline_info->id }}"
                                        style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
                                        autocomplete="application_info" />
                                    <input id="application_info" class="block mt-1 w-full" type="hidden" name="identifier"
                                        value="{{ $discipline_info->identifier }}"
                                        style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
                                        autocomplete="application_info" />
                                    <x-input-error :messages="$errors->get('application_info')" class="mt-2" />
                                @endif
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="names" :value="__('Names')" />
                                <input
                                    style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                    id="names" class="block mt-1 w-full input-holder" type="text" name="names"
                                    value="{{ old('names', auth('client')->user() ? auth('client')->user()->names : '') }}" placeholder="Full name" required autofocus
                                    autocomplete="names" />
                                <x-input-error :messages="$errors->get('names')" class="mt-2" />
                            </div>

                            <!-- Email Address -->
                            <div class=" mt-3">
                                <x-input-label for="email" :value="__('Email')" />
                                <div class="d-flex gap-3">
                                    <input
                                        style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                        id="email" class="block mt-1 w-full" type="email" name="email"
                                        value="{{ old('email', auth('client')->user() ? auth('client')->user()->email : '') }}" placeholder="username@example.com"
                                        autocomplete="email" />

                                    <!-- @if($errors->has('email'))

<div class="col-lg-3 d-flex align-items-center">
    <a style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 11px; padding: 8px 8px; diplay: block" class="apply-btn w-full text-center" href="{{ route('login', ['email' => old('email'), 'discipline_id' => $application_info -> id, 'discipline_identifier' => $application_info -> identifier]) }}" style="border: none"> Signin instead</a>
</div>

@endif -->

                                </div>

                                <x-input-error :messages="$errors->get('email')" class="mt-2 text-left text-danger"
                                    style="color: #000; font-weight: bold" />

                            </div>

                            <div class="mt-3">
                                <x-input-label for="phone_number" :value="__('Phone number')" />
                                <input
                                    style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                    id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"
                                    value="{{ old('phone_number', auth('client')->user() ? auth('client')->user()->phone_number: '') }}" placeholder="Your phone number" required
                                    autocomplete="phone_number" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <div class="mt-5 d-flex justify-content-center">
                                {!! NoCaptcha::display() !!}
                            </div>

                            <div class="mt-3 mb-4">
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>

                            <div class="flex-section mt-4 space-y-5"
                                style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 20px;">
                                <a href="{{ route('link.payment', ['app' => $discipline_info->identifier, 'r_type' => 'link']) }}"
                                    class="underline text-center"
                                    style="padding: 10px 15px; background-color: #f4f4f4; border-radius: 6px;">
                                    Get application link
                                </a>

                                <button class="apply-btn button-section-btn text-center"
                                    style="padding: 10px 15px; background-color: #007bff; color: white; border-radius: 6px; border: none;">
                                    {{ __('Request service') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div style="background: none; border-left: 1px solid #ddd" class="mpx overflow-hidden w-full">
                <form method="POST" action="{{ route('appointment.book') }}" enctype="multipart/form-data">
                    <div class="">
                        <div class="px-4 pt-1">
                            <h1 style="font-size: 1.8em">Personalized Education Consultation at Your Home</h1>
                            <p class="mt-4 muted-text">We bring expert educational guidance directly to you, providing
                                tailored solutions for
                                your unique needs in the comfort of your home.</p>
                            @csrf
                            <div class="col-lg-4 mt-5">
                                @if($discipline_info)
                                    <input id="application_info" class="block mt-1 w-full" type="hidden"
                                        name="application_info" value="{{ $discipline_info->id }}"
                                        style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
                                        autocomplete="application_info" />
                                    <input id="application_info" class="block mt-1 w-full" type="hidden" name="identifier"
                                        value="{{ $discipline_info->identifier }}"
                                        style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
                                        autocomplete="application_info" />
                                    <x-input-error :messages="$errors->get('application_info')" class="mt-2" />
                                @endif
                            </div>

                            <!-- Name -->
                            <div>
                                <x-input-label for="names" :value="__('Names')" />
                                <input
                                    style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                    id="names" class="block mt-1 w-full input-holder" type="text" name="names"
                                    value="{{ old('names', auth('client')->user() ? auth('client')->user()->names : '') }}" placeholder="Full name" required autofocus
                                    autocomplete="names" />
                                <x-input-error :messages="$errors->get('names')" class="mt-2" />
                            </div>

                            <div class="flex-section gap-3">
                                <!-- Email Address -->
                                <div class=" mt-3 w-full">
                                    <x-input-label for="email" :value="__('Email')" />
                                    <div class="d-flex gap-3">
                                        <input
                                            style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                            id="email" class="block mt-1 w-full" type="email" name="email"
                                            value="{{ old('email',auth('client')->user() ? auth('client')->user()->email : '') }}" placeholder="username@example.com"
                                            autocomplete="email" />

                                        <!-- @if($errors->has('email'))

<div class="col-lg-3 d-flex align-items-center">
    <a style="text-transform: uppercase; color: ghostwhite; font-weight: 600; font-size: 11px; padding: 8px 8px; diplay: block" class="apply-btn w-full text-center" href="{{ route('login', ['email' => old('email'), 'discipline_id' => $application_info -> id, 'discipline_identifier' => $application_info -> identifier]) }}" style="border: none"> Signin instead</a>
</div>

@endif -->

                                    </div>

                                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-left text-danger"
                                        style="color: #000; font-weight: bold" />

                                </div>

                                <div class="mt-3 w-full">
                                    <x-input-label for="phone_number" :value="__('Phone number')" />
                                    <input
                                        style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                        id="phone_number" class="block mt-1 w-full" type="text" name="phone_number"
                                        value="{{ old('phone_number', auth('client')->user() ? auth('client')->user()->phone_number : '') }}" placeholder="Your phone number" required
                                        autocomplete="phone_number" />
                                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex-section gap-3">
                                <!-- Email Address -->
                                <div class=" mt-3 w-full">
                                    <x-input-label for="time" :value="__('Time')" />
                                    <div class="d-flex gap-3">
                                        <input
                                            style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                            id="time" class="block mt-1 w-full" type="datetime-local" name="time"
                                            value="{{ old('time') }}" autocomplete="time" />
                                    </div>

                                    <x-input-error :messages="$errors->get('time')" class="mt-2 text-left text-danger"
                                        style="color: #000; font-weight: bold" />

                                </div>

                                <div class="mt-3 w-full">
                                    <x-input-label for="address" :value="__('Address')" />
                                    <input
                                        style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #000; border-radius: 6px"
                                        id="address" class="block mt-1 w-full" type="text" name="address"
                                        value="{{ old('address') }}" placeholder="Enter your address" required
                                        autocomplete="address" />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-5 d-flex justify-content-center">
                                {!! NoCaptcha::display() !!}
                            </div>

                            <div class="mt-3 mb-4">
                                @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>

                            <div class="flex-section mt-4 space-y-5"
                                style="display: flex; flex-direction: column; gap: 20px; margin-bottom: 20px;">

                                <button class="apply-btn button-section-btn text-center"
                                    style="padding: 10px 15px; background-color: #007bff; color: white; border-radius: 6px; border: none;">
                                    {{ __('Book Appointment') }}
                                </button>
                            </div>


                        </div>

                    </div>


                </form>

            </div>

        </div>

    </div>

</x-apply-layout>