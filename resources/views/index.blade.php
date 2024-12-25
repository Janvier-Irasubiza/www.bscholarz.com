@extends('layouts.bbg-layout')

@section('title', 'Home')

@section('content')

<div class="content-wrapper">

    <div class="sidebar" style="">   
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
                <div class="trend-content muted-text" style="text-align: left">
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

            @if ($ads->isEmpty())
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
                </div>
            @endif

            @if(!$carouselData->isEmpty())
                <div class="slider border">
                    <!-- Carousel items -->
                    <div class="list">
                        @foreach ($carouselData as $index => $c_data)
                            <div class="item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}"
                                data-identifier="{{ $c_data->identifier }}">
                                <img src="{{ asset('images/' . $c_data->poster) }}" alt="">
                            </div>
                        @endforeach
                    </div>

                    <!-- Thumbnails -->
                    <div class="thumbnail">
                        @foreach ($carouselData as $index => $c_data)
                            <div class="item {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
                                <img src="{{ asset('images/' . $c_data->poster) }}" alt="Thumbnail {{ $index }}">
                            </div>
                        @endforeach
                    </div>

                    <div class="arrows align-items-center">
                        <button type="button" id="prev"><i class="fa-solid fa-arrow-left"></i></button>
                        <div class="buttons align-items-center">
                            <a href="#" class="apply-btn" id="applyBtn">REQUEST SERVICE</a>
                            <a href="#" class="snd-apply-btn" id="learnMoreBtn">LEARN MORE</a>
                        </div>
                        <button type="button" id="next"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const carouselItems = document.querySelectorAll('.list .item');
                        const applyBtn = document.getElementById('applyBtn');
                        const learnMoreBtn = document.getElementById('learnMoreBtn');
                        const prevButton = document.getElementById('prev');
                        const nextButton = document.getElementById('next');

                        let activeIndex = 0;

                        const updateButtons = () => {
                            const activeItem = carouselItems[activeIndex];
                            const identifier = activeItem.getAttribute('data-identifier');

                            // Dynamically construct the URLs using the identifier
                            const applyUrl = `/apply/${identifier}`;
                            const learnMoreUrl = `/learnMore/${identifier}`;

                            applyBtn.setAttribute('href', applyUrl);
                            learnMoreBtn.setAttribute('href', learnMoreUrl);
                        };

                        const setActiveSlide = (index) => {
                            carouselItems.forEach((item, i) => {
                                item.classList.toggle('active', i === index);
                            });
                            activeIndex = index;
                            updateButtons();
                        };

                        prevButton.addEventListener('click', () => {
                            const newIndex = (activeIndex - 1 + carouselItems.length) % carouselItems.length;
                            setActiveSlide(newIndex);
                        });

                        nextButton.addEventListener('click', () => {
                            const newIndex = (activeIndex + 1) % carouselItems.length;
                            setActiveSlide(newIndex);
                        });

                        // Initialize the buttons for the first slide
                        updateButtons();
                    });
                </script>

            @endif


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
                                                                    @elseif($rem > 1)
                                                                        Remaining {{ $rem }} Days
                                                                    @elseif($rem == 1)
                                                                        Remaining {{ $rem }} Day
                                                                    @elseif($rem == 0)
                                                                        Ends Today
                                                                    @else
                                                                        Ended
                                                                    @endif
                                                                </div>
                                                                <a href="#!">
                                                                    <div class="mask rgba-white-slight"></div>
                                                                </a>
                                                            </div>

                                                            <div class="card-body card-body-cascade text-center pb-2">
                                                                <p class="card-text muted-text" style="text-align: left">
                                                                    {{ $scholarship->discipline_desc }}
                                                                </p>

                                                                <div class="d-flex" style="justify-content: center">
                                                                    <a class="scholarship-learn-more muted-text"
                                                                        href="{{ route('learnMore', ['discipline_id' => $scholarship->identifier]) }}">
                                                                        Learn More <i class="fa fa-arrow-right"></i></a>
                                                                    <div>
                                                                        <a class="apply-btn"
                                                                            href="{{ route('apply', ['discipline_id' => $scholarship->identifier]) }}">
                                                                            Request Service
                                                                        </a>
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

            @if(!$opportunity->isEmpty())
                    <div class="other-section mt-3">
                        <h1 class="mb-4" style="font-size: 2em">Trending Job Opportunities</h1>

                        <div class="container overflow-hidden p-0">
                            <div class="row gy-5">
                                @foreach($opportunity as $opportunity)
                                                    <div class="col-lg-4">
                                                        <!-- Card Wider -->
                                                        <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">
                                                            <div class="view view-cascade overlay">
                                                                <img class="card-img-top" src="{{ asset('images') }}/{{ $opportunity->poster }}"
                                                                    alt="Card image cap">
                                                                <div class="the-status" style="color: #2D5FA3">
                                                                    @php
                                                                        $today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                                                                        $due_date = \Carbon\Carbon::parse($opportunity->due_date);
                                                                        $rem = $due_date->diffInDays($today);
                                                                    @endphp

                                                                    @if($opportunity->status == 'Comming soon')
                                                                        {{ $opportunity->status }}
                                                                    @elseif($rem > 1)
                                                                        Remaining {{ $rem }} Days
                                                                    @elseif($rem == 1)
                                                                        Remaining {{ $rem }} Day
                                                                    @elseif($rem == 0)
                                                                        Ends Today
                                                                    @else
                                                                        Ended
                                                                    @endif
                                                                </div>
                                                                <a href="#!">
                                                                    <div class="mask rgba-white-slight"></div>
                                                                </a>
                                                            </div>

                                                            <div class="card-body card-body-cascade text-center pb-0">
                                                                <p class="card-text muted-text" style="text-align: left">
                                                                    {{ $opportunity->discipline_desc }}
                                                                </p>

                                                                <div class="d-flex" style="justify-content: center">
                                                                    <a class="scholarship-learn-more muted-text"
                                                                        href="{{ route('learnMore', ['discipline_id' => $opportunity->identifier]) }}">
                                                                        Learn more <i class="fa fa-arrow-right"></i></a>
                                                                    <div>
                                                                        <a class="apply-btn"
                                                                            href="{{ route('apply', ['discipline_id' => $opportunity->identifier]) }}">
                                                                            Request Service
                                                                        </a>
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
                    <div class="sch-trends-other mb-0 px-3">
                        <h1 class="" style="font-size: 2em">Trending Fellowships & Trainings</h1>

                        <div class="container overflow-hidden p-0 mt-3">
                            <div class="row gy-5">
                                @foreach($trainings as $training)
                                                    <div class="col-lg-4">
                                                        <!-- Card Wider -->
                                                        <div class="card card-cascade wider pb-4" style="background-color: #EBF0FF">
                                                            <div class="view view-cascade overlay">
                                                                <img class="card-img-top" src="{{ asset('images') }}/{{ $training->poster }}"
                                                                    alt="Card image cap">
                                                                <div class="the-status" style="color: #2D5FA3">
                                                                    @php
                                                                        $today = \Carbon\Carbon::now()->format('Y-m-d H:i:s.u');
                                                                        $due_date = \Carbon\Carbon::parse($training->due_date);
                                                                        $rem = $due_date->diffInDays($today);
                                                                    @endphp

                                                                    @if($training->status == 'Comming soon')
                                                                        {{ $training->status }}
                                                                    @elseif($rem > 1)
                                                                        Remaining {{ $rem }} Days
                                                                    @elseif($rem == 1)
                                                                        Remaining {{ $rem }} Day
                                                                    @elseif($rem == 0)
                                                                        Ends Today
                                                                    @else
                                                                        Ended
                                                                    @endif
                                                                </div>
                                                                <a href="#!">
                                                                    <div class="mask rgba-white-slight"></div>
                                                                </a>
                                                            </div>

                                                            <div class="card-body card-body-cascade text-center pb-0">
                                                                <p class="card-text muted-text" style="text-align: left">
                                                                    {{ $training->discipline_desc }}
                                                                </p>

                                                                <div class="d-flex" style="justify-content: center">
                                                                    <a class="scholarship-learn-more muted-text"
                                                                        href="{{ route('learnMore', ['discipline_id' => $training->identifier]) }}">
                                                                        Learn More <i class="fa fa-arrow-right"></i></a>
                                                                    <div>
                                                                        <a class="apply-btn"
                                                                            href="{{ route('apply', ['discipline_id' => $training->identifier]) }}">
                                                                            Request Service
                                                                        </a>
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
            <div class="px-3 mb-8">
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

<script>
    let selectEl = document.getElementById('filterKeyword');
    let trendBtn = document.querySelectorAll('#trend');

    selectEl.addEventListener('change', (e) => {
        trendBtn.forEach((item) => {
            if (e.target.value != 'All' && item.dataset.value != e.target.value) {
                item.style.display = 'none';
            } else {
                item.style.display = 'flex';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const sliderList = document.querySelector('.list');
        const sliderItems = Array.from(sliderList.children);
        const thumbnails = Array.from(document.querySelector('.thumbnail').children);
        const thumbnailContainer = document.querySelector('.thumbnail');
        const nextBtn = document.querySelector('.arrows #next');
        const prevBtn = document.querySelector('.arrows #prev');
        let currentIndex = 0;

        // Function to update the active slide
        function updateActiveSlide(index) {
            // Update slider items
            sliderItems.forEach((item, i) => {
                item.style.display = i === index ? 'block' : 'none';
            });

            // Update thumbnail active state and reorder
            const activeThumbnail = thumbnails[index];
            thumbnailContainer.prepend(activeThumbnail); // Move active thumbnail to the first position

            thumbnails.forEach((thumb, i) => {
                thumb.classList.toggle('active', i === index);
            });

            currentIndex = index;
        }

        // Initialize to show the first slide
        updateActiveSlide(currentIndex);

        // Next button functionality
        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % sliderItems.length; // Show the next thumbnail
            updateActiveSlide(currentIndex);
        });

        // Previous button functionality
        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + sliderItems.length) % sliderItems.length; // Go to the last active thumbnail
            updateActiveSlide(currentIndex);
        });

        // Thumbnail click functionality
        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
                updateActiveSlide(index);
            });
        });

        // Auto-slide functionality
        setInterval(() => {
            currentIndex = (currentIndex + 1) % sliderItems.length; // Always move forward
            updateActiveSlide(currentIndex);
        }, 10000); // Slide every 10 seconds
    });



</script>

@stop