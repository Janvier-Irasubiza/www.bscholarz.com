
@section('title', 'Client - Dashboard')

@section('content')

<x-client-layout>

<x-slot name="header">
</slot>

<div class="client-body pb-1">

@if(is_null(Auth::guard('client') -> user() -> phone_number) || is_null(Auth::guard('client') -> user() -> dob) || is_null(Auth::guard('client') -> user() -> gender)) 

<div class="mb-3">

<div class="alert alert-warning mb-3" role="alert">
            <div class="d-flex justify-content-between align-items-center">
            <p class="mb-0"> You are missing some important information, complete your profile for better experience!</p>


            <a class="apply-btn" href="{{ route('client-profile') }}" style="color: ghostwhite; font-size: 14px" >Complete Profile</a>

            </div>
        </div>

<div>

@endif

    <div class="acc-details " style="">
        <div class="mb-2 flex-section justify-content-between align-items-center" style="font-size: 20px"><strong>My Applications</strong>
      
          @if(Session::has('scss'))
          
          <div class="alert alert-warning alert-dismissible mb-0 mt-0 fade show py-1 px-2" style="font-size: 17px" role="alert">
  <strong>Congratulations!</strong> {{ Session::get('scss') }} &nbsp;
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
  </button>
</div>
          
          @php
          
          Session::forget('scss');
          
          @endphp
          
          @endif
          
         @if(Session::has('exist'))
          
          <div class="alert alert-warning alert-dismissible mb-0 mt-0 fade show py-1 px-2" style="font-size: 17px" role="alert">
  <strong>Request already exists!</strong> {{ Session::get('exist') }} &nbsp;
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
  </button>
</div>
          
          @php
          
          Session::forget('exist');
          
          @endphp
          
          @endif
          
      </div>
        <div class="the-details d-flex">

    @if($pending_applications -> isNotEmpty())
        <div class="container-fluid testimonial-group">
        <div class="row text-center gap-3" style="padding: 0px; margin: 0px">
            @foreach($pending_applications as $application)
            <div class="col-xs-4 application-hold mb-1 px-2" style="background: #EBF0FF">

                <div class="mb-3" style="font-size: 16px"><strong>@php echo substr($application -> discipline_name, 0, 30); @endphp...</strong></div>
                <small class="px-2 pb-2" style="border: 1px solid #ddd; padding: 5px; border-radius: 10px; font-size: 14px">{{ $application -> application_status }}</small>

            </div>
            @endforeach
        </div>
        </div>

        @else

        <div class="container-fluid testimonial-group">
        <div class="row text-center gap-3" style="padding: 0px; margin: 0px">
            <Strong>Nothing to show now!</Strong>
        </div>
        </div>
        @endif

    </div>
    </div>

    <div class="other-sect mt-4 pb-3">
        <div class="mb-2" style="font-size: 20px"><strong>Explore More Available Opportunities</strong></div>
        <div class="container-fluid" style="">
            <div class="row">
                <div class="col-lg-4">
                <div class="mb-3"><strong>Scholarship Opportunities</strong></div>
                <div class="adds-card" style="">
                
                @foreach($scholarships as $scholarship)
                  
                  
                  @php
                    $covers = DB::table('disciplines') -> select('includes') -> where('id', $scholarship -> id) -> first();
                    $requires = DB::table('disciplines') -> select('requirements') -> where('id', $scholarship -> id) -> first();
                    $covered = explode(',', $covers -> includes);
                    $required = explode(',', $requires -> requirements);
                  @endphp
                  
                  
                    <div class="poster-hold mb-4 mt-2 ml-2 mr-2">
                        <div class="text-start schol-header mb-2"><h1 style="font-size: 17px"><strong>@php echo substr($scholarship -> discipline_name, 0, 29); @endphp...</strong></div>
                            <div class="container-fluid" style="padding: 0px">
                                <div class="scholarship-desc" style="padding: 0px">
                                    
                                  <small>@php echo substr($scholarship -> discipline_desc, 0, 135); @endphp...</small>

                                </div>
                            </div>

                            <div class="d-flex mt-2 justift-content-center align-items-center gap-2" style="">
                                <a class="scholarship-learn-more" href="{{ route('item-learnmore', ['discipline_id' => $scholarship -> identifier]) }}" style="">More Details<i class="fa fa-arrow-right"></i></a>
                                <div class="">
                                  
                                  <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data"> @csrf
                                  
                                    <input id="application_info" class="block mt-1 w-full" type="text" name="application_info" value="{{ $scholarship -> id }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="application_info" hidden/>
                                    
                                    <button class="apply-btn">Request Service</button>
                                    
                                    </form>
                                </div>
                            </div>

                    </div>
                    @endforeach

                </div>
                </div>

                <div class="col-lg-4">
                <div class="mb-3"><strong>Job Opportunities</strong></div>
                <div class="adds-card" style="">

                @foreach($jobs as $training)
                    <div class="poster-hold mb-4 mt-2 ml-2 mr-2">
                        <div class="text-start schol-header mb-2"><h1 style="font-size: 17px"><strong>@php echo substr($training -> discipline_name, 0, 29); @endphp...</strong></div>
                            <div class="container-fluid" style="padding: 0px">
                                <div class="scholarship-desc" style="padding: 0px">
                                    
                                  <small>@php echo substr($training -> discipline_desc, 0, 135); @endphp...</small>

                                </div>
                            </div>

                            <div class="d-flex mt-2 justift-content-center align-items-center gap-2" style="">
                                <a class="scholarship-learn-more" href="{{ route('item-learnmore', ['discipline_id' => $training -> identifier]) }}" style="">More Details<i class="fa fa-arrow-right"></i></a>
                                <div class="">
                                  
                                  <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data"> @csrf
                                  
                                    <input id="application_info" class="block mt-1 w-full" type="text" name="application_info" value="{{ $training -> id }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="application_info" hidden/>
                                    
                                    <button class="apply-btn">Request Service</button>
                                    
                                    </form>
                                </div>
                            </div>

                    </div>
                    @endforeach  

                </div>
                </div>


                <div class="col-lg-4">
                <div class="mb-3"><strong>Other Opportunities</strong></div>
                <div class="adds-card" style="">

                @foreach($trainings as $job)
                    <div class="poster-hold mb-4 mt-2 ml-2 mr-2">
                        <div class="text-start schol-header mb-2"><h1 style="font-size: 17px"><strong>@php echo substr($job -> discipline_name, 0, 29); @endphp...</strong></div>
                            <div class="container-fluid" style="padding: 0px">
                                <div class="scholarship-desc" style="padding: 0px">
                                    
                                  <small>@php echo substr($job -> discipline_desc, 0, 135); @endphp...</small>

                                </div>
                            </div>

                            <div class="d-flex mt-2 justift-content-center align-items-center gap-2" style="">
                                <a class="scholarship-learn-more" href="{{ route('item-learnmore', ['discipline_id' => $job -> identifier]) }}" style="">More Details<i class="fa fa-arrow-right"></i></a>
                                <div class="">
                                  
                                  <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data"> @csrf
                                  
                                    <input id="application_info" class="block mt-1 w-full" type="text" name="application_info" value="{{ $job -> id }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="application_info" hidden/>
                                    
                                    <button class="apply-btn">Request Service</button>
                                    
                                    </form>
                                </div>
                            </div>

                    </div>
                    @endforeach  

                </div>
                </div>

            </div>
        </div>
    </div>

</div>

</x-client-layout>
