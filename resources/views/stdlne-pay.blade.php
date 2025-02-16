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
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="100000">100K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="250000">250K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="500000">500K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="750000">750K RWF</button>
                    <button type="button" class="snd-apply-btn amount-btn" data-amount="1000000">1M RWF</button>
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
            <!-- Spinner inside the button -->
            <button type="submit" id="payBtn" class="apply-btn w-full text-center py-3 uppercase f-12"
                style="border: none; font-weight: 600">
                <span id="btnTxt">Continue With MoMo</span> &nbsp; <i class="hidden fa-solid fa-spinner animate-spin" id="Spinner"></i>
            </button>

            <!-- Response Modal -->
            <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h1 class="modal-title f-20 font-semibold" id="responseModalLabel"></h1>
                            <button type="button" onclick="closeModal()" class="btn-close f-20 text-center" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa-solid fa-square-xmark"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p id="responseMessage" class="text-gray-500"></p>
                            <div id="transIdDiv" class="mt-4"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Response Modal -->

          </div>

          </div>
        </div>

      </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
        const payBtn = document.getElementById("payBtn");
        const spinner = document.getElementById("Spinner");
        const btnTxt = document.getElementById("btnTxt");
        const responseMessage = document.getElementById("responseMessage");
        const transIdDiv = document.getElementById("transIdDiv");
        const responseModalLabel = document.getElementById("responseModalLabel");
        const responseModal = new bootstrap.Modal(document.getElementById("responseModal"));
        let type = 'payment';

        // Toggle between Payment and Donate forms
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

                // Get the amount from the button's data attribute
                const amount = this.dataset.amount;

                // Set the value in the donate form's amount input
                document.querySelector('#donateForm input[name="amount"]').value = amount;

                // Add the classes to the clicked button
                this.classList.add('bg-pry', 'text-white');
            });
        });


        // Payment method selection
        document.getElementById("momobtn").addEventListener("click", () => {
            document.getElementById("momochk").checked = true;
            btnTxt.textContent = "Continue With MoMo";
        });

        document.getElementById("visabtn").addEventListener("click", () => {
            document.getElementById("visachk").checked = true;
            btnTxt.textContent = "Continue With Credit Card";
        });

        // Handle payment submission
        payBtn.addEventListener("click", function () {
            spinner.classList.remove("hidden");

            const form = type === 'payment' ? paymentForm : donateForm;
            const formData = new FormData(form);
            const amount = formData.get('amount');
            const phone = formData.get('phone');
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
            const name = formData.get('name');
            const email = formData.get('email');
            const description = formData.get('description');

            // Validate required fields
            if (!amount || !phone) {
                responseMessage.textContent = "Please enter a valid amount and phone number.";
                responseModal.show();
                spinner.classList.add("d-none");
                return;
            }

            if (!paymentMethod) {
                responseMessage.textContent = "Please select a payment method.";
                responseModal.show();
                spinner.classList.add("d-none");
                return;
            }

            // Prepare data for request
             const data = {
                amount: amount,
                phone: phone,
                email: email,
                name: name,
                description: description,
                payment_method: paymentMethod,
                type
            };

            // Send payment request
            fetch('/stdlne-pay', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                console.log("Success:", response);
                spinner.classList.add("hidden");
                responseModalLabel.textContent = response.title;
                responseMessage.textContent = response.message;

                if (response.data.status === 200) {
                    // Handle transaction ID display
                    if (response.data?.data?.transID) {
                        transIdDiv.innerHTML = `
                            <p class="text-gray-500">Transaction ID:</p>
                            <div class="text-sm text-gray-500 d-flex justify-content-between align-items-center gap-2">
                                <p id="transID" class="border rnd bg-gray-300 p-2 w-full">${response.data.data.transID}</p>
                                <button class="p-2 apply-btn text-white rnd" onclick="copyToClipboard()">
                                    <i class="fa-regular fa-copy"></i>
                                </button>
                            </div>
                            <span class="text-gray-500 text-sm mt-2">Keep the transaction to yourself, you might need.</span>
                            `;
                    }

                    // Redirect for credit card payments
                    if (response.data.PCODE && response.data.link) {
                        setTimeout(() => {
                            window.location.href = response.data.link;
                        }, 2000);
                    }
                } else {
                    responseModalLabel.textContent = response.data.title || "Payment Failed";
                    responseMessage.textContent = response.data.message || "Payment failed. Please try again.";
                    responseModal.show();
                }

                responseModal.show();
            })
            .catch(error => {
                console.error("Error:", error);
                spinner.classList.add("hidden");
                responseModalLabel.textContent = "Something Went Wrong";
                responseMessage.textContent = "An error occurred while processing payment.";
                responseModal.show();
            });
        });
   });

    // Copy transaction ID to clipboard
    function copyToClipboard() {
        const transID = document.getElementById("transID").innerText;
        navigator.clipboard.writeText(transID).then(() => {
            alert("Transaction ID copied to clipboard!");
        }).catch(err => {
            console.error("Failed to copy text: ", err);
        });
    }

   // Close response modal
   function closeModal() {
        const responseModalElement = document.getElementById("responseModal");
        if (responseModalElement) {
            // Trigger Bootstrap's modal close event
            responseModalElement.classList.remove("show");
            responseModalElement.style.display = "none";

            // Remove backdrop manually if Bootstrap doesn't remove it
            const modalBackdrop = document.querySelector(".modal-backdrop");
            if (modalBackdrop) {
                modalBackdrop.remove();
            }

            // Reset the forms
            document.getElementById("paymentForm").reset();
            document.getElementById("donateForm").reset();
        } else {
            console.error("Modal element not found.");
        }
    }

</script>
</x-apply-layout>
