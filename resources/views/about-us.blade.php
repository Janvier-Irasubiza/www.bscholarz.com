@extends ('layouts.bbg-layout')

@section('title', 'About Us')

@section('content')

<div class="body-content" style="background-color: #F8FAFF">
    <div class="bscholars-desc p-0">

        <div class="container-fluid pt-2 px-4 py-2" style="background-color: #F8FAFF">
            <div class="row px-2 py-2">
                <div class="col-lg-4 py-5">
                    <div class="d-flex justify-content-center py-5">
                        <ul class="mt-3" style="padding: 5px 0px 5px 0px; " id="list-example">
                            <li class="" style="">
                                <h4 style="margin-bottom: 0px"><a href="#list-item-1"
                                        class="abt-list list-group-item list-group-item-action active muted-text"
                                        style="text-decoration: none;">Description</a></h4>
                            </li>
                            <li class="mt-3" style="">
                                <h4 style="margin-bottom: 0px"><a href="#list-item-2"
                                        class="abt-list list-group-item list-group-item-action muted-text"
                                        style="text-decoration: none; ">Objectives</a></h4>
                            </li>
                            <li class="mt-3" style="">
                                <h4 style="margin-bottom: 0px"><a href="#list-item-3"
                                        class="abt-list list-group-item list-group-item-action muted-text"
                                        style="text-decoration: none; ">Services</a></h4>
                            </li>
                            <li class="mt-3" style="">
                                <h4 style="margin-bottom: 0px"><a href="#list-item-4"
                                        class="abt-list list-group-item list-group-item-action muted-text"
                                        style="text-decoration: none; ">Vision</a></h4>
                            </li>
                            <li class="mt-3" style="">
                                <h4 style="margin-bottom: 0px"><a href="#list-item-5"
                                        class="abt-list list-group-item list-group-item-action muted-text"
                                        style="text-decoration: none; ">Mission</a></h4>
                            </li>
                            <li class="mt-3" style="">
                                <h4 style="margin-bottom: 0px"><a href="#list-item-6"
                                        class="abt-list list-group-item list-group-item-action muted-text"
                                        style="text-decoration: none; ">Goals</a></h4>
                            </li>
                            <li class="mt-3" style="">
                                <h4 style="margin-bottom: 0px"><a href="#list-item-7"
                                        class="abt-list list-group-item list-group-item-action muted-text"
                                        style="text-decoration: none;">Values</a></h4>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-8 bg-white px-3 py-3" style="border-radius: 7px">
                    <div class="abt-sect-desc" data-spy="scroll" data-target="#list-example" data-offset="140">
                        <div class="pb-5" id="list-item-1" data-offset="100">
                            <div class="pb-3 py-2">
                                <h2 class="d-flex align-items-center"
                                    style="border-left: 4px solid black; color: #5d3fd3; padding: 0px 0px 0px 15px; height: 25px">
                                    BScholarz</h2>
                            </div>

                            <div>
                                <p class="muted-text">
                                    {!! $info->description !!}
                                </p>
                            </div>
                        </div>

                        <div class="pb-5" id="list-item-2" data-offset="100">
                            <div class="pb-3">
                                <h2 class="d-flex align-items-center"
                                    style="border-left: 4px solid black; color: #5d3fd3; padding: 0px 0px 0px 15px; height: 25px">
                                    Objectives</h2>
                            </div>

                            <div>
                                <p class="muted-text">
                                    {!! $info->objectives !!}
                                </p>
                            </div>
                        </div>

                        <div class="pb-5" id="list-item-3" data-offset="100">
                            <div class="pb-3">
                                <h2 class="d-flex align-items-center"
                                    style="border-left: 4px solid black; color: #5d3fd3; padding: 0px 0px 0px 15px; height: 25px">
                                    Sevices</h2>
                            </div>

                            <div>
                                <p class="muted-text">
                                    {!! $info->services !!}
                                </p>
                            </div>
                        </div>

                        <div class="pb-5" id="list-item-4" data-offset="100">
                            <div class="pb-3">
                                <h2 class="d-flex align-items-center"
                                    style="border-left: 4px solid black; color: #5d3fd3; padding: 0px 0px 0px 15px; height: 25px">
                                    Vision</h2>
                            </div>

                            <div>
                                <p class="muted-text">
                                    {!! $info->vision !!}
                                </p>
                            </div>
                        </div>

                        <div class="pb-5" id="list-item-5" data-offset="100">
                            <div class="pb-3">
                                <h2 class="d-flex align-items-center"
                                    style="border-left: 4px solid black; color: #5d3fd3; padding: 0px 0px 0px 15px; height: 25px">
                                    Mission</h2>
                            </div>

                            <div>
                                <p class="muted-text">
                                    {!! $info->mission !!}
                                </p>
                            </div>
                        </div>

                        <div class="pb-5" id="list-item-6" data-offset="100">
                            <div class="pb-3">
                                <h2 class="d-flex align-items-center"
                                    style="border-left: 4px solid black; color: #5d3fd3; padding: 0px 0px 0px 15px; height: 25px">
                                    Goals</h2>
                            </div>

                            <div>
                                <p class="muted-text">
                                    {!! $info->goals !!}
                                </p>
                            </div>
                        </div>

                        <div class="" id="list-item-7" data-offset="100">
                            <div class="pb-3">
                                <h2 class="d-flex align-items-center"
                                    style="border-left: 4px solid black; color: #5d3fd3; padding: 0px 0px 0px 15px; height: 25px">
                                    Values</h2>
                            </div>

                            <div>
                                <p class="muted-text">
                                    {!! $info->values !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script> -->


<script>

    const faqs = document.querySelectorAll(".faq");

    faqs.forEach((faq) => {
        faq.addEventListener("click", () => {
            faq.classList.toggle("active");
        })
    })

    $(document).ready(function () {
        $('.sidebar-drawer').toggleClass('hide');
    });


    let section = document.querySelectorAll('list-example');
    let navLinks = document.querySelectorAll('abt-sect-desc');

    window.onScroll = () => {

        section.forEach(sec => {

            let top = window.scrollY;
            let offset = sec.offsetTop;
            let height = sec.offsetHeight;
            let id = sec.getAttribute('id');

            if (top >= offset && top < offset + height) {
                navLinks.forEach(links => {
                    links.classList.remove('active');
                    document.querySelector('list-example[href*=' + id + ']').classList.add('active');
                });
            }

        });

    }

</script>

@stop