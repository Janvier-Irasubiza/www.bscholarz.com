@section('title', 'Payment')

<x-apply-layout>

  <div class="client-body padding mt-2 sm-section mb-5">

    <div style="font-size: 25px;" class="widget-subheading text-center mt-3">Payment</div>

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

        <div class="alert alert-success mt-3" role="alert">
          <h1 style="" class="f-20">Request fee: <strong>{{ number_format($amount) }} RWF</strong> </h1>
          <p class="mt-2">
            Get an application link to apply for this service by yourself
          </p>
        </div>

      </div>

      <div class="px-3">

        <form method="POST">
          @csrf
          <!-- Customer name field - added based on script validation -->
          <div class="mt-3">
            <x-input-label for="name" :value="__('Full Name')" style="font-size: 15px" />
            <small class="mb-0" style="color: #595959">Enter your full name</small>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
              placeholder="Full Name" required autofocus autocomplete="name" />
            <x-input-error :messages="session('name')" class="mt-2 text-left" />
          </div>
          
          <div class="mt-3">
            <x-input-label for="phone" :value="__('Phone number')" style="font-size: 15px" />
            <small class="mb-0" style="color: #595959">Provide phone number you intend to use for this payment</small>
            <input id="service" class="block mt-1 w-full" type="hidden" name="identifier"
              value="{{ $service->identifier }}" autocomplete="identifier" />
            <input id="amount" class="block mt-1 w-full" type="hidden" name="amount" value="{{ $amount }}"
              autocomplete="amount" />
            <input id="serviceId" class="block mt-1 w-full" type="hidden" name="serviceId" value="{{ $service->id }}"
              autocomplete="serviceId" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
              placeholder="Phone number" required autocomplete="phone" />
            <x-input-error :messages="session('phone')" class="mt-2 text-left" id="errorResponse" />
          </div>

          <div class="mt-3">
            <label for="email" class="block">Email</label>
            <input type="email" name="email" id="email" class="block mt-1 w-full" required value="{{ old('email') }}"
              placeholder="Email address" />
            <x-input-error :messages="session('email')" class="mt-2 text-left" id="errorResponse" />
          </div>

          <div class="response"></div>

          <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
              <input id="remember_me" type="checkbox" required
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

          <div class="button-section justify-start mt-4 px-3 mb-4">
            <x-primary-button type="submit" id="submitPayment" class="apply-btn text-center" style="border: none">
              <i class="bi bi-shield-lock me-2"></i> Process Payment
            </x-primary-button>
          </div>

        </form>
      </div>
    </div>

    <div style="" class="mt-5 w-full">
      @include('layouts.full-footer')
    </div>

  </div>

  <script>
   document.addEventListener('DOMContentLoaded', function() {
    // Ensure we have the CSRF meta tag for Ajax requests
    if (!document.querySelector('meta[name="csrf-token"]')) {
      const metaTag = document.createElement('meta');
      metaTag.setAttribute('name', 'csrf-token');
      metaTag.content = '{{ csrf_token() }}';
      document.head.appendChild(metaTag);
    }
    
    // Get the payment button element
    const paymentButton = document.getElementById('submitPayment');
    
    // Add click event listener to the payment button
    paymentButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Show loading state on button
        paymentButton.innerHTML = `
            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
            Processing...
        `;
        paymentButton.disabled = true;
        
        // Get form values
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const phoneInput = document.getElementById('phone');
        const serviceIdInput = document.getElementById('serviceId');
        const amountInput = document.getElementById('amount');
        
        // Create the form data based on the form elements
        const formData = {
            customerName: nameInput.value.trim(),
            customerEmail: emailInput.value.trim(),
            phoneNumber: phoneInput.value.trim(),
            amount: amountInput ? parseInt(amountInput.value, 10) : {{ $amount }},
            serviceId: serviceIdInput ? serviceIdInput.value : '{{ $service->id }}',
            requestType: 'link'
        };

        console.log(formData);
        

        // Basic client-side validation
        if (!formData.customerName) {
            showMessage('error', 'Customer name is required');
            resetButton();
            return;
        }
        
        if (!formData.customerEmail) {
            showMessage('error', 'Email address is required');
            resetButton();
            return;
        }
        
        if (!formData.phoneNumber) {
            showMessage('error', 'Phone number is required');
            resetButton();
            return;
        }

        if (!formData.amount || formData.amount <= 0) {
            showMessage('error', 'Valid amount is required');
            resetButton();
            return;
        }

        // Send request to create invoice
        fetch('/create-invoice', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                // Extract error messages from the response if available
                return response.json().then(data => {
                    throw new Error(data.message || data.error || 'Server error: ' + response.status);
                });
            }
            return response.json();
        })
        .then(data => {   
          console.log(data);
                 
            if (data.success) {
                // Initialize payment with invoice number
                makePayment(data.data.data.invoiceNumber);
            } else {
                // Show error message
                showMessage('error', data.error || 'Failed to create invoice');
                resetButton();
            }
        })
        .catch(error => {
            console.error(error);
            showMessage('error', error.message || 'There was an error creating the invoice');
            resetButton();
        });
    });

    // Function to reset button state
    function resetButton() {
        paymentButton.innerHTML = `
            <i class="bi bi-shield-lock me-2"></i> Process Payment
        `;
        paymentButton.disabled = false;
    }

    // Function to show success/error messages
    function showMessage(type, message) {
        // Target the response div for messages
        const responseDiv = document.querySelector('.response');
        responseDiv.innerHTML = ''; // Clear previous messages
        
        // Create message element
        const messageEl = document.createElement('div');
        messageEl.className = type === 'error' 
            ? 'alert alert-danger mt-3'
            : 'alert alert-success mt-3';
        
        messageEl.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="${type === 'error' ? 'bi bi-exclamation-circle' : 'bi bi-check-circle'} me-2"></i>
                <strong>${type === 'error' ? 'Error: ' : 'Success: '}</strong>
                <span class="ms-2">${message}</span>
            </div>
        `;
        
        // Insert message in the response div
        responseDiv.appendChild(messageEl);
        
        // Auto-remove message after 5 seconds
        setTimeout(() => {
            messageEl.remove();
        }, 5000);
    }

    // Function to initiate IremboPay payment
    function makePayment(invoiceNumber) {
        if (typeof IremboPay === 'undefined') {
            console.error('IremboPay is not defined. Make sure the IremboPay script is included.');
            showMessage('error', 'Payment gateway not available. Please try again later.');
            resetButton();
            return;
        }
        
        IremboPay.initiate({
            publicKey: "pk_live_e3ca819f65094a11923e6be83c35deb9",
            invoiceNumber: invoiceNumber,
            locale: IremboPay.locale.EN,
            callback: (err, resp) => {
                if (!err) {
                    // Send confirmation to server
                    fetch('/payment-confirmation', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            transactionId: resp.transactionId,
                            status: resp.status,
                            amount: resp.amount,
                            invoiceNumber: resp.invoiceNumber,
                            paymentMethod: resp.paymentMethod,
                            timestamp: resp.timestamp
                        })
                    })
                    .then(response => response.json())
                    .then(data => {  
                      console.log(data);
                                            
                        // Show success message and redirect if needed
                        if (data.success) {
                            showMessage('success', 'Payment processed successfully!');
                            
                            // Redirect after 2 seconds if a redirect URL is provided
                            setTimeout(() => {
                                window.location.href = "/request/success";
                            }, 500);
                        } else {
                            showMessage('error', data.message || 'Payment confirmation failed');
                        }
                        
                        resetButton();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showMessage('error', 'Error confirming payment');
                        resetButton();
                    });
                } else {
                    // Handle payment error
                    console.error(err);
                    showMessage('error', 'Payment process failed');
                    resetButton();
                }
            }
        });
    }
});
    </script>

</x-apply-layout>