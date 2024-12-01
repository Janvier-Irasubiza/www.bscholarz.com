@section('title', 'Subscriptions')

<x-app-layout>

    <x-slot name="header">
        </slot>

        <div style="padding: 0px 20px 32px 20px">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="f-20 f-600">Subscriptions</h1>
                        <p class="text-muted mt-2">Subscribers</p>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        <a style href class="scd-btn btn btn-primary py-1" data-bs-toggle="modal"
                            data-bs-target="#composeMessage">Compose a message</a>
                        <a style href="{{ route('md.subs-plans') }}" class="scd-btn py-1">View Plans</a>
                    </div>
                </div>

                <div class="mt-4 flex-section justify-content-between align-items-center">
                    @include('components.subs-nav')

                    <div class="">
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show p-1" role="alert">
                                <p class="m-0" id="successMessage">{{ Session::get('error') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-gray p-3 subs-radius">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="f-18 f-500"><strong>{{ $category }}</strong> Subscriptions</h1>
                        <div class="flex gap-3 align-items-center">
                            <a href="{{ route('md.subs', ['download' => 'excel', 'plan' => request('plan')]) }}"
                                class="btn btn-primary">Download</a>
                        </div>
                    </div>
                    <table id="example1" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Client</th>
                                <th>Joined on</th>
                                <th>Plan duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscribers as $entry)
                                                        <tr>
                                                            <!-- Subscriber Name, Email, and Phone -->
                                                            <td>
                                                                <div class="ms-3">
                                                                    <p class="mb-1 f-18">{{ $entry['subscriber']->names }}</p>
                                                                    <p class="text-muted mb-0 f-16">{{ $entry['subscriber']->email }}</p>
                                                                    <p class="text-muted mb-0 f-16">{{ $entry['subscriber']->phone }}</p>
                                                                </div>
                                                            </td>

                                                            <!-- Country -->
                                                            <td>
                                                                <p class="fw-normal mb-1 f-18">{{ $entry['subscriber']->created_at }}</p>
                                                            </td>

                                                            <!-- Subscription Duration and Valid Until -->
                                                            <td>
                                                                @php
                                                                    // Calculate months between start and end date
                                                                    $startDate = \Carbon\Carbon::parse($entry['start_date']);
                                                                    $endDate = \Carbon\Carbon::parse($entry['end_date']);
                                                                    $months = $startDate->diffInMonths($endDate);
                                                                @endphp
                                                                <p class="fw-normal mb-1 f-18">{{ $months }} months</p>
                                                                <p class="text-muted mb-0 f-16">Valid until {{ $endDate->format('Y-m-d') }}</p>
                                                            </td>
                                                        </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

        <!-- <compose message> -->
        <div class="modal fade" id="composeMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="p-3 d-flex justify-content-between align-items-center"
                        style="border-bottom: 1px solid #e6e6e6">
                        <div class="text-left">
                            <p class="m-0" style="font-size: 20px;">
                                <strong class="f-20">Compose a message</strong>
                            </p>
                            <p class="text-muted f-13">Communication to subscribers</p>
                        </div>
                        <button class="btn btn-danger" data-bs-dismiss="modal"
                            style="font-weight: 500; font-size: 15px">CLOSE</button>
                    </div>
                    <div class="modal-body text-left">

                        <form id="composeMessageForm" action="/subs/communicate" method="POST">
                            @csrf

                            <x-input-label for="names" style="text-align: left" class="text-left w-full"
                                :value="__('Select recipients')" />
                            <div class="mb-2 mt-0">
                                <div class="flex gap-3 align-items-center">
                                    <!-- Button for Basic Subscribers -->
                                    <button type="button" class="w-full p-2 rounded mb-2 ctm-button" id="user-basic"
                                        onclick="toggleActive('basic')">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="flex-grow-1 text-left">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="f-16 fw-bold">Basic Subscribers</p>
                                                        <p class="text-muted f-15 select-text">Click to select</p>
                                                    </div>
                                                    <div class="text-center" id="check-basic" style="display: none;">
                                                        <i class="fa-solid fa-circle-check f-20 text-success"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>

                                    <!-- Button for Standard Subscribers -->
                                    <button type="button" class="w-full p-2 rounded mb-2 ctm-button" id="user-standard"
                                        onclick="toggleActive('standard')">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="flex-grow-1 text-left">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="f-16 fw-bold">Standard Subscribers</p>
                                                        <p class="text-muted f-15 select-text">Click to select</p>
                                                    </div>
                                                    <div class="text-center" id="check-standard" style="display: none;">
                                                        <i class="fa-solid fa-circle-check f-20 text-success"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>

                                    <!-- Button for Premium Subscribers -->
                                    <button type="button" class="w-full p-2 rounded mb-2 ctm-button" id="user-premium"
                                        onclick="toggleActive('premium')">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="flex-grow-1 text-left">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="f-16 fw-bold">Premium Subscribers</p>
                                                        <p class="text-muted f-15 select-text">Click to select</p>
                                                    </div>
                                                    <div class="text-center" id="check-premium" style="display: none;">
                                                        <i class="fa-solid fa-circle-check f-20 text-success"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                <p id="subscription-error" style="color: red; display: none; font-size: 14px;">Please
                                    select at least one subscriber plan.</p>
                            </div>

                            <input type="hidden" name="selected_plans[]" id="selected-plan-basic" value="Basic"
                                disabled>
                            <input type="hidden" name="selected_plans[]" id="selected-plan-standard" value="Standard"
                                disabled>
                            <input type="hidden" name="selected_plans[]" id="selected-plan-premium" value="Premium"
                                disabled>
                            <div>
                                <x-input-label for="names" style="text-align: left" class="text-left w-full"
                                    :value="__('Subject')" />
                                <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">
                                    Subject the communication</p>
                                <x-text-input id="names" class="block mt-1 w-full" style="border-radius: 4px;"
                                    type="text" name="subject" :value="old('subject')" placeholder="Enter subject"
                                    required autofocus autocomplete="subject" />
                                <x-input-error :messages="$errors->get('names')" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <x-input-label for="names" style="text-align: left" class="text-left w-full"
                                    :value="__('Message')" />
                                <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">
                                    Details for the communication</p>
                                <textarea placeholder="Type message here..." id="desc" name="desc" class="block w-full"
                                    style="border: 2px solid #000; border-top: 0px; border-radius: 6px; border-top-right-radius: 0px; border-top-left-radius: 0px; padding: 6px; font-size: 14px"
                                    required></textarea>
                                <x-input-error :messages="$errors->get('message')" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <input type="checkbox" name="contact_methods[]" id="email" value="email"> Email
                                        &nbsp;
                                        <input type="checkbox" name="contact_methods[]" id="sms" value="sms"> SMS
                                    </div>

                                    <button type="submit" class="cst-primary-btn mt-2"
                                        style="font-weight: 500; font-size: 15px">SEND MESSAGE</button>
                                </div>

                                <p id="contact-method-error" style="color: red; display: none; font-size: 14px;">Please
                                    select at least one contact method (Email or SMS).</p>

                            </div>

                            <div class="" id="successMsgDiv" style="display: none;">
                                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                                    <p class="m-0" id="successMessage"></p>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- </compose message> -->

</x-app-layout>