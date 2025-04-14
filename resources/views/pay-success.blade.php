@section('title', 'Payment Successful')
<x-apply-layout>
    <div class="client-body padding mt-2 sm-section mb-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Card -->
                    <div class="card border-0 shadow-sm">
                        <!-- Header with success icon -->
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 text-center">
                            <div class="success-icon mb-3">
                                <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fa-solid fa-check" style="font-size: 40px; color: white;"></i>
                                </div>
                            </div>
                            <h2 class="card-title fw-bold text-success">Payment Successful!</h2>
                            <p class="text-muted">Your transaction has been completed successfully.</p>
                        </div>

                            <!-- Confirmation message -->
                            <div class="confirmation-message text-center mb-4">
                                <p>Your payment has been processed successfully. Thank you for your promptness!</p>
                            </div>

                            <!-- Action buttons -->
                            <div class="action-buttons d-flex flex-column flex-md-row gap-3 justify-content-center mt-4">
                                <a href="/pay" class="btn btn-outline-secondary">
                                    <i class="fa-solid fa-credit-card me-2"></i> Make Another Payment
                                </a>
                                <a href="/" class="btn" style="background-color: #5d3fd3; color: white;">
                                    <i class="fa-solid fa-house me-2"></i> Return Home
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Support -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: #5d3fd3;">Need Help?</h5>
                            <p class="text-muted small">If you have any questions about your payment or need assistance, our customer support team is here to help.</p>
                            
                            <div class="support-options d-flex flex-column flex-md-row gap-3 mt-3">
                                <a href="/contact-us" class="btn btn-outline-primary flex-grow-1">
                                    <i class="fa-solid fa-envelope me-2"></i> Contact Support
                                </a>
                                <a href="tel:+250786981832" class="btn btn-outline-secondary flex-grow-1">
                                    <i class="fa-solid fa-phone me-2"></i> Call Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get transaction details from URL parameters if available
            const urlParams = new URLSearchParams(window.location.search);
            
            // Update page with transaction details if they exist in URL
            if (urlParams.has('transactionId')) {
                document.getElementById('transactionId').textContent = urlParams.get('transactionId');
            }
            
            if (urlParams.has('amount')) {
                document.getElementById('paymentAmount').textContent = 'RWF ' + 
                    new Intl.NumberFormat().format(urlParams.get('amount'));
            }
            
            if (urlParams.has('date')) {
                document.getElementById('transactionDate').textContent = urlParams.get('date');
            }
            
            if (urlParams.has('method')) {
                document.getElementById('paymentMethod').textContent = urlParams.get('method');
            }
            
            if (urlParams.has('description')) {
                document.getElementById('paymentDescription').textContent = urlParams.get('description');
            }
            
            // Handle receipt download
            document.getElementById('downloadReceiptBtn').addEventListener('click', function() {
                // This would typically generate a PDF receipt
                // For demo purposes, we'll just show a toast message
                showToast('Downloading receipt...', 'info');
                
                // Simulate download delay
                setTimeout(() => {
                    showToast('Receipt downloaded successfully!', 'success');
                }, 1500);
            });
            
            // Handle receipt printing
            document.getElementById('printReceiptBtn').addEventListener('click', function() {
                showToast('Preparing receipt for printing...', 'info');
                
                // Simulate print preparation
                setTimeout(() => {
                    window.print();
                }, 800);
            });
            
            // Utility function for showing toast notifications
            function showToast(message, type = 'info') {
                // Create toast container if it doesn't exist
                let toastContainer = document.querySelector('.toast-container');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                    document.body.appendChild(toastContainer);
                }
                
                // Create toast element
                const toastEl = document.createElement('div');
                toastEl.className = `toast align-items-center ${type === 'error' ? 'bg-danger' : type === 'success' ? 'bg-success' : 'bg-info'} text-white border-0`;
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.setAttribute('aria-atomic', 'true');
                
                toastEl.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;
                
                toastContainer.appendChild(toastEl);
                
                // Initialize and show toast
                const toast = new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 3000
                });
                toast.show();
                
                // Remove toast after it's hidden
                toastEl.addEventListener('hidden.bs.toast', function () {
                    toastEl.remove();
                });
            }
            
            // Add print styles
            const printStyles = document.createElement('style');
            printStyles.textContent = `
                @media print {
                    body * {
                        visibility: hidden;
                    }
                    .transaction-details, .transaction-details * {
                        visibility: visible;
                    }
                    .transaction-details {
                        position: absolute;
                        left: 0;
                        top: 0;
                        width: 100%;
                    }
                    .card-header {
                        display: none;
                    }
                    .action-buttons, .support-options, nav, footer {
                        display: none !important;
                    }
                }
            `;
            document.head.appendChild(printStyles);
        });
    </script>
</x-apply-layout>