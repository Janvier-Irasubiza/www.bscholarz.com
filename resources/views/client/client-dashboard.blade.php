@section('title', 'Client - Dashboard')

@section('content')

<x-client-layout>

  <x-slot name="header">
    </slot>

    <div class="border py-4 px-5">

      @if(is_null(Auth::guard('client')->user()->phone_number) || is_null(Auth::guard('client')->user()->dob) || is_null(Auth::guard('client')->user()->gender))

      <div class="mb-3">

      <div class="alert alert-warning mb-3" role="alert">
        <div class="d-flex justify-content-between align-items-center">
        <p class="mb-0"> You are missing some important information, complete your profile for better experience!
        </p>


        <a class="apply-btn" href="{{ route('client-profile') }}"
          style="color: ghostwhite; font-size: 14px">Complete Profile</a>

        </div>
      </div>

      <div>

    @endif

          <div class="flex-section gap-2 mt-4">
            <div class="acc-details col-lg-8" style="box-shadow: none;">
              <div class="mb-2 flex-section justify-content-between align-items-center" style="font-size: 20px">
                <h1 style="font-size: 1.2em">
                  <strong>My Applications</strong>
                </h1>
              </div>

              <div class="the-details mt-3" style="padding: 0px; border: ">

                <div style="padding: 0px" class="d-flex justify-content-center">
                  <ul style="margin: 0px;" class="border-bottom w-full">
                    <li class="navigator">
                      <a class="{{ request('status') === 'Pending' || !request('status') ? 'active-navigator' : '' }}"
                        href="{{ route('Client-dashboard', ['status' => 'Pending']) }}">Pending</a>
                    </li>
                    <li class="navigator">
                      <a class="{{ request('status') === 'Postponed' ? 'active-navigator' : '' }}"
                        href="{{ route('Client-dashboard', ['status' => 'Postponed']) }}">Postponed</a>
                    </li>
                    <li class="navigator">
                      <a class="{{ request('status') === 'Complete' ? 'active-navigator' : '' }}"
                        href="{{ route('Client-dashboard', ['status' => 'Complete']) }}">Complete</a>
                    </li>
                  </ul>
                </div>


                <div class="d-flex mt-2">
                  @if($pending_applications->isNotEmpty())
            <div class="container-fluid testimonial-group">
            <div class="row text-center gap-3" style="padding: 0px; margin: 0px">
              @foreach($pending_applications as $application)
          <div class="col-xs-4 application-hold mb-1 px-2" style="background: #EBF0FF">

          <div class="mb-3" style="font-size: 16px"><strong>@php echo substr($application ->
          discipline_name,
          0, 30); @endphp...</strong></div>
          <small class="px-2 pb-2"
          style="border: 1px solid #ddd; padding: 5px; border-radius: 10px; font-size: 14px">{{ $application->application_status }}</small>

          </div>
        @endforeach
            </div>
            </div>

          @else

        <div class="container-fluid testimonial-group">
        <div class="row text-center gap-3 py-3" style="padding: 0px; margin: 0px">
          <p>Nothing to show now!</p>
        </div>
        </div>
      @endif
                </div>

              </div>
            </div>

            <div class="acc-details w-full mb-4" style="box-shadow: none;">
              <h1 style="font-size: 1.4em"><strong>My Membership Plan</strong></h1>
              <div class="mt-3 testimonial-group rounded-lg">

                @if ($subscription)
          <div class="deal-banner rounded-lg" style="background: none; border: 2px solid #5d3fd3; padding: 20px">
            <div class="w-full">
            <h2 style="color: #3c3c3c; font-size: 1.5em; font-weight: 600">{{ $subscription->plan->name }} Plan</h2>
            <p style="color: #5b5b5b"> Epires on {{ $subscription->end_date }} </p>
            </div>
            <a href="{{ route('membership') }}" class="primary-link w-full text-white">Upgrade</a>
          </div>

        @else

      <div class="deal-banner ">
        <div class="deal-text">
        <h2>Don't miss any opportunity!</h2>
        <p>Stay Ahead with the Latest Opportunities &nbsp;
          <br>
          <a class="text-white underline" href="{{ route('membership') }}">View Membership Plans</a>
        </p>
        </div>
      </div>

    @endif

                <div class="py-3 text-center">
                  <p>Huge discounts + 12 months subscription &nbsp; <a class="underline"
                      href="{{ route('contact-us') }}">Contact Sales</a></p>
                </div>
              </div>
            </div>

          </div>

          @if(Session::has('scss'))

            <div
            class="alert alert-success p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
            style="font-size: 17px" role="alert">
            <div>
              <strong>Congratulations!</strong> {{ Session::get('scss') }} &nbsp;
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
            </button>
            </div>

            @php

        Session::forget('scss');

        @endphp

      @endif

          @if(Session::has('exist'))

            <div
            class="alert alert-warning alert-dismissible mb-0 mt-0 fade show p-3  d-flex align-items-center justify-content-between"
            style="font-size: 17px" role="alert">
            <div>
              <strong>Request already exists!</strong> {{ Session::get('exist') }} &nbsp;
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
            </button>
            </div>

            @php

        Session::forget('exist');

        @endphp

      @endif

          <div class="other-sect mt-3 pb-3" style="box-shadow: none;">
            <div class="mb-2" style="font-size: 20px"><strong>Explore More Available Opportunities</strong></div>
            <div class="container-fluid" style="padding: 0px; margin: 0px">
              <div class="row">

                @if ($scholarships->isNotEmpty())
                <div class="col-lg-4">
                  <div class="mb-3"><strong>Scholarship Opportunities</strong></div>
                  <div class="adds-card" style="">

                  @foreach($scholarships as $scholarship)


                @php
          $covers = DB::table('disciplines')->select('includes')->where('id', $scholarship->id)->first();
          $requires = DB::table('disciplines')->select('requirements')->where('id', $scholarship->id)->first();
          $covered = explode(',', $covers->includes);
          $required = explode(',', $requires->requirements);
          @endphp


                <div class="poster-hold mb-4 mt-2 ml-2 mr-2">
                <div class="text-start schol-header mb-2">
                <h1 style="font-size: 17px"><strong>@php echo substr($scholarship -> discipline_name, 0, 29);
                  @endphp...</strong>
                </div>
                <div class="container-fluid" style="padding: 0px">
                <div class="scholarship-desc" style="padding: 0px">

                  <small>@php echo substr($scholarship -> discipline_desc, 0, 135); @endphp...</small>

                </div>
                </div>

                <div class="d-flex mt-2 justift-content-center align-items-center gap-2" style="">
                <a class="scholarship-learn-more"
                  href="{{ route('learnMore', ['discipline_id' => $scholarship->identifier]) }}" style="">More
                  Details<i class="fa fa-arrow-right"></i></a>
                <div class="">

                  <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data">
                  @csrf

                  <input id="application_info" class="block mt-1 w-full" type="text" name="application_info"
                  value="{{ $scholarship->id }}"
                  style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
                  autocomplete="application_info" hidden />

                  <button class="apply-btn">Request Service</button>

                  </form>
                </div>
                </div>

                </div>
          @endforeach

                  </div>
                </div>

        @endif


                @if ($jobs->isNotEmpty())
          <div class="col-lg-4">
            <div class="mb-3"><strong>Job Opportunities</strong></div>
            <div class="adds-card" style="">

            @foreach($jobs as $training)
        <div class="poster-hold mb-4 mt-2 ml-2 mr-2">
          <div class="text-start schol-header mb-2">
          <h1 style="font-size: 17px"><strong>@php echo substr($training -> discipline_name, 0, 29);
          @endphp...</strong>
          </div>
          <div class="container-fluid" style="padding: 0px">
          <div class="scholarship-desc" style="padding: 0px">

          <small>@php echo substr($training -> discipline_desc, 0, 135); @endphp...</small>

          </div>
          </div>

          <div class="d-flex mt-2 justift-content-center align-items-center gap-2" style="">
          <a class="scholarship-learn-more"
          href="{{ route('learnMore', ['discipline_id' => $training->identifier]) }}" style="">More
          Details<i class="fa fa-arrow-right"></i></a>
          <div class="">

          <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data">
          @csrf

          <input id="application_info" class="block mt-1 w-full" type="text" name="application_info"
            value="{{ $training->id }}"
            style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
            autocomplete="application_info" hidden />

          <button class="apply-btn">Request Service</button>

          </form>
          </div>
          </div>

        </div>
      @endforeach

            </div>
          </div>

        @endif

                @if ($trainings->isNotEmpty())

          <div class="col-lg-4">
            <div class="mb-3"><strong>Other Opportunities</strong></div>
            <div class="adds-card" style="">

            @foreach($trainings as $job)
        <div class="poster-hold mb-4 mt-2 ml-2 mr-2">
          <div class="text-start schol-header mb-2">
          <h1 style="font-size: 17px"><strong>@php echo substr($job -> discipline_name, 0, 29);
          @endphp...</strong>
          </div>
          <div class="container-fluid" style="padding: 0px">
          <div class="scholarship-desc" style="padding: 0px">

          <small>@php echo substr($job -> discipline_desc, 0, 135); @endphp...</small>

          </div>
          </div>

          <div class="d-flex mt-2 justift-content-center align-items-center gap-2" style="">
          <a class="scholarship-learn-more"
          href="{{ route('learnMore', ['discipline_id' => $job->identifier]) }}" style="">More
          Details<i class="fa fa-arrow-right"></i></a>
          <div class="">

          <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data">
          @csrf

          <input id="application_info" class="block mt-1 w-full" type="text" name="application_info"
            value="{{ $job->id }}"
            style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
            autocomplete="application_info" hidden />

          <button class="apply-btn">Request Service</button>

          </form>
          </div>
          </div>

        </div>
      @endforeach

            </div>
          </div>

        @endif

              </div>
            </div>
          </div>

        </div>

</x-client-layout>