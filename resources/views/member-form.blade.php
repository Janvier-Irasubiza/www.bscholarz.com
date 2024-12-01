@extends('layouts.bbg-layout')

@section('title', 'Subscription')

@section('content')

<div class="body-content">
    <div class="cart-container mb-5 mt-5">

        <!-- Banner -->
        <div class="deal-banner mb-5">
            <div class="deal-text">
                <h2>Don't miss out!</h2>
                <p>Huge discounts + 12 months subscription &nbsp; <a class="text-white"
                        href="{{ route('contact-us') }}">Contact Sales</a></p>
            </div>
            <div class="deal-graphic">
                <span>%</span>
            </div>
        </div>

        <form action="{{ route('membership.submit') }}" method="post" id="subscription-form">
            @csrf

            <!-- Plan Selection -->
            <h1>Your Plan</h1>
            <div class="cart">
                <div class="plan-details">
                    <input type="hidden" name="subscriber" value="{{ $subscriber->id }}">
                    <x-input-error :messages="$errors->get('subscriber')" class="mb-3 text-left text-danger" />
                    <select name="plan" id="plan" class="w-full active-plan muted-text">
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->uuid }}" {{ $plan->uuid === $requested_plan->uuid ? 'selected' : '' }}>
                                {{ $plan->name }} Plan
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('plan')" class="mb-3 text-left text-danger" />
                    <div class="plan-info mt-4">
                        <div class="plan-period w-full">
                            <label for="period">Period</label>
                            <select id="period" name="period" class="w-full">
                                <option value="3">3 months</option>
                                <option value="6">6 months</option>
                                <option value="9">9 months</option>
                                <option value="12">12 months</option>
                            </select>
                            <x-input-error :messages="$errors->get('period')" class="mb-3 text-left text-danger" />
                            <input type="hidden" name="duration" class="w-full mt-3 duration">
                            <x-input-error :messages="$errors->get('duration')" class="mb-3 text-left text-danger" />
                            <input type="hidden" name="amount" class="w-full mt-3 amount">
                            <x-input-error :messages="$errors->get('amount')" class="mb-3 text-left text-danger" />
                        </div>
                        <div class="plan-pricing col-lg-5 col-md-12">
                            <span class="price">RWF <!-- dynamic pricing --></span>
                        </div>
                    </div>
                    <p style="color: #666">Expires on <!-- dynamic renewal date --></p>
                    <div class="offer-info">
                        <p><!-- dynamic plan info --></p>
                    </div>
                    <div class="" id="response"></div>
                    <x-input-error :messages="$errors->get('error')" class="mb-3 text-left text-danger" />
                </div>

                <!-- Subtotal Section -->
                <div class="subtotal-section">
                    <div class="subtotal-info">
                        <p class="plan-discount">Selected Plan<span>RWF <!-- dynamic plan price --></span></p>
                        <p class="subtotal-original">Subtotal <span>RWF <!-- dynamic subtotal --></span></p>
                        <p class="subtotal-final">RWF <!-- dynamic final price --></p>
                    </div>
                    <button type="submit" class="continue-btn">Continue &nbsp;
                        <i class="fa-solid fa-spinner d-none" id="spinner"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Dynamic data from backend
    const plansData = @json($plans->mapWithKeys(fn($plan) => [$plan->uuid => ['name' => $plan->name, 'price' => $plan->price, 'text' => $plan->text]]));
    console.log(plansData);

    // DOM elements
    const planSelect = document.querySelector('#plan');
    const periodSelect = document.getElementById('period');
    const priceSpan = document.querySelector('.plan-pricing .price');
    const renewDateParagraph = document.querySelector('.plan-details p');
    const offerInfoParagraph = document.querySelector('.offer-info p');
    const planDiscountParagraph = document.querySelector('.plan-discount span');
    const subtotalOriginalParagraph = document.querySelector('.subtotal-original span');
    const subtotalFinalParagraph = document.querySelector('.subtotal-final');
    const durationInput = document.querySelector('.duration');
    const amountInput = document.querySelector('.amount');

    // Helper function: Format currency
    function formatCurrency(value) {
        return new Intl.NumberFormat('en-RW', { style: 'currency', currency: 'RWF' }).format(value);
    }

    function calculateRenewDate(months) {
        const currentDate = new Date();
        currentDate.setMonth(currentDate.getMonth() + months);

        // Format the date to match the user's local timezone
        return currentDate.toLocaleDateString('en-GB', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
        });
    }

    // Update details dynamically
    function updatePlanDetails() {
        const selectedPlanUUID = planSelect.value;
        const selectedPlan = plansData[selectedPlanUUID];
        const selectedPeriod = parseInt(periodSelect.value, 10);

        if (selectedPlan) {
            // Calculate total price based on 3-month intervals
            const periodGroups = Math.ceil(selectedPeriod / 3); // Determine how many 3-month periods
            const totalPrice = selectedPlan.price * periodGroups;

            // Update price and period
            priceSpan.textContent = `${formatCurrency(totalPrice)} / ${selectedPeriod} month(s)`;

            // Update renewal date
            renewDateParagraph.textContent = `Renews on ${calculateRenewDate(selectedPeriod)}`;
            durationInput.value = calculateRenewDate(selectedPeriod);
            amountInput.value = totalPrice;

            // Update plan info
            offerInfoParagraph.textContent = `${selectedPlan.text}.`;

            // Update pricing summary
            planDiscountParagraph.textContent = formatCurrency(selectedPlan.price);
            subtotalOriginalParagraph.textContent = formatCurrency(totalPrice);
            subtotalFinalParagraph.textContent = formatCurrency(totalPrice);
        }
    }


    // Event listeners
    planSelect.addEventListener('change', updatePlanDetails);
    periodSelect.addEventListener('change', updatePlanDetails);

    // Initialize on load
    document.addEventListener('DOMContentLoaded', updatePlanDetails);
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('subscription-form');
        const spinner = document.getElementById('spinner');

        form.addEventListener('submit', async (event) => {
            // Show spinner
            spinner.classList.remove('d-none');
        });
    });

</script>

@stop