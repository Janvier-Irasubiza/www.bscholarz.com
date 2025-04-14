@section('title', 'Donation Successful')
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
                            <h2 class="card-title fw-bold text-success">Thank You for Your Donation!</h2>
                            <p class="text-muted">Your generous contribution has been received successfully.</p>
                        </div>

                            <!-- Thank you message -->
                            <div class="thank-you-message text-center mb-4">
                                <p>Your donation helps us make a difference. We truly appreciate your support and generosity.</p>
                                <p class="mb-0 small text-muted">A receipt has been sent to your email address.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional information card -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: #5d3fd3;">How Your Donation Helps</h5>
                            <div class="impact-info">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="icon-box me-3 mt-1">
                                        <i class="bi bi-lightbulb text-warning" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Impact</h6>
                                        <p class="text-muted small mb-0">Your donation directly supports our mission to provide education and resources to those in need.</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start mb-3">
                                    <div class="icon-box me-3 mt-1">
                                        <i class="bi bi-graph-up-arrow text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Transparency</h6>
                                        <p class="text-muted small mb-0">We're committed to transparency in how funds are used. Your donation will be allocated to our programs with care.</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start">
                                    <div class="icon-box me-3 mt-1">
                                        <i class="bi bi-people text-primary" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Community</h6>
                                        <p class="text-muted small mb-0">You've joined a community of supporters helping to make a difference in Rwanda and beyond.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: #5d3fd3;">Stay Connected</h5>
                            <p class="text-muted small">Subscribe to our newsletter to receive updates about our projects and the impact of your donation.</p>
                            
                            <form class="mt-3">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Your email address" aria-label="Email" aria-describedby="subscribe-btn">
                                    <button class="btn" type="button" id="subscribe-btn" style="background-color: #5d3fd3; color: white;">Subscribe</button>
                                </div>
                            </form>
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
                document.getElementById('donationAmount').textContent = 'RWF ' + 
                    new Intl.NumberFormat().format(urlParams.get('amount'));
            }
            
            if (urlParams.has('date')) {
                document.getElementById('transactionDate').textContent = urlParams.get('date');
            }
            
            if (urlParams.has('method')) {
                document.getElementById('paymentMethod').textContent = urlParams.get('method');
            }
            
            // Handle newsletter subscription
            document.getElementById('subscribe-btn').addEventListener('click', function() {
                const emailInput = this.previousElementSibling;
                const email = emailInput.value.trim();
                
                if (!email || !isValidEmail(email)) {
                    showToast('Please enter a valid email address', 'error');
                    return;
                }
                
                // Here you would normally send this to your server
                // For now we'll just show a success message
                showToast('Thank you for subscribing!', 'success');
                emailInput.value = '';
            });
            
            // Handle social share buttons
            document.querySelectorAll('.social-buttons a').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Get platform from icon class
                    const platform = this.querySelector('i').className.split('-')[1];
                    
                    // This would typically open a share dialog
                    showToast(`Share functionality for ${platform} would open here`, 'info');
                });
            });
            
            // Utility functions
            function isValidEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }
            
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
        });
    </script>
</x-apply-layout>