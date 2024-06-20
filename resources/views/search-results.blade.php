@extends ('layouts.bbg-layout')

@section('title', 'Results')

@section('content')

<div class="content-wrapper">
    
        <div class="section-right-ext">

            <div class="section-right-body">

            <div class="sch-trends pb-2" >
            <div class="container-section">
                <div class="sch-trends pb-3" style="border-radius: 6px">
                    <h4>Results for: {{ $keyWord }} @if($results -> isEmpty()) <small>Not found </small> @endif</h4>
                </div>
            </div>

            <div class="pt-3 pb-0">
                <div class="container-section">

                @foreach($results as $result)
                    <div class="card mb-3" style="background-color: #ffffff5b;">
                        <div class="card-header">
                           <div class="d-flex align-items-center justify-content-between">
                                <h5> {{ $result -> discipline_name }} </h5>
                                <h6 style="border: 2px solid #000; padding: 3px 10px; border-radius: 5px"> {{ $result -> category }} </h6>
                           </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $result -> discipline_desc }}</p>
                            <a href="{{ route('learnMore', ['discipline_id' => $result -> identifier]) }}" class="scholarship-learn-more apply-btn mt-3" style="font-size: 15px">Learn More <i style="font-size: 13px" class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
            </div>

              @if(!$sidebarData->isEmpty())
            <div class="px-4 pt-2 pb-4 mt-2">
                <div class="container-section">
                    <h6 style="font-size: 17px">You may also like: </h6>
                </div>

                <div class="container-section mt-2">

                <div class="row gy-5">
                    @foreach($sidebarData as $scholarship)

                    <div class="col-lg-3 w-5">
                    <!-- Card Wider -->
                    <div class="card card-cascade wider pb-4" style="">

                    <!-- Card image -->
                    <div class="view view-cascade overlay">
                    <img class="card-img-top" src="{{ asset('images') }}/{{ $scholarship -> poster }}" alt="Card image cap">
                    <div class="the-status" style="color: white">
                        {{ $scholarship -> status }}
                    </div>
                    <a href="#!">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                    </div>

                    <!-- Card content -->
                    <div class="card-body card-body-cascade text-center pb-2">

                    <!-- Title -->
                    <h5 class="card-title pb-2"><strong>{{ $scholarship -> discipline_name }}</strong></h5>
                    <h6 class="blue-text pb-2"><strong>{{ $scholarship -> mode}} - {{ $scholarship -> country}}</strong></h6>
                    <!-- Text -->

                    <!-- <p class="card-text">{{ $scholarship -> discipline_desc }}</p> -->

                        <div class="d-flex" style="justify-content: center">
                            <a class="scholarship-learn-more" href="{{ route('learnMore', ['discipline_id' => $scholarship -> identifier]) }}" style="">Learn More <i class="fa fa-arrow-right"></i></a>
                            <div class="scholarship-apply">

                            @if(Auth::guard('client') -> user())

                            <a  class="b-link" href="{{ route('client-apply', ['discipline_id' => $c_data  -> identifier]) }}">Apply Now</a>

                            @else

                            <a class="b-link" href="{{ route('apply', ['discipline_id' => $scholarship -> identifier]) }}">Apply Now</a>
                        
                            @endif
                        
                        </div>
                        </div>

                    </div>

                    </div>
                    <!-- Card Wider -->
                    </div>


                    @endforeach

                </div>
                </div>
            </div>

              @endif	
        </div>

        </div>


<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>


<script>


$(document).ready(function(){ 
    $('.sidebar-drawer').toggleClass('hide');
});

</script>

        @stop