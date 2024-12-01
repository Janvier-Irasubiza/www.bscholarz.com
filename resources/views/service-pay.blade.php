@section('title', 'Payment')

<x-apply-layout>

    <div class="client-body padding mt-2 mb-5">

        <div class="flex-section gap-4 align-items-center mt-5 mb-5" style="padding-bottom: 50px !important;">
            <div class="subtotal-section" style="border: none">
                <h1 style="font-size: 1.2em">Your Plan</h1>
                <div class="mt-2 subtotal-info p-3 rounded border" style="">
                    <div class=" d-flex align-items-center justify-content-between">
                        <h5 class="muted-text" style="font-size: 1.5em">{{ $plan->name }} Plan</h5>
                        <h4 class="price muted-text" style="font-size: 1.3em">RF {{ number_format($subscription->amount) }}</h4>
                    </div>
                    <p class="text-muted" style="font-size: 1em">
                        Renews on {{ $subscription->end_date}}
                    </p>

                    <div class="offer-info">
                        <p>{{ $plan->text }}</p>
                    </div>

                </div>

                <!-- Banner -->
                <div class="deal-banner mt-4">
                    <div class="deal-text">
                        <h2>Don't miss out!</h2>
                        <p>Huge discounts + 12 months subscription &nbsp; <a class="text-white"
                                href="{{ route('contact-us') }}">Contact Sales</a></p>
                    </div>
                    <div class="deal-graphic">
                        <span>%</span>
                    </div>
                </div>

            </div>

            <div style="border-left: 1px solid #eee;" class="px-3 overflow-hidden">


                <div class="mt-3">

                    <div class="mt-4 px-3">
                        <h1 style="font-size: 1.5em">Paymeny Info</h1>

                        <!-- Session Status -->
                        <div class="d-flex justify-content-between align-items-center py-3">
                        </div>

                        <div style="border-bottom: 1px solid #f2f2f24b">
                            <x-input-label for="phone" :value="__('Payment modes')" style="font-size: 15px" />
                            <small class="mb-0" style="color: #595959">Select your prefered payment method</small>
                            <div class="flex-section gap-4 mt-2">
                                <div class="w-full mb-3">
                                    <small class="mb-0" style="">Mobile money</small>
                                    <button type="button" id="momobtn" class="col-lg-8 w-full p-1 paybtn" style="">
                                        <div class="d-flex align-items-center gap-3 px-3">
                                            <div class="col-lg-1"><input id="momochk" type="radio" name="payment_method"
                                                    value="momo"></div>
                                            <div class="w-full mt-1 mb-1 d-flex justify-content-center"
                                                style="height: 35px;"><img style="max-height: 100%"
                                                    src="{{ asset('images/payments/momo1-logo.png') }}" alt=""></div>
                                            <div class="w-full mt-1 mb-1 d-flex justify-content-center"
                                                style="height: 33px;"><img style="max-height: 100%"
                                                    src="{{ asset('images/payments/airtel-logo-bg.png') }}" alt="">
                                            </div>
                                        </div>
                                    </button>
                                </div>
                                <div class="w-full mb-3">
                                    <small class="mb-0">Credit card</small>
                                    <button type="button" id="visabtn" class="col-lg-8 w-full p-1 paybtn">
                                        <div class="d-flex align-items-center gap-2 px-3">
                                            <div class="col-lg-1"><input id="visachk" type="radio" name="payment_method"
                                                    value="cc"></div>
                                            <div class="w-full mt-1 mb-1 d-flex justify-content-center"
                                                style="height: 35px;"><img style="max-height: 100%"
                                                    src="{{ asset('images/payments/visa-logo.png') }}" alt=""></div>
                                            <div class="w-full mt-1 mb-1 d-flex justify-content-center"
                                                style="height: 35px;"><img style="max-height: 100%"
                                                    src="{{ asset('images/payments/Mastercard-logo.png') }}" alt="">
                                            </div>
                                        </div>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="px-3">

                    <form method="POST" action="{{ route('subscription.pay') }}" class="phone-form" id="momoPaymentForm">
                        @csrf

                        <div class="mt-3">
                            <x-input-label for="phone" :value="__('Phone number')" style="font-size: 15px" />
                            <small class="mb-0" style="color: #595959">Provide phone number you intend to use for this
                                payment</small>
                            <input id="momochk" type="radio" name="payment_method" value="momo" checked hidden>
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                :value="old('phone')" placeholder="Phone number" required autofocus
                                autocomplete="phone" />
                            <x-input-error :messages="session('phone')" class="mt-2 text-left" id="errorResponse" />
                            <input type="hidden" name="amount" value="{{ $subscription->amount }}" >
                            <input type="hidden" name="subscription" value="{{ $subscription->id }}" >
                        </div>

                        <div class="response"></div>

                        <div class="mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                    name="agree" style="border-radius: 4px; border: 1.5px solid #505050" required>
                                <span class="ml-2 text-sm">By clicking process payment, you agree with our
                                    <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                        href="">
                                        Terms and Conditions
                                    </a>
                                </span>
                            </label>
                        </div>

                        <div class="button-section mt-4 mb-4">
                            <button type="submit" id="submitPayment" class="apply-btn w-full text-center py-2 uppercase"
                                style="border: none; font-weight: 600">
                                {{ __('Proceed With MoMo') }}
                            </button>
                        </div>

                    </form>

                    <form method="POST" action="{{ route('subscription.pay') }}" class="card-form" id="cardPaymentForm">
                        @csrf

                        <div class="mt-3">
                            <input id="momochk" type="radio" name="payment_method" value="cc" checked hidden>
                            <input type="hidden" name="amount" value="{{ $subscription->amount }}" >
                            <input type="hidden" name="subscription" value="{{ $subscription->id }}" >
                        </div>

                        <div class="cc-response"></div>

                        <div class="mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                    name="agree" style="border-radius: 4px; border: 1.5px solid #505050" required>
                                <span class="ml-2 text-sm">By clicking process payment, you agree with our
                                    <a class="underline text-sm hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                        href="">
                                        Terms and Conditions
                                    </a>
                                </span>
                            </label>
                        </div>

                        <div class="button-section mt-4 mb-4">
                            <button type="submit" id="cardPayment" class="apply-btn w-full text-center py-2 uppercase"
                                style="border: none; font-weight: 600">
                                {{ __('Proceed With Card') }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
        <div class="w-full" style="position: fixed; bottom: 0px; left: 0px ">
            @include('layouts.full-footer')
        </div>
    </div>

</x-apply-layout>