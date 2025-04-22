@section('title', 'Success')

<x-guest-layout>
    <div class="client-body w-full min-vh-100 d-flex justify-content-center align-items-center" 
         style="background-color: #f8f9fa;">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-9">
                    <div class="card shadow-lg border-0" style="border-radius: 15px; overflow: hidden;">
                        <!-- Success header with gradient -->
                        <div class="card-header text-center p-4" 
                             style="background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%); border: none;">
                            <div class="d-flex justify-content-center mb-3">
                                <div class="success-icon bg-white rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 80px;">
                                    <i class="bi bi-check-circle-fill" style="font-size: 48px; color: #43cea2;"></i>
                                </div>
                            </div>
                            <h1 class="text-white mb-0" style="font-size: 32px; font-weight: 700;">Congratulations!</h1>
                        </div>

                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <p class="text-success fw-bold" style="font-size: 18px;">
                                    Your payment has been successfully received by BScholarz.
                                </p>
                                <div class="alert alert-light border" style="background-color: #f8f9fa; border-radius: 10px;">
                                    <p class="mb-2 fw-medium">Here is the link to your application:</p>
                                    
                                    <div class="input-group mb-1">
                                        <input type="text" id="copy-link" value="{{ $link }}" class="form-control bg-light"
                                            style="border-top-right-radius: 0; border-bottom-right-radius: 0; font-size: 14px;" readonly>
                                        <button id="copy-button" class="btn btn-dark d-flex align-items-center"
                                            style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                            <i class="bi bi-clipboard me-1"></i> Copy
                                        </button>
                                    </div>
                                    <small class="text-muted">Click the button to copy the link to your clipboard</small>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('home') }}" 
                                   class="btn btn-primary btn-lg home-btn"
                                   style="background: linear-gradient(135deg, #185a9d 0%, #43cea2 100%); border: none; border-radius: 8px; font-weight: 600; text-transform: uppercase; transition: all 0.3s ease;">
                                    <i class="bi bi-arrow-right-circle me-2"></i>
                                    Explore More
                                </a>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white text-center p-3">
                            <p class="mb-0 text-muted" style="font-size: 14px;">
                                Thank you for choosing BScholarz. We appreciate your business!
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-center">
                        @include('layouts.full-footer')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Make sure Bootstrap Icons are included -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>

    @if($errors->isNotEmpty())
        <script>
            $(window).on('load', function () {
                $('.set-password').toggleClass('show');
                $('.set-password-btn').toggleClass('show');
                $('.home-btn').toggleClass('hide');
            });
        </script>
    @endif

    <script>
        // Copy functionality with enhanced visual feedback
        document.getElementById('copy-button').addEventListener('click', function () {
            let copyText = document.getElementById('copy-link');
            let copyButton = document.getElementById('copy-button');
            
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            
            navigator.clipboard.writeText(copyText.value)
                .then(() => {
                    // Change button appearance when copied
                    copyButton.innerHTML = '<i class="bi bi-check-circle me-1"></i> Copied!';
                    copyButton.classList.remove('btn-dark');
                    copyButton.classList.add('btn-success');
                    
                    // Add a subtle highlight effect to the input
                    copyText.style.backgroundColor = '#e8f0fe';
                    
                    // Reset after delay
                    setTimeout(() => {
                        copyButton.innerHTML = '<i class="bi bi-clipboard me-1"></i> Copy';
                        copyButton.classList.remove('btn-success');
                        copyButton.classList.add('btn-dark');
                        copyText.style.backgroundColor = '';
                    }, 2000);
                })
                .catch((err) => {
                    alert('Failed to copy: ' + err);
                });
        });
        
        // Optional: Add a subtle animation effect when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>

</x-guest-layout>