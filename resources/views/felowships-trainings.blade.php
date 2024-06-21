@extends ('layouts.bbg-layout')

@section('title', 'Felowships & Trainings')

@section('content')

<div class="content-wrapper">

<div class="section-right-ext" style="">

    <div class="section-right-body">

        
        <div class="mt-4" style="padding: 0px 20px 23px 20px">
            <div class="client-poker dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mb-4">
                
                <div class="app-inner-layout__content">
                <div class="tab-content">
                <div>
                <div class="card">
                <div class="card-header-tab card-header d-flex" style="border-bottom: none;">
                <div class="card-header-title font-size-lg col-lg-12 text-center mt-2">
                    <h3 style="font-weight: bold">We Care For You!</h3> 
                </div>
                
                </div>
                <div class="" style="padding: 0px 0px; border: none">
                <div class="no-gutters flex-section gap-2 no-gutters-div" style="">
                <div class="col-sm-6 col-md-4 col-xl-4 mb-1 poker-1" style="">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Available Fellowships & Trainings</div>
                <div class="widget-numbers text-success">{{ number_format($avai_trainings) }}</div>
                <div class="widget-description opacity-8 text-focus">
                <div class="d-inline text-danger pr-1">
                <!-- <i class="fa fa-angle-down"></i>
                <span class="pl-1">54.1%</span> -->
                </div>
                Waiting for you!
                </div>
                </div>
                </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-4 mb-1 poker-1">
                <div style="border: none"  class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                
                <div style="" class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">BBG Community</div>
                <div class="widget-numbers text-success"><span>{{ number_format($community) }}</span></div>
                <div class="widget-description opacity-8 text-focus">
                Already have been served.
                <span class="text-info pl-1">
                <!-- <i class="fa fa-angle-down"></i>
                <span class="pl-1">14.1%</span> -->
                </span>
                </div>
                </div>
                </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4 mb-1 poker-1">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Fellowships & Trainings</div>
                <div class="widget-numbers text-success"><span>{{ number_format($fships_trainings) }}</span></div>
                <div class="widget-description text-focus">
                Offers Jobs!
                <span class="text-warning pl-1">
                <!-- <i class="fa fa-angle-up"></i>
                <span class="pl-1">7.35%</span> -->
                </span>
                </div>
                </div>
                </div>
                </div>
                </div>
                
                </div>
                </div>
        </div>
        </div>
    </div>
    </div>
    </div>

        
    <div class="sch-trends">

        <div class="mb-4"><h4>Available Fellowships & Trainings</h4></div>

        <div class="overflow-hidden p-0">
        <div class="row gy-5"  style="">

            @foreach($f_trainings as $scholarship)
            <div class="col-lg-3 w-5" style="">
            <!-- Card Wider -->
            <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">

            <!-- Card image -->
            <div class="view view-cascade overlay">
            <img class="card-img-top" src="{{ asset('images') }}/{{ $scholarship -> poster }}" alt="Card image cap">
            <div class="the-status" style="color: #2D5FA3">

            @php
                
                $today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                $due_date = \Carbon\Carbon::parse($scholarship -> due_date);
                $rem = $due_date->diffInDays($today);
            
            @endphp
            
            @if($scholarship -> status =='Comming soon')
            
            {{ $scholarship -> status }}
            
            @elseif($rem > 1) Remaining {{ $rem }} Days @elseif($rem == 1) Remaining {{ $rem }} Day @elseif($rem == 0) Ends Today @else Ended @endif
              
              </div>
                <a href="#!">
                    <div class="mask rgba-white-slight"></div>
                </a>
            </div>

            <!-- Card content -->
            <div class="card-body card-body-cascade text-center pb-0">

            <!-- Text -->
            <p class="card-text">{{ $scholarship -> discipline_desc }}</p>

            <div class="d-flex" style="justify-content: center">
                <a class="scholarship-learn-more" href="{{ route('learnMore', ['discipline_id' => $scholarship -> identifier]) }}" style="">Learn More <i class="fa fa-arrow-right"></i></a>
                <div class="scholarship-apply">
                <a class="b-link" href="{{ route('apply', ['discipline_id' => $scholarship -> identifier]) }}">Request Service</a>
                </div>
            </div>

            </div>

            </div>
            <!-- Card Wider -->
            </div>
            @endforeach

            
        </div>
        </div>

        @if($motivation)

        <div class="testimony mt-5 container-fluid" style="">
            <div class="flex-section">
                <div class="col-lg-3 motiv-saying" style="">
                    <h1>{{ $motivation -> motivation_theme }}.</h1>
                    <small><strong>"{{ $motivation -> motivation_sentence }}"</strong></small>
                </div>
                <div class="col-lg-6 saying-desc">
                    <p style="font-size: 19px">{{ $motivation -> motivation }}</p>
                    <div class="">
                        <div class="flex-section text-center align-items-center">
                            <div class="col-lg-6" style="">
                            Inspired? &nbsp <a style="text-decoration: none" href="{{ route('register') }}">Join Us</a>
                            </div>
                            
                            <div class="mt-3 d-flex gap-3 justify-content-end" style="">
                            
                            <img class="saying-profile-picture-cst" src="{{ asset('images') }}/{{ $motivation -> motivator_pp }}" alt="Profile">

                                <div class="name-tag">
                                    <strong><h4 style="width: fit-content; padding: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 7px;background-color: #5dc5afad">{{ $motivation -> motivator_names }}</h4></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="img-div">
                    <div class="saying-pp">
                        <img class="saying-profile-picture" src="{{ asset('images') }}/{{ $motivation -> motivator_pp }}" alt="Profile">
                    </div>
                </div>
            </div>
        </div>

        @endif

        <section class="freq-asked-questions mt-5">
        <h4>Frequently Asked Questions (FAQs)</h4>

            @foreach($faqs as $faq)    
            <div class="faq mb-2" style="border: 1px solid #d9d9d9">
                <div class="question">
                    <h3>{{ $faq -> question }}</h3>

                    <svg width="15" height="10" viewBox="0 0 42 25">
                        <path d="M3 3L21 21L39 3" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>

                </div>

                <div class="answer">
                    <p>{{ $faq -> answer }}</p>
                </div>

            </div>
            @endforeach

        </section>

<div class="mt-3">
        <a href="{{ route('faq') }}" style="">Read more FAQs</a>
        </div>
        </div>

    </div>
    
</div>
</div>
</div>
</div>


<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>


<script>


$(document).ready(function(){ 
    $('.sidebar-drawer').toggleClass('hide');
});

const faqs = document.querySelectorAll(".faq");

faqs.forEach((faq) => {
    faq.addEventListener("click", () => {
        faq.classList.toggle("active");
    })
})

</script>


@stop