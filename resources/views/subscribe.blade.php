@extends('layouts.bbg-layout')

@section('title', 'Subscription')

@section('content')

<div class="body-content">
    <div class="hero-section">
        <h1>Stay Ahead with the Latest Opportunities</h1>
        <p>Subscribe now to get notified instantly about new study programs, jobs, fellowships, and training
            opportunities.
            Get updates via phone calls, text messages, and emails tailored to your preferences.</p>
    </div>
    <div class="cart-container mb-5 mt-5">

        <form action="{{ route('subsciber.submit') }}" method="post" id="subscription-form">
            @csrf
            <!-- Plan Selection -->
            <h3 style="color: #555">Your Info</h3>
            <div class="cart">
                <div class="plan-details">
                    <input type="hidden" name="plan" value="{{ $plan->uuid }}">
                    <div class="plan-info gap-4">
                        <div class="plan-period w-full">
                            <label for="period" class="" style="font-size: 1em; color: #555">Full Name</label>
                            <input type="text" name="names" class="w-full p-2" placeholder="Enter your names"
                                value="{{ old('names') }}" autofocus required>
                            <x-input-error :messages="$errors->get('names')" class="text-danger mb-3 text-left" />
                        </div>
                        <div class="plan-period w-full">
                            <label for="period" class="f-17" style="font-size: 1em; color: #555">Phone number</label>
                            <input type="text" name="phone_number" class="w-full p-2"
                                placeholder="Enter your phone number" value="{{ old('phone_number') }}" required>
                            <x-input-error :messages="$errors->get('phone_number')"
                                class="mb-3 text-left text-danger" />
                        </div>
                    </div>
                    <div class="plan-period w-full mt-3">
                        <label for="period" class="f-17" style="font-size: 1em; color: #555">Email Address</label>
                        <input type="email" name="email" class="w-full p-2" placeholder="Enter you email address"
                            value="{{ old('email') }}" required>
                        <x-input-error :messages="$errors->get('email')" class="text-danger mb-3 text-left" />
                    </div>
                    <div class="offer-info">
                        <p><!-- dynamic plan info --></p>
                    </div>
                    <div class="" id="response"></div>
                </div>

                <!-- Subtotal Section -->
                <div class="subtotal-section">
                    <div class="subtotal-info d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="muted-text">{{ $plan->name }} Plan</h4>
                            <p class="text-muted">
                                {{$plan->duration_months . ' ' . Str::plural('month', $plan->duration_months) }}
                            </p>
                        </div>
                        <h4 class="price">RF {{ number_format($plan->price) }}</h4>
                    </div>
                    <button type="submit" class="continue-btn">Continue &nbsp;
                        <i class="fa-solid fa-spinner d-none" id="spinner"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop