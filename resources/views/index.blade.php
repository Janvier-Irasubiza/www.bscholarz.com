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

        <div class="p-3">

            @if ($ads && count($ads) > 0)
                <div id="carouselExampleIndicators" class="carousel slide mt-3" data-bs-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        @foreach ($ads as $index => $ad)
                            <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $index }}"
                                class="{{ $index === 0 ? 'active' : '' }}">
                            </li>
                        @endforeach
                    </ol>

                    <!-- Carousel Items -->
                    <div class="carousel-inner">

                        @foreach ($ads as $index => $ad)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <a href="{{ route('open-advert', ['advert' => $ad->id]) }}" target="_blank">
                                    <img src="{{ asset('images/ads/' . $ad->poster) }}"
                                        alt="{{ $c_data->name ?? 'Carousel Slide' }}" class="d-block w-100"
                                        style="height: 300px; object-fit: cover;">
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <!-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                                                                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                                                        <span class="visually-hidden">Previous</span>
                                                                                                    </a>
                                                                                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                                                                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                                                        <span class="visually-hidden">Next</span>
                                                                                                    </a> -->
                </div>
            @endif

            <div class="slider border">
                <!-- Carousel items -->
                <div class="list">
                    @foreach ($carouselData as $index => $c_data)
                        <div class="item">
                            <img src="{{ asset('images/' . $c_data->poster) }}" alt="">
                        </div>
                    @endforeach
                </div>
                <!-- Thumbnails -->
                <div class="thumbnail">
                    @foreach ($carouselData as $index => $c_data)
                        <div class="item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('images/' . $c_data->poster) }}" alt="">
                        </div>
                    @endforeach
                </div>
                <div class="arrows align-items-center">
                    <button type="button" id="prev"><i class="fa-solid fa-arrow-left"></i></button>
                    <div class="buttons align-items-center">
                        <a href="{{ route('apply', ['discipline_id' => $c_data->identifier]) }}"
                            class="apply-btn">REQUEST SERVICE</a>
                        <a href="{{ route('learnMore', ['discipline_id' => $c_data->identifier]) }}"
                            class="snd-apply-btn">LEARN MORE</a>
                    </div>
                    <button type="button" id="next"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
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

                                                                        <a class="apply-btn"
                                                                            href="{{ route('apply', ['discipline_id' => $scholarship->identifier]) }}">Request
                                                                            Service</a>


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



                                                                                                <a class="apply-btn"
                                                                                                    href="{{ route('apply', ['discipline_id' => $opportunity->identifier]) }}">Request
                                                                                                    Service</a>


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



                                                                                                <a class="apply-btn"
                                                                                                    href="{{ route('apply', ['discipline_id' => $training->identifier]) }}">Request
                                                                                                    Service</a>


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
                                    <div style="width: 100px; height: 100px;" class="overflow-hidden rounded">
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

        document.addEventListener('DOMContentLoaded', function () {
            let slider = document.querySelector('.slider');
            let nextBtn = document.querySelector('.arrows #next');
            let prevBtn = document.querySelector('.arrows #prev');
            let sliderList = document.querySelector('.list');
            let sliderItems = document.querySelectorAll('.list .item');

            nextBtn.addEventListener('click', function () {
                let firstItem = sliderList.children[0]; // Get the first child
                sliderList.appendChild(firstItem); // Move it to the end
                slider.classList.remove('prev');
                slider.classList.add('next');
            });

            prevBtn.addEventListener('click', function () {
                let lastItem = sliderList.children[sliderList.children.length - 1]; // Get the last child
                sliderList.insertBefore(lastItem, sliderList.children[0]); // Move it to the beginning
                slider.classList.remove('next');
                slider.classList.add('prev');
            });
        });

    </script>

    @stop