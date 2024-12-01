@extends ('layouts.bbg-layout')

@section('title', 'Subscription')

@section('content')

<div class="body-content">
    <div class="hero-section">
        <h1>Stay Ahead with the Latest Opportunities</h1>
        <p>Subscribe now to get notified instantly about new study programs, jobs, fellowships, and training
            opportunities.
            Get updates via phone calls, text messages, and emails tailored to your preferences.</p>
    </div>

    <div class="plans-section">

        @foreach ($plans as $plan)
            <div class="plan">
                <div class="text-center">
                    <h2>{{ $plan->name }} Plan</h2>
                    <p>{{ $plan->text }}</p>
                    <p class="price">
                    <p class="price">
                        {{ number_format($plan->price) }}/
                        {{ $plan->duration_months }}
                        {{ Str::plural('month', $plan->duration_months) }}
                    </p>
                    <!-- <p class="m-0">RWF</p> -->
                    </p>
                    <a class="w-full mt-4 capitalize"
                        href="{{ auth()->guard('client')->user() 
                            ? route('membership.form', ['plan' => $plan->uuid, 'subscriber' => auth()->guard('client')->user()->email]) 
                            : route('membership.subsciber-form', ['plan' => $plan->uuid]) }}">
                        Subscribe
                    </a>
                </div>
                <div class="services">
                    @forelse ($plan->services as $service)
                        <p class="service">
                            <i class="fa-solid fa-check"></i> {{ $service->name }}
                        </p>
                    @empty
                        <p class="service">No services included in this plan.</p>
                    @endforelse
                </div>
            </div>
        @endforeach

    </div>
</div>

@stop