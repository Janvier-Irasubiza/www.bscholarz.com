@section('title', 'Payment')
<x-apply-layout>
    <div class="client-body padding mt-2 sm-section mb-5">
        <!-- <div style="font-size: 25px;" class="widget-subheading text-center mt-3">Payment</div> -->
        <div style="border-radius: 8px" class="px-3 mt-4 overflow-hidden">
            <!-- Session Status -->
            <div class="d-flex justify-content-between align-items-center mb-4"
                style="border-bottom: 1px solid #5d3fd3;">
                <button class="text-center w-full p-3 font-semibold rnd-md bg-pry text-white rnd-b-none f-18" id="pyToggler">Payment</button>
                <button class="text-center w-full p-3 font-semibold rnd-md rnd-b-none f-18" id="donateToggler">Donate</button>
            </div>

            <div class="" id="types">
                <form action="" method="POST" id="paymentForm">
                    @csrf
                    <div class="flex-section gap-4">
                        <div class="w-full mt-4">
                            <label for="paymentAmount" class="text-gray-500">Amount</label>
                            <input type="number" name="amount" id="paymentAmount" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" required placeholder="Enter amount" autofocus>
                        </div>
                        <div class="w-full mt-4">
                            <label for="paymentPhone" class="text-gray-500">Phone</label>
                            <input type="text" name="phoneNumber" id="paymentPhone" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" required placeholder="Enter phone number">
                        </div>
                    </div>
                    <input type="text" name="requestType" id="paymentRequestType" value="self-filled" class="hidden">
                    <div class="flex-section gap-4">
                        <div class="w-full mt-4">
                            <label for="paymentEmail" class="text-gray-500">Email</label>
                            <input type="email" name="customerEmail" id="paymentEmail" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your email address">
                        </div>
                        <div class="w-full mt-4">
                            <label for="paymentName" class="text-gray-500">Name</label>
                            <input type="text" name="customerName" id="paymentName" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your name">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="paymentDescription" class="text-gray-500">Description</label>
                        <input type="text" name="description" id="paymentDescription" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter description">
                    </div>

                     <!-- Payment Button -->
                    <div class="mb-4 mt-4">
                        <button id="submitPaymentBtn" type="submit" class="apply-btn w-full text-center py-3 uppercase">
                        <i class="bi bi-shield-lock me-2"></i> Process Payment
                        </button>
                        <p class="mt-3 text-center text-muted small mt-2">Your payment information is securely processed.</p>
                    </div>
                </form>
                <form action="" method="POST" id="donateForm" class="hidden">
                    @csrf
                    <div class="mt-4 d-flex gap-3 overflow-auto flex-nowrap justify-content-between no-scroll" style="white-space: nowrap;">
                        <button type="button" class="sm-apply-btn amount-btn" data-amount="100000">100K RWF</button>
                        <button type="button" class="sm-apply-btn amount-btn" data-amount="250000">250K RWF</button>
                        <button type="button" class="sm-apply-btn amount-btn" data-amount="500000">500K RWF</button>
                        <button type="button" class="sm-apply-btn amount-btn" data-amount="750000">750K RWF</button>
                        <button type="button" class="sm-apply-btn amount-btn" data-amount="1000000">1M RWF</button>
                    </div>

                    <input type="text" name="requestType" id="donateRequestType" value="donation" class="hidden">

                    <div class="flex-section gap-4">
                        <div class="w-full mt-4">
                            <label for="donateAmount" class="text-gray-500">Custom Amount</label>
                            <input type="number" name="amount" id="donateAmount" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter amount" required>
                        </div>
                        <div class="w-full mt-4">
                            <label for="donatePhone" class="text-gray-500">Phone Number</label>
                            <input type="text" name="phoneNumber" id="donatePhone" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter phone number" required>
                        </div>
                    </div>
                    <div class="flex-section gap-4">
                        <div class="w-full mt-4">
                            <label for="donateEmail" class="text-gray-500">Email</label>
                            <input type="email" name="customerEmail" id="donateEmail" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your email address">
                        </div>
                        <div class="w-full mt-4">
                            <label for="donateName" class="text-gray-500">Names</label>
                            <input type="text" name="customerName" id="donateName" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your name">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="donateDescription" class="text-gray-500">Additional Info</label>
                        <input type="text" name="description" id="donateDescription" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Additional Info">
                    </div>

                     <!-- Payment Button -->
                    <div class="mb-4 mt-4">
                        <button id="submitDonateBtn" type="submit" class="apply-btn w-full text-center py-3 uppercase">
                        <i class="bi bi-shield-lock me-2"></i> Process Payment
                        </button>
                        <p class="mt-3 text-center text-muted small mt-2">Your payment information is securely processed.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Tab Toggling functionality
            const pyToggler = document.getElementById('pyToggler');
            const donateToggler = document.getElementById('donateToggler');
            const paymentForm = document.getElementById('paymentForm');
            const donateForm = document.getElementById('donateForm');

            pyToggler.addEventListener('click', function() {
                pyToggler.classList.add('bg-pry', 'text-white');
                donateToggler.classList.remove('bg-pry', 'text-white');
                paymentForm.classList.remove('hidden');
                donateForm.classList.add('hidden');
            });

            donateToggler.addEventListener('click', function() {
                donateToggler.classList.add('bg-pry', 'text-white');
                pyToggler.classList.remove('bg-pry', 'text-white');
                donateForm.classList.remove('hidden');
                paymentForm.classList.add('hidden');
            });

            // 2. Donation amount buttons functionality
            const amountButtons = document.querySelectorAll('.amount-btn');
            const donateAmountInput = document.getElementById('donateAmount');
            
            amountButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const amount = this.dataset.amount;
                    donateAmountInput.value = amount;
                    
                    // Highlight the selected button
                    amountButtons.forEach(btn => btn.classList.remove('active-amount'));
                    this.classList.add('active-amount');
                });
            });

            // 3. Form validation function
            function validateForm(form) {
                let amountInput = form.querySelector('input[name="amount"]');
                let phoneInput = form.querySelector('input[name="phoneNumber"]');
                
                if (!amountInput || !amountInput.value || isNaN(amountInput.value) || parseFloat(amountInput.value) <= 0) {
                    showMessage('error', 'Please enter a valid amount');
                    return false;
                }
                
                if (!phoneInput || !phoneInput.value) {
                    showMessage('error', 'Phone number is required');
                    return false;
                }
                
                return true;
            }

            // Handle payment form submission
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!validateForm(this)) return;
                
                const formData = new FormData(this);
                processPayment(formData, 'payment');
            });
            
            // Handle donation form submission
            donateForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!validateForm(this)) return;
                
                const formData = new FormData(this);
                processPayment(formData, 'donation');
            });

            // 4. Payment processing function - updated
            function processPayment(formData, formType) {
                // Verify formData is valid
                if (!(formData instanceof FormData)) {
                    console.error('Invalid FormData object provided');
                    showMessage('error', 'An error occurred with the form data');
                    return;
                }
                
                // Determine which button was clicked
                const submitButton = formType === 'payment' ? 
                    document.getElementById('submitPaymentBtn') : 
                    document.getElementById('submitDonateBtn');
                
                const originalButtonText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Processing...
                `;
                submitButton.disabled = true;
                
                // Convert FormData to object for logging and API submission
                const paymentData = {};
                formData.forEach((value, key) => {
                    paymentData[key] = value;
                });
                                
                // Send request to create invoice
                fetch('/create-invoice', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(paymentData)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || data.error || 'Server error: ' + response.status);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Invoice created:", data);
                    if (data.success) {
                        // Initialize payment with invoice number
                        makePayment(data.data.data.invoiceNumber, paymentData.requestType);
                    } else {
                        showMessage('error', data.error || 'Failed to create invoice');
                        resetButton(submitButton, originalButtonText);
                    }
                })
                .catch(error => {
                    console.error(error);
                    showMessage('error', error.message || 'There was an error creating the invoice');
                    resetButton(submitButton, originalButtonText);
                });
            }

            // Function to reset button state
            function resetButton(button, originalText) {
                button.innerHTML = originalText;
                button.disabled = false;
            }

            // Function to show success/error messages
            function showMessage(type, message) {
                // Remove any existing message first
                const existingMessages = document.querySelectorAll('.alert');
                existingMessages.forEach(msg => msg.remove());
                
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
                
                // Insert message into the form
                const forms = document.getElementById('types');
                forms.insertBefore(messageEl, forms.firstChild);
                
                // Auto-remove message after 5 seconds
                setTimeout(() => {
                    messageEl.remove();
                }, 5000);
            }

            // Function to initiate IremboPay payment
            function makePayment(invoiceNumber, requestType) {
                IremboPay.initiate({
                    publicKey: "pk_live_bc8d282220e74750894e59dbd1211b9a",
                    invoiceNumber: invoiceNumber,
                    locale: IremboPay.locale.EN,
                    callback: (err, resp) => {
                        if (!err) {
                            // On successful payment
                            console.log("Payment response:", resp);
                            
                            // Send confirmation to server with request type
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
                                    timestamp: resp.timestamp,
                                    requestType: requestType // Include the request type in confirmation
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Server response:', data);
                                
                                // Show success message and redirect if needed
                                if (data.success) {
                                    showMessage('success', 'Payment processed successfully!');
                                    
                                    // Different redirect based on payment type
                                    const redirectUrl = requestType === 'donation' ? 
                                        "/donation/success" : "/pay/success";
                                    
                                    // Redirect after 0.5 seconds
                                    setTimeout(() => {
                                        window.location.href = redirectUrl;
                                    }, 500);
                                } else {
                                    showMessage('error', data.message || 'Payment confirmation failed');
                                }
                                
                                // Reset all submit buttons
                                resetButton(document.getElementById('submitPaymentBtn'), 
                                    `<i class="bi bi-shield-lock me-2"></i> Process Payment`);
                                resetButton(document.getElementById('submitDonateBtn'), 
                                    `<i class="bi bi-shield-lock me-2"></i> Process Payment`);
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showMessage('error', 'Error confirming payment');
                                
                                // Reset all submit buttons
                                resetButton(document.getElementById('submitPaymentBtn'), 
                                    `<i class="bi bi-shield-lock me-2"></i> Process Payment`);
                                resetButton(document.getElementById('submitDonateBtn'), 
                                    `<i class="bi bi-shield-lock me-2"></i> Process Payment`);
                            });
                        } else {
                            // Handle payment error
                            console.error(err);
                            showMessage('error', 'Payment process failed');
                            
                            // Reset all submit buttons
                            resetButton(document.getElementById('submitPaymentBtn'), 
                                `<i class="bi bi-shield-lock me-2"></i> Process Payment`);
                            resetButton(document.getElementById('submitDonateBtn'), 
                                `<i class="bi bi-shield-lock me-2"></i> Process Payment`);
                        }
                    }
                });
            }

            // Add CSS for active donation amount button
            const style = document.createElement('style');
            style.textContent = `
                .active-amount {
                    background-color: #5d3fd3 !important;
                    color: white !important;
                }
                .hidden {
                    display: none !important;
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</x-apply-layout>