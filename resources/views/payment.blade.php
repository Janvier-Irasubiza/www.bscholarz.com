@section('title', 'Payment')

<x-apply-layout>

  <div class="client-body padding mt-2 sm-section mb-5">

    <!-- <div style="font-size: 25px;" class="widget-subheading text-center mt-3">Payment</div> -->

    <div style="border-radius: 8px" class="px-3 mt-4 overflow-hidden">

      <!-- Session Status -->
      <div class="d-flex justify-content-between align-items-center mb-4 py-3"
        style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">

        <div>
          <div style="font-size: 24px" class="widget-subheading">{{ $service->discipline_name }} </div>
          <small class="mb-0" style="font-size: 15px">{{ $service->organization }} - {{ $service->country }}</small>
        </div>

      </div>

      <div class="mt-3">

        <div class="mb-3">
          <h1 style="" class="f-20">Request fee: <strong>{{ number_format($amount) }} RWF</strong> </h1>
        </div>

        <span style="font-size: 15px">
          Dear <span style="font-weight: 600">{{ $client }},</span> you're requesting for <span
            style="font-weight: 600">{{ $service->discipline_name }} in
            {{ $service->discipline_organization }}</span> application
        </span>

        <div class="mt-4 px-3">
          <div style="border-bottom: 1px solid #f2f2f24b">
            <x-input-label for="phone" :value="__('Payment modes')" style="font-size: 15px" />
            <small class="mb-0" style="color: #595959">Select your prefered payment method</small>
            <div class="flex-section gap-4 mt-2">
              <div class="w-full mb-3">
                <small class="mb-0" style="">Mobile money</small>
                <button type="button" id="momobtn" class="col-lg-8 w-full p-1 paybtn" style="">
                  <div class="d-flex align-items-center gap-3 px-3">
                    <div class="col-lg-1"><input id="momochk" type="radio" name="payment_method" value="momo"></div>
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 35px;"><img
                        style="max-height: 100%" src="{{ asset('images/payments/momo1-logo.png') }}" alt=""></div>
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 33px;"><img
                        style="max-height: 100%" src="{{ asset('images/payments/airtel-logo-bg.png') }}" alt=""></div>
                  </div>
                </button>
              </div>
              <div class="w-full mb-3">
                <small class="mb-0">Credit card</small>
                <button type="button" id="visabtn" class="col-lg-8 w-full p-1 paybtn">
                  <div class="d-flex align-items-center gap-2 px-3">
                    <div class="col-lg-1"><input id="visachk" type="radio" name="payment_method" value="cc"></div>
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 35px;"><img
                        style="max-height: 100%" src="{{ asset('images/payments/visa-logo.png') }}" alt=""></div>
                    <div class="w-full mt-1 mb-1 d-flex justify-content-center" style="height: 35px;"><img
                        style="max-height: 100%" src="{{ asset('images/payments/Mastercard-logo.png') }}" alt=""></div>
                  </div>
                </button>
              </div>

            </div>
          </div>
        </div>

      </div>

      <div class="px-3">

        <form method="POST" action="{{ route('request.pay') }}" class="phone-form" id="momoPaymentForm">
          @csrf

          <div class="mt-3">
            <x-input-label for="phone" :value="__('Phone number')" style="font-size: 15px" />
            <small class="mb-0" style="color: #595959">Provide phone number you intend to use for this payment</small>
            <input id="app_id" class="block mt-1 w-full" type="hidden" name="app_id" value="{{ $application }}"
              autocomplete="app_id" />
            <input id="identifier" class="block mt-1 w-full" type="hidden" name="identifier"
              value="{{ $service->identifier }}" autocomplete="identifier" />
            <input id="applicant" class="block mt-1 w-full" type="hidden" name="applicant"
              value="{{ $client_id->applicant }}" autocomplete="applicant" />
            <input id="amount" class="block mt-1 w-full" type="hidden" name="amount" value="{{ $amount }}"
              autocomplete="amount" />
            <input id="momochk" type="radio" name="payment_method" value="momo" checked hidden>
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $client_phone)" placeholder="Phone number" required autofocus autocomplete="phone" />
            <x-input-error :messages="session('phone')" class="mt-2 text-left" id="errorResponse" />
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
          <button type="submit" id="submitPayment" class="apply-btn w-full text-center py-2 uppercase" style="border: none; font-weight: 600">
              {{ __('Proceed With MoMo') }}
            </button>
          </div>

        </form>

        <form method="POST" action="{{ route('request.pay') }}" class="card-form" id="cardPaymentForm">
          @csrf

          <div class="mt-3">
          <input id="app_id" class="block mt-1 w-full" type="hidden" name="app_id" value="{{ $application }}"
              autocomplete="app_id" />
            <input id="identifier" class="block mt-1 w-full" type="hidden" name="identifier"
              value="{{ $service->identifier }}" autocomplete="identifier" />
            <input id="applicant" class="block mt-1 w-full" type="hidden" name="applicant"
              value="{{ $client_id->applicant }}" autocomplete="applicant" />
            <input id="amount" class="block mt-1 w-full" type="hidden" name="amount" value="{{ $amount }}"
              autocomplete="amount" />
            <input id="momochk" type="radio" name="payment_method" value="cc" checked hidden>
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="$client_phone"
              placeholder="Phone number" required autofocus autocomplete="phone" hidden />
            <x-input-error :messages="session('phone')" class="mt-2 text-left" />
          </div>

          <!-- <h3 class="f-20 muted-text">Card Info</h3>
          <div class="flex-section gap-3 mt-2">
            <div class="w-full">
              <x-text-input id="names_on_card" class="block mt-1 w-full p-2 f-17" type="text" name="names_on_card" :value="old('names_on_card')" placeholder="Names on card" required autofocus autocomplete="names_on_card" />
              <x-input-error :messages="$errors->get('names_on_card')" class="mt-2 text-left" />
            </div>
            <div class="w-full">
              <x-text-input id="card_number" class="block mt-1 w-full  p-2 f-17" type="text" name="card_number" :value="old('card_number')" placeholder="0000 0000 0000 0000" required autocomplete="card_number" />
              <x-input-error :messages="$errors->get('card_number')" class="mt-2 text-left" />
            </div>
          </div>

          <div class="flex-section gap-3 mt-3">
            <div class="w-full">
              <x-text-input id="expiry_date" class="block mt-1 w-full p-2 f-17" type="text" name="expiry_date" :value="old('expiry_date')" placeholder="MM / YY" required autocomplete="expiry_date" />
              <x-input-error :messages="$errors->get('expiry_date')" class="mt-2 text-left" />
            </div>
            <div class="w-full">
              <x-text-input id="cvc" class="block mt-1 w-full p-2 f-17" type="text" name="cvc" :value="old('cvc')" placeholder="CVC" required autocomplete="cvc" />
              <x-input-error :messages="$errors->get('cvc')" class="mt-2 text-left" />
            </div>
          </div> -->

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
            <button type="submit" id="cardPayment" class="apply-btn w-full text-center py-2 uppercase" style="border: none; font-weight: 600">
              {{ __('Proceed With Card') }}
            </button>
          </div>

        </form>

      </div>
    </div>

    <div style="" class="mt-5 w-full">
      @include('layouts.full-footer')
    </div>

  </div>

</x-apply-layout>