@extends ('layouts.bbg-layout')

@section('title', 'Home')

@section('content')

<div class="content-wrapper">

        <div class="sidebar">
            <div class="d-flex align-items-center mb-4" >
                <h5 style="margin: 0px">BScholarz Trends</h5>
                
                <select class="selectpicker" id="filterKeyword">
                    <option class="sel-option" title="#" selected>Filter by</option>
                    <option class="sel-option" title="#" value="All">All</option>
                    <option class="sel-option" title="#" value="Job">Job</option>
                    <option class="sel-option" title="#" value="Scholarship">Scholarship</option>
                    <option class="sel-option" title="#" value="Study Loan">Study Loan</option>
                    <option class="sel-option" title="#" value="Fellowship">Fellowship</option>
                    <option class="sel-option" title="#" value="Opportunity">Other Opportunities</option>
                </select>

            </div>

            @foreach($sidebarData as $side_data)
            <a data-value="{{ $side_data -> category }}" id="trend" href="{{ route('learnMore', ['discipline_id' => $side_data -> identifier]) }}" style="text-decoration: none; color: black; display: flex" class="trend mt-3">
                <!-- <img class="trend-poster" src="{{ asset('images') }}/{{ $side_data -> poster }}" alt="Poster" > -->
                <div class="trend-content" style="text-align: left">
                    <h5 style="font-size: 18px">@php echo substr($side_data -> discipline_name, 0, 25); @endphp...</h5>
                    <small style="margin-top: -5px">@php echo substr($side_data -> discipline_desc, 0, 35); @endphp...</small>
                </div>
            </a>
            @endforeach
        </div>
    
        <div class="section-right">

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner d-flex" data-bs-ride="carousel">

            @if($carouselData)

            @foreach($carouselData as $c_data)
                <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images') }}/{{ $c_data -> poster }}" alt="First slide">
                <div class="carousel-caption">
                    <div class="d-none d-md-block course-status">
                        {{ $c_data -> status }}
                    </div>
                    <div class="carousel-advert mb-3" style="padding: 0px">
                        <h3 style="font-weight: bold" class="carousel-header">{{ $c_data -> discipline_name }}</h3>

                        {{ $c_data -> organization }} - {{ $c_data -> country }}


                        <div class="d-none d-md-block carousel-desc mt-2">
                            {{ $c_data -> discipline_desc }}
                        </div>
                        <div class="d-flex mt-3" style="b">
                            <div class="d-none d-md-block scholar-desc">
                                <h5>Scholarship Covers:</h5>

                                @php
                                    $covers = explode(',', $c_data -> includes);
                                    $requires = explode(',', $c_data -> requirements)
                                @endphp
                                
                                <ul style="text-align: justify; list-style-type: none; padding: 5px 15px">
                                @foreach($covers as $covers)
                                    <li> <i class="fa-solid fa-square-check"></i> &nbsp; {{ $covers }}</li>
                                @endforeach
                                </ul>
                            </div>
                            <div class="d-none d-md-block scholar-desc-1">
                                <h5>Required:</h5>
                                <ul style="text-align: justify; list-style-type: none; padding: 5px 15px">
                                @foreach($requires as $requires)
                                    <li> <i class="fa-solid fa-square-check"></i> &nbsp;{{ $requires }}</li>
                                @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="d-flex mb-5" style="justify-content: center">
                            <div class="scholar-advert-option">

                            @if(Auth::guard('client') -> user())

                            <a  class="a-link" href="{{ route('client-apply', ['discipline_id' => $c_data  -> identifier]) }}">Request Service</a>

                            @else

                            <a class="a-link" href="{{ route('apply', ['discipline_id' => $c_data -> identifier]) }}">Request Service</a>
                            
                            @endif

                        </div>
                        </div>
                    </div>
                </div>
                </div>
            @endforeach

            @endif

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            </div>

            <div class="section-right-body">

            <a href="{{ route('ksp-apply') }}" target="self">
                <div class="p-3">
                    <div class="m-0 add-item rounded" style="max-width: 100%; overflow: hidden;">
                        <img src="{{ asset('images/ads/ksp.PNG') }}" alt="" style="width: 100%; height: auto; display: block;" class="rounded">
                    </div>
                </div>
            </a>

              @if(!$scholarships->isEmpty())
                <div class="sch-trends">
                <h4 class="mb-4">Trending Scholarships</h4>

                <div class="container overflow-hidden p-0">
                <div class="row gy-5">
                    @foreach($scholarships as $scholarship)
                    <div class="col-lg-4 w-5">
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
                    <div class="card-body card-body-cascade text-center pb-2">

                    <!-- Title -->
                   

                    <p class="card-text" style="text-align: left">{{ $scholarship -> discipline_desc }}</p>

                        <div class="d-flex" style="justify-content: center">
                            <a class="scholarship-learn-more" href="{{ route('learnMore', ['discipline_id' => $scholarship -> identifier]) }}" style="">Learn More <i class="fa fa-arrow-right"></i></a>
                            <div class="">

                            @if(Auth::guard('client') -> user())

                            <a  class="apply-btn" href="{{ route('client-apply', ['discipline_id' => $scholarship  -> identifier]) }}">Request Service</a>

                            @else

                            <a class="apply-btn" href="{{ route('apply', ['discipline_id' => $scholarship -> identifier]) }}">Request Service</a>
                        
                            @endif
                        
                        </div>
                        </div>

                    </div>

                    </div>
                    <!-- Card Wider -->
                    </div>
                
                    @endforeach

                </div>
                  
                  @endif
                  
                  @if(!$opportunity->isEmpty())

                <div class="other-section mt-3" style="">

                <h4 class="mb-4">Trending Job Opportunities</h4>

                <div class="container overflow-hidden p-0" style="">
                <div class="row gy-5">

                    @foreach($opportunity as $opportunity)
                    <div class="col-lg-4">
                    <!-- Card Wider -->
                    <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">

                    <!-- Card image -->
                    <div class="view view-cascade overlay">
                    <img class="card-img-top" src="{{ asset('images') }}/{{ $opportunity -> poster }}" alt="Card image cap">
                    <div class="the-status" style="color: #2D5FA3">
                      
                      @php
                      
                      	$today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                      	$due_date = \Carbon\Carbon::parse($opportunity -> due_date);
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

                    <p class="card-text" style="text-align: left">{{ $opportunity -> discipline_desc}}</p>

                        <div class="d-flex" style="justify-content: center">
                            <a class="scholarship-learn-more" href="{{ route('learnMore', ['discipline_id' => $opportunity -> identifier]) }}" style="">Learn more <i class="fa fa-arrow-right"></i></a>
                            <div class="">

                            @if(Auth::guard('client') -> user())

                            <a  class="apply-btn" href="{{ route('client-apply', ['discipline_id' => $opportunity  -> identifier]) }}">Request Service</a>

                            @else

                            <a class="apply-btn" href="{{ route('apply', ['discipline_id' => $opportunity -> identifier]) }}">Request Service</a>
                        
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
				
                  @if(!$trainings->isEmpty())
                <div class="sch-trends-other mt-3 mb-0" style="">
                <h4 class="mb-4">Trending Fellowships & Trainings</h4>

                <div class="container overflow-hidden p-0">
                <div class="row gy-5">
                    @foreach($trainings as $training)
                    <div class="col-lg-4">
                    <!-- Card Wider -->
                    <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">

                    <!-- Card image -->
                    <div class="view view-cascade overlay">
                    <img class="card-img-top" src="{{ asset('images') }}/{{ $training -> poster }}" alt="Card image cap">
                    <div class="the-status" style="color: #2D5FA3">
                    @php
                      
                      	$today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                      	$due_date = \Carbon\Carbon::parse($training -> due_date);
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

                    
                    <p class="card-text" style="text-align: left">{{ $training -> discipline_desc }}</p>

                        <div class="d-flex" style="justify-content: center">
                            <a class="scholarship-learn-more" href="{{ route('learnMore', ['discipline_id' => $training -> identifier]) }}" style="">Learn More <i class="fa fa-arrow-right"></i></a>
                            <div class="">

                            @if(Auth::guard('client') -> user())

                            <a  class="apply-btn" href="{{ route('client-apply', ['discipline_id' => $training  -> identifier]) }}">Request Service</a>

                            @else

            
                            <a class="apply-btn" href="{{ route('apply', ['discipline_id' => $training -> identifier]) }}">Request Service</a>
                            
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
        </div>

        </div>

        <script>

        let selectEl = document.getElementById('filterKeyword');
        let trendBtn = document.querySelectorAll('#trend');

        selectEl.addEventListener('change', (e) => {
        
            trendBtn.forEach((item) => {
                
                if (e.target.value != 'All' && item.dataset.value != e.target.value) {
                    item.style.display = 'none';
                }

                else {
                    item.style.display = 'flex';
                }

            });

        });

        </script>

        @stop