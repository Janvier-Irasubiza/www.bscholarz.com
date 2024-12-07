@extends ('layouts.bbg-layout')

@section('title', 'Home')

@section('content')

<div class="content-wrapper">

    <div class="sidebar">
        <div class="d-flex align-items-center mb-4">
            <h1 style="margin: 0px; font-size: 1.3em;">BScholarz Trends</h1>

            <select class="selectpicker" id="filterKeyword">
                <option class="sel-option muted-text" title="#" selected>Filter by</option>
                <option class="sel-option muted-text" title="#" value="All">All</option>
                <option class="sel-option muted-text" title="#" value="Job">Job</option>
                <option class="sel-option muted-text" title="#" value="Scholarship">Scholarship</option>
                <option class="sel-option muted-text" title="#" value="Study Loan">Study Loan</option>
                <option class="sel-option muted-text" title="#" value="Fellowship">Fellowship</option>
                <option class="sel-option muted-text" title="#" value="Opportunity">Other Opportunities</option>
            </select>

        </div>

        @foreach($sidebarData as $side_data)
            <a data-value="{{ $side_data->category }}" id="trend"
                href="{{ route('learnMore', ['discipline_id' => $side_data->identifier]) }}"
                style="text-decoration: none; color: black; display: flex" class="trend mt-3">
                <!-- <img class="trend-poster" src="{{ asset('images') }}/{{ $side_data -> poster }}" alt="Poster" > -->
                <div class="trend-content  muted-text" style="text-align: left">
                    <h5 style="font-size: 18px">{{ \Illuminate\Support\Str::limit($side_data->discipline_name, 30) }}</h5>
                    <small style="margin-top: -5px">
                        {{ \Illuminate\Support\Str::limit($side_data->discipline_desc) }}
                    </small>
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
            <div class="carousel-inner d-flex border" data-bs-ride="carousel">
                @foreach ($ads as $ad)
                    <a href="{{ route('open-advert', ['advert' => $ad->id]) }}" target="_blank">
                        <div class="p-3">
                            <div class="m-0 add-item rounded" style="max-width: 100%; overflow: hidden;">
                                <img src="{{ asset('images/ads/') }}/{{$ad->media}}" alt=""
                                    style="width: 100%; height: auto; display: block;" class="rounded">
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div id="carouselExampleIndicators" class="carousel slide mt-3" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner d-flex" data-bs-ride="carousel">

                @if($carouselData)

                    @foreach($carouselData as $c_data)
                        <a href="{{ route('learnMore', ['discipline_id' => $c_data->identifier]) }}">
                            <div class="carousel-item active" style="width: 100%; height: 300px; overflow: hidden;">
                                <img class="d-block w-100 h-100" src="{{ asset('images') }}/{{ $c_data->poster }}"
                                    alt="First slide" style="object-fit: cover;">
                            </div>
                        </a>
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

            @if(!$scholarships->isEmpty())
                    <div class="sch-trends">
                        <h1 class="mb-4" style="font-size: 2em">Trending Scholarships</h1>

                        <div class="container overflow-hidden p-0">
                            <div class="row gy-5">
                                @foreach($scholarships as $scholarship)
                                                    <div class="col-lg-4 w-5">
                                                        <!-- Card Wider -->
                                                        <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">

                                                            <!-- Card image -->
                                                            <div class="view view-cascade overlay">
                                                                <img class="card-img-top" src="{{ asset('images') }}/{{ $scholarship->poster }}"
                                                                    alt="Card image cap">
                                                                <div class="the-status" style="color: #2D5FA3">
                                                                    @php

                                                                        $today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                                                                        $due_date = \Carbon\Carbon::parse($scholarship->due_date);
                                                                        $rem = $due_date->diffInDays($today);

                                                                      @endphp

                                                                    @if($scholarship->status == 'Comming soon')

                                                                        {{ $scholarship->status }}

                                                                    @elseif($rem > 1) Remaining {{ $rem }} Days @elseif($rem == 1) Remaining {{ $rem }} Day @elseif($rem == 0) Ends Today @else Ended @endif
                                                                </div>
                                                                <a href="#!">
                                                                    <div class="mask rgba-white-slight"></div>
                                                                </a>
                                                            </div>

                                                            <!-- Card content -->
                                                            <div class="card-body card-body-cascade text-center pb-2">

                                                                <!-- Title -->

                                                                <p class="card-text muted-text" style="text-align: left">
                                                                    {{ $scholarship->discipline_desc }}
                                                                </p>

                                                                <div class="d-flex" style="justify-content: center">
                                                                    <a class="scholarship-learn-more  muted-text"
                                                                        href="{{ route('learnMore', ['discipline_id' => $scholarship->identifier]) }}"
                                                                        style="">Learn More <i class="fa fa-arrow-right"></i></a>
                                                                    <div class="">

                                                                        @if(Auth::guard('client')->user())

                                                                            <a class="apply-btn"
                                                                                href="{{ route('client-apply', ['discipline_id' => $scholarship->identifier]) }}">Request
                                                                                Service</a>

                                                                        @else

                                                                            <a class="apply-btn"
                                                                                href="{{ route('apply', ['discipline_id' => $scholarship->identifier]) }}">Request
                                                                                Service</a>

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

                                        <h1 class="mb-4" style="font-size: 2em">Trending Job Opportunities</h1>

                                        <div class="container overflow-hidden p-0" style="">
                                            <div class="row gy-5">

                                                @foreach($opportunity as $opportunity)
                                                                            <div class="col-lg-4">
                                                                                <!-- Card Wider -->
                                                                                <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">

                                                                                    <!-- Card image -->
                                                                                    <div class="view view-cascade overlay">
                                                                                        <img class="card-img-top"
                                                                                            src="{{ asset('images') }}/{{ $opportunity->poster }}"
                                                                                            alt="Card image cap">
                                                                                        <div class="the-status" style="color: #2D5FA3">

                                                                                            @php

                                                                                                $today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                                                                                                $due_date = \Carbon\Carbon::parse($opportunity->due_date);
                                                                                                $rem = $due_date->diffInDays($today);

                                                                                              @endphp

                                                                                            @if($scholarship->status == 'Comming soon')

                                                                                                {{ $scholarship->status }}

                                                                                            @elseif($rem > 1) Remaining {{ $rem }} Days @elseif($rem == 1) Remai
                                                                                            n ing {{ $rem }} Day @elseif($rem == 0) Ends Today @else Ended @endif

                                                                                        </div>
                                                                                        <a href="#!">
                                                                                            <div class="mask rgba-white-slight"></div>
                                                                                        </a>
                                                                                    </div>

                                                                                    <!-- Card content -->
                                                                                    <div class="card-body card-body-cascade text-center pb-0">

                                                                                        <p class="card-text muted-text" style="text-align: left">
                                                                                            {{ $opportunity->discipline_desc}}
                                                                                        </p>

                                                                                        <div class="d-flex" style="justify-content: center">
                                                                                            <a class="scholarship-learn-more  muted-text"
                                                                                                href="{{ route('learnMore', ['discipline_id' => $opportunity->identifier]) }}"
                                                                                                style="">Learn more <i class="fa fa-arrow-right"></i></a>
                                                                                            <div class="">

                                                                                                @if(Auth::guard('client')->user())

                                                                                                    <a class="apply-btn"
                                                                                                        href="{{ route('client-apply', ['discipline_id' => $opportunity->identifier]) }}">Request
                                                                                                        Service</a>

                                                                                                @else

                                                                                                    <a class="apply-btn"
                                                                                                        href="{{ route('apply', ['discipline_id' => $opportunity->identifier]) }}">Request
                                                                                                        Service</a>

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
                                        <h1 class="mb-4" style="font-size: 2em">Trending Fellowships & Trainings</h1>

                                        <div class="container overflow-hidden p-0">
                                            <div class="row gy-5">
                                                @foreach($trainings as $training)
                                                                            <div class="col-lg-4">
                                                                                <!-- Card Wider -->
                                                                                <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">

                                                                                    <!-- Card image -->
                                                                                    <div class="view view-cascade overlay">
                                                                                        <img class="card-img-top"
                                                                                            src="{{ asset('images') }}/{{ $training->poster }}"
                                                                                            alt="Card image cap">
                                                                                        <div class="the-status" style="color: #2D5FA3">
                                                                                            @php

                                                                                                $today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                                                                                                $due_date = \Carbon\Carbon::parse($training->due_date);
                                                                                                $rem = $due_date->diffInDays($today);

                                                                                              @endphp

                                                                                            @if($scholarship->status == 'Comming soon')

                                                                                                {{ $scholarship->status }}

                                                                                            @elseif($rem > 1) Remaining {{ $rem }} Days @elseif($rem == 1) Remai
                                                                                            n ing {{ $rem }} Day @elseif($rem == 0) Ends Today @else Ended @endif

                                                                                        </div>
                                                                                        <a href="#!">
                                                                                            <div class="mask rgba-white-slight"></div>
                                                                                        </a>
                                                                                    </div>

                                                                                    <!-- Card content -->
                                                                                    <div class="card-body card-body-cascade text-center pb-0">


                                                                                        <p class="card-text muted-text" style="text-align: left">
                                                                                            {{ $training->discipline_desc }}
                                                                                        </p>

                                                                                        <div class="d-flex" style="justify-content: center">
                                                                                            <a class="scholarship-learn-more muted-text"
                                                                                                href="{{ route('learnMore', ['discipline_id' => $training->identifier]) }}"
                                                                                                style="">Learn More <i class="fa fa-arrow-right"></i></a>
                                                                                            <div class="">

                                                                                                @if(Auth::guard('client')->user())

                                                                                                    <a class="apply-btn"
                                                                                                        href="{{ route('client-apply', ['discipline_id' => $training->identifier]) }}">Request
                                                                                                        Service</a>

                                                                                                @else


                                                                                                    <a class="apply-btn"
                                                                                                        href="{{ route('apply', ['discipline_id' => $training->identifier]) }}">Request
                                                                                                        Service</a>

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

                @if ($partners->count() > 0)
                    <div class="mt-5">
                        <h1 style="font-size: 2em">Our Partners</h1>
                        <div class="mt-3 d-flex flex-wrap gap-3">
                            @foreach ($partners as $partner)
                                <a href="">
                                    <div style="width: 100px; height: 100px;" class="overflow-hidden">
                                        <img src="{{ asset('profile_pictures/' . $partner->poster) }}" alt=""
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
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