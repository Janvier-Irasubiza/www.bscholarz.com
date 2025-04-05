<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Irembo Invoice Creation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card { box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
    <script src="https://dashboard.sandbox.irembopay.com/assets/payment/inline.js"></script>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h2 class="mb-0">Create Invoice</h2>
                    </div>
                    <div class="card-body p-4">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form id="invoiceForm">
                            @csrf
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="customerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="customerEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="customerEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phoneNumber" required pattern="^[0-7][0-9]{7,}$">
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (RWF)</label>
                                <input type="number" class="form-control" id="amount" min="0" step="0.01" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Generate Invoice</button>
                        </form>
                        <div id="responseMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('invoiceForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const responseMessageEl = document.getElementById('responseMessage');
    responseMessageEl.innerHTML = '';

    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    const formData = {
        customerName: document.getElementById('customerName').value.trim(),
        customerEmail: document.getElementById('customerEmail').value.trim(),
        phoneNumber: document.getElementById('phoneNumber').value.trim(),
        amount: parseFloat(document.getElementById('amount').value)
    };

    fetch('/create-invoice', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {

        if (data.success) {
            // window.location.href = data.data.data.paymentLinkUrl;
            // console.log(data.data.data.invoiceNumber);
            makePayment(data.data.data.invoiceNumber)

        } else {
            responseMessageEl.innerHTML =
                `<div class="alert alert-danger">
                    <strong>Error</strong>
                    <p>${result.error || 'Failed to create invoice'}</p>
                </div>`
            ;
        }
    })
    .catch(error => {
        console.log(error);
        responseMessageEl.innerHTML =
        `<div class="alert alert-success">
            <strong>There was an error creating invoice</strong>
        </div>`;
    });
});


function makePayment(invoiceNumber) {
    IremboPay.initiate({
        publicKey: "pk_live_bc8d282220e74750894e59dbd1211b9a",
        invoiceNumber: invoiceNumber,
        locale: IremboPay.locale.EN,
        callback: (err, resp) => {
            if (!err) {
                // Perform actions on success
                // IremboPay.closeModal();
                console.log(resp);
                fetch('/payment-confirmation', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        // Pass specific variables from resp
                        transactionId: resp.transactionId,
                        status: resp.status,
                        amount: resp.amount,
                        invoiceNumber: resp.invoiceNumber,
                        // Add any other relevant fields you want to send
                        // For example:
                        paymentMethod: resp.paymentMethod,
                        timestamp: resp.timestamp
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Server response:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                console.error(err);
            }
        }
    });
}
    </script>
</body>
</html>
