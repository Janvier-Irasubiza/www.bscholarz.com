@section('title', 'Application info')

<x-staff-layout>

    <x-slot name="header">
        </slot>

        <div style="padding: 20px 32px;">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">

                <div class="container-fluid">
                    <div class="card-header-tab card-header py-3 d-flex"
                        style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-12">
                            <strong>Activity Details</strong>
                        </div>
                    </div>

                    @if(Session::has('email_error'))


                                        <form method="POST" action="{{ route('add-client-app') }}" class="mt-6 space-y-6 mt-4 mb-3">
                                            @csrf

                                            <div class="alert alert-secondary mb-3" role="alert">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small> Is it another application for
                                                        <strong>{{ Session::get('email_error') }}</strong>? If no, use different email
                                                        address. </small>

                                                    <input type="text" name="applicant_id" value="{{  Session::get('applicant') }}" hidden>

                                                    <button class="apply-btn" style="color: ghostwhite; font-size: 14px">Yes it's another
                                                        application</button>

                                                </div>
                                            </div>

                                            @php 

                                                                                                                                            Session::forget('email_error');
                                                Session::forget('applicant'); 

                                            @endphp

                    @else

                        <form method="POST" action="{{ route('record-new-activity') }}"
                            class="mt-6 space-y-6 mt-4 mb-3">
                            @csrf

                    @endif

                            <div>
                                <x-input-label for="paymentStatus" :value="__('Activity Name')" />
                                <select id="activityName" name="activityName" type="text" class="mt-1 block w-full"
                                    required autocomplete="activityName" value="{{ old('activityName') }}"
                                    style="border: 2px solid; border-radius: 7px; padding: 5px 8px; font-size: 14px">
                                    <option value="" selected>Select activity</option>


                                    @if(old('customActivityName'))

                                        <option value="custom" selected>Custom</option>

                                    @else

                                        <option value="custom">Custom</option>

                                    @endif

                                    @foreach($disciplines as $discipline)

                                        @if(old('activityName') == $discipline->id)

                                            <option value="{{ $discipline->id }}" selected>
                                                {{ $discipline->discipline_name }}
                                            </option>

                                        @else

                                            <option value="{{ $discipline->id }}">{{ $discipline->discipline_name }}
                                            </option>

                                        @endif

                                    @endforeach


                                </select>

                                @if(old('customActivityName'))
                                    <x-text-input style="display: block" id="txt-custom" name="customActivityName"
                                        type="text" class="mt-1 block w-full" value="{{ old('customActivityName') }}"
                                        autocomplete="customActivityName" placeholder="Enter activity name" />
                                @else
                                    <x-text-input id="txt-custom" name="customActivityName" type="text"
                                        class="mt-1 block w-full" value="{{ old('customActivityName') }}"
                                        autocomplete="customActivityName" placeholder="Enter activity name" />
                                @endif

                                <x-input-error class="mt-2" :messages="$errors->get('activityName')" />
                                <x-input-error class="mt-2" :messages="$errors->get('customActivityName')" />
                            </div>

                            <div>
                                <x-input-label for="consumerNames" :value="__('Consumer Names')" />
                                <x-text-input id="consumerNames" name="consumerNames" type="text"
                                    class="mt-1 block w-full" value="{{ old('consumerNames') }}" required
                                    autocomplete="consumerNames" placeholder="Enter consumer names" />
                                <x-input-error class="mt-2" :messages="$errors->get('consumerNames')" />
                            </div>

                            <div>
                                <x-input-label for="consumerEmail" :value="__('Consumer Email')" />
                                <x-text-input id="consumerEmail" name="consumerEmail" type="text"
                                    class="mt-1 block w-full" value="{{ old('consumerEmail') }}" required
                                    autocomplete="consumerEmail" placeholder="Enter consumer email" />
                                <x-input-error class="mt-2" :messages="$errors->get('consumerEmail')" />
                            </div>

                            <div>
                                <x-input-label for="consumerPhoneNumber" :value="__('Consumer Phone number')" />
                                <x-text-input id="consumerPhoneNumber" name="consumerPhoneNumber" type="text"
                                    class="mt-1 block w-full" value="{{ old('consumerPhoneNumber') }}" required
                                    autocomplete="consumerPhoneNumber" placeholder="Enter consumer phone number" />
                                <x-input-error class="mt-2" :messages="$errors->get('consumerPhoneNumber')" />
                            </div>

                            <div>
                                <x-input-label for="serviceCost" :value="__('Service Cost')" />
                                <x-text-input id="serviceCost" name="serviceCost" type="text" class="mt-1 block w-full"
                                    value="{{ old('serviceCost') }}" autocomplete="serviceCost"
                                    placeholder="Enter service cost" />
                                <x-input-error class="mt-2" :messages="$errors->get('serviceCost')" />
                            </div>

                            <div>
                                <x-input-label for="paymentStatus" :value="__('Payment Status')" />
                                <select id="paymentStatus" name="paymentStatus" type="text" class="mt-1 block w-full"
                                    value="{{ old('paymentStatus') }}" required autocomplete="paymentStatus"
                                    style="border: 2px solid; border-radius: 7px; padding: 5px 8px; font-size: 14px">
                                    <option>Select payment status</option>

                                    @if(old('paymentStatus') == 'Paid')

                                        <option value="Paid" selected>Paid</option>
                                        <option value="Not paid">Not Paid</option>
                                        <option value="Partial-payment">Partial Payment</option>

                                    @elseif(old('paymentStatus') == 'Not paid')

                                        <option value="Paid">Paid</option>
                                        <option value="Not paid" selected>Not Paid</option>
                                        <option value="Partial-payment">Partial Payment</option>


                                    @elseif(old('paymentStatus') == 'Partial-payment')

                                        <option value="Paid">Paid</option>
                                        <option value="Not paid">Not Paid</option>
                                        <option value="Partial-payment" selected>Partial Payment</option>

                                    @else

                                        <option value="Paid">Paid</option>
                                        <option value="Not paid">Not Paid</option>
                                        <option value="Partial-payment">Partial Payment</option>

                                    @endif
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('paymentStatus')" />
                            </div>

                            @if(old('receivedAmount'))

                                <div id="amountPaid" style="display: block">
                                    <x-input-label for="receivedAmount" :value="__('Amount Paid')" />
                                    <x-text-input id="receivedAmount" name="receivedAmount" type="text"
                                        class="mt-1 block w-full" value="{{ old('receivedAmount') }}"
                                        autocomplete="receivedAmount" placeholder="What amount have you received?" />
                                    <x-input-error class="mt-2" :messages="$errors->get('receivedAmount')" />
                                </div>

                            @else

                                <div id="amountPaid">
                                    <x-input-label for="receivedAmount" :value="__('Amount Paid')" />
                                    <x-text-input id="receivedAmount" name="receivedAmount" type="text"
                                        class="mt-1 block w-full" value="{{ old('receivedAmount') }}"
                                        autocomplete="receivedAmount" placeholder="What amount have you received?" />
                                    <x-input-error class="mt-2" :messages="$errors->get('receivedAmount')" />
                                </div>

                            @endif

                            <div>
                                <x-input-label for="desc" :value="__('Description')" />
                                <small class="text-muted mb-0">Detailed description of activity process</small>
                                <textarea id="desc" name="desc" class="mt-1 block w-full"
                                    style="border: 2px solid #000; border-radius: 6px" required autocomplete="desc"
                                    placeholder="Enter detailed description of the activity"> {{ old('desc') }} </textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('desc')" />
                            </div>

                            <div class="d-flex align-items-center justify-content-center pt-3">
                                <x-primary-button class="apply-btn px-5" style="border: none">
                                    {{ __('Record activity') }}
                                </x-primary-button>
                            </div>

                        </form>
                </div>


            </div>
        </div>

        <script>

            let selectEl = document.getElementById('activityName');

            selectEl.addEventListener('change', (e) => {
                if (e.target.value == 'custom') {
                    document.getElementById('txt-custom').style.display = 'block';
                    document.getElementById('customActivityCost').style.display = 'block';
                    document.getElementById("txt-custom").setAttribute('required', '');
                    document.getElementById("customActivityCost").setAttribute('required', '');
                } else {
                    document.getElementById('txt-custom').style.display = 'none';
                }
            });


            let selectElement = document.getElementById('paymentStatus');

            selectElement.addEventListener('change', (e) => {
                if (e.target.value == 'Partial-payment') {
                    document.getElementById('amountPaid').style.display = 'block';
                    document.getElementById("amountPaid").setAttribute('required', '');
                } else {
                    document.getElementById('amountPaid').style.display = 'none';
                }
            });

        </script>

        </x-app-layout>