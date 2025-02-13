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
                <div class="flex gap-4 mt-4">
                    <div class="w-full">
                        <label for="amount" class="text-gray-500">Amount</label>
                        <input type="number" name="amount" id="amount" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" required placeholder="Enter amount" autofocus>
                    </div>
                    <div class="w-full">
                        <label for="phone" class="text-gray-500">Phone</label>
                        <input type="text" name="phone" id="phone" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" required placeholder="Enter phone number">
                    </div>
                </div>
                <div class="flex gap-4 mt-4">
                    <div class="w-full">
                        <label for="email" class="text-gray-500">Email</label>
                        <input type="email" name="email" id="email" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your email address">
                    </div>
                    <div class="w-full">
                        <label for="name" class="text-gray-500">Name</label>
                        <input type="text" name="name" id="name" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your name">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="description" class="text-gray-500">Description</label>
                    <input type="text" name="description" id="description" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter description">
                </div>
            </form>
            <form action="" method="POST" id="donateForm" class="hidden">
                @csrf
                <div class="mt-4 flex gap-4">
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="100K">100K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="250K">250K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="500K">500K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="750K">750K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="1M">1M RWF</button>
                </div>

                <div class="flex gap-4 mt-4">
                    <div class="w-full">
                        <label for="amount" class="text-gray-500">Custom Amount</label>
                        <input type="number" name="amount" id="amount" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter amount" required>
                    </div>
                    <div class="w-full">
                        <label for="phone" class="text-gray-500">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter phone number" required>
                    </div>
                </div>
                <div class="flex gap-4 mt-4">
                    <div class="w-full">
                        <label for="email" class="text-gray-500">Email</label>
                        <input type="email" name="email" id="email" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your email address">
                    </div>
                    <div class="w-full">
                        <label for="name" class="text-gray-500">Names</label>
                        <input type="text" name="name" id="name" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Enter your name">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="description" class="text-gray-500">Additional Info</label>
                    <input type="text" name="description" id="description" class="w-full border-2 border-gray-200 rounded-md p-2 mt-1" placeholder="Additional Info" >
                </div>
            </form>
        </div>

    <div class="mt-6">
          <div style="border-bottom: 1px solid #f2f2f24b">
            <p class="text-gray-500">Payment modes</p>
            <small class="text-gray-500">Select your prefered payment method</small>
            <div class="flex-section gap-4 mt-2">
              <div class="w-full mb-3">
                <small class="mb-0 text-gray-500" style="">Mobile money</small>
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
                <small class="mb-0 text-gray-500">Credit card</small>
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

          <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center">
              <input id="remember_me" type="checkbox"
                class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                name="agree" style="border-radius: 4px; border: 1.5px solid #505050" required>
              <span class="ml-2 text-sm text-gray-500">By clicking process payment, you agree with our
                <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" style="color: #5d3fd3; font-weight: 600"
                  href="">
                  Terms and Conditions
                </a>
              </span>
            </label>
          </div>

          <div class="button-section mt-4 mb-4">
            <button type="submit" id="payBtn" class="apply-btn w-full text-center py-3 uppercase f-12"
              style="border: none; font-weight: 600"> Continue With MoMo
            </button>
          </div>

          </div>
        </div>

      </div>

  </div>

  <script>
    const pyToggler = document.getElementById('pyToggler');
    const donateToggler = document.getElementById('donateToggler');
    const paymentForm = document.getElementById('paymentForm');
    const donateForm = document.getElementById('donateForm');
    const payBtn = document.getElementById('payBtn');
    const momobtn = document.getElementById('momobtn');
    const visabtn = document.getElementById('visabtn');
    const momochk = document.getElementById('momochk');
    const visachk = document.getElementById('visachk');
    let type = 'payment';

    pyToggler.addEventListener('click', () => {
      donateToggler.classList.remove('bg-pry', 'text-white');
      pyToggler.classList.add('bg-pry', 'text-white');
      paymentForm.classList.remove('hidden');
      donateForm.classList.add('hidden');
      type = 'payment';
    });

    donateToggler.addEventListener('click', () => {
      donateForm.classList.remove('hidden');
      donateToggler.classList.add('bg-pry', 'text-white');
      pyToggler.classList.remove('bg-pry', 'text-white');
      paymentForm.classList.add('hidden');
      type = 'donate';
    });

    document.querySelectorAll('.amount-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Remove the classes from all buttons
            document.querySelectorAll('.amount-btn').forEach(btn => {
                btn.classList.remove('bg-pry', 'text-white');
            });

            // Add the classes only to the clicked button
            this.classList.add('bg-pry', 'text-white');
        });
    });

    momobtn.addEventListener('click', () => {
      momochk.checked = true;
      payBtn.textContent = 'Continue With MoMo';
    });

    visabtn.addEventListener('click', () => {
      visachk.checked = true;
      payBtn.textContent = 'Continue With Credit Card';
    });

    payBtn.addEventListener('click', () => {
        const form = type === 'payment' ? paymentForm : donateForm;
        const formData = new FormData(form);

        // Validate required fields
        if (!formData.get('amount') || !formData.get('phone')) {
            alert('Please fill out all required fields.');
            return;
        }

        // Prepare the data to send to the server
        const data = {
            amount: formData.get('amount'),
            phone: formData.get('phone'),
            email: formData.get('email'),
            name: formData.get('name'),
            description: formData.get('description'),
            payment_method: document.querySelector('input[name="payment_method"]:checked').value,
            type
        };

        // Send the request to the server
        fetch('/stdlne-pay', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(response => {
            if (response.response.status === 200) {
                // Check if the response contains PCODE and link (credit card payment)
                if (response.response.PCODE && response.response.link) {
                    // Redirect the user to the provided link
                    window.location.href = response.response.link;
                } else if (response.data?.transID) {
                    // Handle MoMo payment success
                    alert(response.message);
                    // Optionally, you can redirect or update the UI here
                } else {
                    // Handle unexpected response
                    alert(response.message || 'Something went wrong');
                }
            } else {
                // Handle payment failure
                alert((response.message || 'Something went wrong') + '. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
  </script>

</x-apply-layout>
