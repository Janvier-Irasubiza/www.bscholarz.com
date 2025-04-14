@section('title', 'Payment')

<x-apply-layout>
  <div class="client-body py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
          <div class="card shadow-sm border-0">
            <!-- Header Section -->
            <div class="card-header bg-primary text-white p-4 rounded-top">
              <h1 class="h4 mb-0">Payment Details</h1>
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <!-- Service Info Section -->
              <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-4">
                <div>
                  <h5 class="mb-1">{{ $service->discipline_name }}</h5>
                  <p class="mb-0 text-muted">{{ $service->organization }} - {{ $service->country }}</p>
                </div>
                <div class="d-none d-sm-block">
                  <i class="bi bi-credit-card text-primary fs-1"></i>
                </div>
              </div>

              <!-- Client Message -->
              <div class="mb-4">
                <p class="text-secondary">
                  Dear <span class="fw-bold">{{ $client }}</span>, you're requesting
                  @if ($text) <span class="fw-bold">{{ $text }}</span> @endif
                  for <span class="fw-bold">{{ $service->discipline_name }}</span> application.
                </p>
              </div>

              <!-- Appointment Info -->
              @if ($request_info->is_appointment === 1)
              <div class="alert alert-success mb-4">
                <h5 class="d-flex align-items-center mb-3">
                  <i class="bi bi-calendar-check me-2"></i> Appointment Details
                </h5>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="bg-light p-3 rounded shadow-sm h-100">
                      <p class="text-muted small mb-1">Time</p>
                      <p class="mb-0 fw-medium">{{ $request_info->time }}</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="bg-light p-3 rounded shadow-sm h-100">
                      <p class="text-muted small mb-1">Address</p>
                      <p class="mb-0 fw-medium">{{ $request_info->address }}</p>
                    </div>
                  </div>
                </div>
              </div>
              @endif

              <!-- Payment Amount -->
              <div class="border-top pt-4 mb-4">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="text-secondary mb-0">Request Fee:</h6>
                  <span class="h4 text-primary fw-bold mb-0">{{ number_format($amount) }} RWF</span>
                </div>
              </div>

              <!-- Payment Button -->
              <div class="mb-4">
                <button id="submitPayment" type="submit" class="apply-btn w-full text-center py-3 uppercase">
                  <i class="bi bi-shield-lock me-2"></i> Process Payment
                </button>
                <p class="mt-3 text-center text-muted small mt-2">Your payment information is securely processed.</p>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="mt-5">
            @include('layouts.full-footer')
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
   document.addEventListener('DOMContentLoaded', function() {
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
        
        // Extract values from URL parameters if they're not in the template
        const urlParams = new URLSearchParams(window.location.search);
        const emailFromUrl = urlParams.get('email') || '';
        const phoneFromUrl = urlParams.get('client_phone') || '';          
        
        // Create the form data based on the page content
        const formData = {
            customerName: '{{ $client }}',
            customerEmail: '{{ isset($email) ? $email : "" }}' || emailFromUrl,
            phoneNumber: '{{ isset($phone) ? $phone : "" }}' || phoneFromUrl,
            amount: {{ $amount }},
            serviceId: '{{ $service->id }}',
            applicationId: '{{ $application }}',
            requestInfo: JSON.stringify({
                is_appointment: {{ $request_info->is_appointment }},
                time: '{{ $request_info->time }}',
                address: '{{ $request_info->address }}'
            })
        };

        // Basic client-side validation
        if (!formData.customerName) {
            showMessage('error', 'Customer name is required');
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
        
        // Insert message before payment button
        const buttonSection = paymentButton.parentElement;
        buttonSection.parentElement.insertBefore(messageEl, buttonSection);
        
        // Auto-remove message after 5 seconds
        setTimeout(() => {
            messageEl.remove();
        }, 5000);
    }

    // Function to initiate IremboPay payment
    function makePayment(invoiceNumber) {
        IremboPay.initiate({
            publicKey: "pk_live_bc8d282220e74750894e59dbd1211b9a",
            invoiceNumber: invoiceNumber,
            locale: IremboPay.locale.EN,
            callback: (err, resp) => {
                if (!err) {
                    // On successful payment
                    console.log(resp);
                    
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
                        console.log('Server response:', data);
                        
                        // Show success message and redirect if needed
                        if (data.success) {
                            showMessage('success', 'Payment processed successfully!');
                            
                            // Redirect after 2 seconds if a redirect URL is provided
                                setTimeout(() => {
                                    window.location.href = "/payment/success";
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
