@extends ('layouts.bbg-layout')

@section('title', 'Learn more')

@section('content')

<div class="content-wrapper">

    <div class="section-right-ext mb-5 pt-0">

        <div class="section-right-content mb-5 client-body-cstm pb-1">

            <div class="flex-section">
                <div class="w-full">

                    <div class="trends-summary">
                        <div class="overflow-hidden">
                            <div class="flex-section justify-content-center" style="">

                                <div class="col-lg-10 cstm-learn-desc-hold" style="">
                                    <div class="" style="align-items: center">
                                        <div class="pb-2" style="border-bottom: 1px solid #0000002d">
                                            <strong>
                                                <h2 style="font-size: 22px" class="muted-text">
                                                    {{ $discipline->discipline_name }}
                                                </h2>
                                            </strong>
                                            <p class="text-muted">{{ $discipline->country }}</p>
                                        </div>
                                        <div class="mb-3 mt-4 muted-text">
                                            {!! $discipline->discipline_detailed_desc !!}
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 px-5" style="position: sticky; right: 0px; z-index: 10;">
                    <div class="gap-5 mt-5">
                        <div class="w-full mt-2" style="">
                            <div class="col-lg p-1 pb-0" style="">

                                <strong class="f-18 muted-text">Requirements</strong>
                                <div class="mt-2 p" style="">

                                    <div class="" style="">

                                        @php

                                            $required = explode(',', $discipline->requirements);
                                        @endphp

                                        @foreach($required as $item)
                                            <div style="">

                                                <div class="mb-2 muted-text" style="">
                                                    <i style="font-size: 13px" class="fa-regular fa-circle-check"></i>
                                                    {{ $item }}
                                                </div>

                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="w-full mt-4" style="">
                            <div class="col-lg p-1 pb-0" style="">

                                @php 
                                    $included = explode(',', $discipline->includes);

                                @endphp

                                <strong class="f-18 muted-text">Benefits</strong>
                                <div class="mt-2" style="padding: 0px;">
                                    <div class="" style="padding: 0px; margin: 0px; width: fit-content">

                                        @foreach($included as $item)

                                            <div style="">

                                                <div class="mb-2 muted-text" style="">
                                                    <span> <i style="font-size: 13px"
                                                            class="fa-regular fa-circle-check"></i>
                                                        {{ $item }} </span>
                                                </div>

                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 mt-4 muted-text d-flex align-items-center gap-5">
                        <div>
                            <p class="text-muted m-0">Started: </p>
                            <p>{{ $discipline->start_date }}</p>
                        </div>
                        <div>
                            <p class="text-muted m-0">Deadline: </p>
                            <p>{{ $discipline->due_date }} </p>
                        </div>
                    </div>

                    <div class="col-lg d-flex justify-content-center gap-3 mt-3" style="">

                        @if(Auth::guard('client')->user())

                            <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data"
                                class="w-full">
                                @csrf

                                <input id="application_info" class="block mt-1 w-full" type="text" name="application_info"
                                    value="{{ $discipline->id }}"
                                    style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required
                                    autocomplete="application_info" hidden />

                                <button type="submit" class="continue-btn w-full text-center py-2 f-17" style=""> &nbsp;
                                    Request Service <i class="fa-solid fa-arrow-right arrows"></i>
                                </button>


                            </form>

                        @else

                            <a href="{{ route('apply', ['discipline_id' => $discipline->identifier]) }}"
                                class="apply-btn w-full text-center py-2 f-17"
                                style="text-decoration: none; color: whitesmoke"> &nbsp;
                                Request Service <i class="fa-solid fa-arrow-right arrows"></i>
                            </a>
                        @endif

                    </div>
                    @if(!is_null($discipline->website_link))
                        <div class="mt-3 p-0 d-flex justify-content-center ">
                            <a href="{{ route('link.payment', ['app' => $discipline->identifier]) }}">Request
                                Application Link</a>
                        </div>
                    @endif

                    @include('components.social-media')

                    <div class="mt-5">
                        <h5 class="text-muted">Comments</h5>
                        <div class="border mt-2 rounded p-3" style="border-radius: 10px">

                            <div class="overflow-y-auto" style="flex-grow: 1; margin: 0px;" id="replies-container">

                                @foreach ($comments as $comment)
                                    <div class="d-flex gap-3 border-bottom">
                                        <div class="w-full text-left">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="f-14" style="font-weight: 700">{{ $comment->user->names }}
                                                    </p>
                                                    <p class="text-muted f-12" style="margin-top: -15px">
                                                        {{ $comment->created_at }}
                                                    </p>
                                                </div>
                                            </div>
                                            <p class="f-14">{{ $comment->comment }}</p>
                                            <div class="mt-3 pl-3 d-flex align-items-start" style="padding-left: 20px;">
                                                @if(!empty($comment->replies))
                                                    <div class="w-full">
                                                        @foreach ($comment->replies as $reply)
                                                            <div class="d-flex gap-2 mb-3">
                                                                <div class="w-full text-left">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="">
                                                                            <p class="f-14" style="font-weight: 700">
                                                                                {{ $reply->user->names }}
                                                                            </p>
                                                                            <p class="text-muted f-12" style="margin-top: -18px">
                                                                                {{ $reply->user->role }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <p class="f-14" style="margin-top: -12px">{{ $reply->reply }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="chat-input-container bg-white">
                                @if(!auth('client')->user())
                                    <div class="text-center mt-3">
                                        <a href="{{ route('login') }}">Login to comment</a>
                                    </div>
                                @else
                                    <form action="{{ route('comment') }}" method="post" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="discipline_id" value="{{ $discipline->id }}"
                                            class="w-full">
                                        <input type="hidden" name="applicant_id" value="{{ Auth::guard('client')->user()->id }}"
                                            class="w-full">
                                        <div class="d-flex gap-3 mt-3 ">
                                            <textarea name="comment" rows="1" placeholder="Type your comment here..."
                                                class="chat-input w-full p-2" required></textarea>
                                            <button type="submit" class="cst-primary-btn px-4 py-1">Send</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <section class="freq-asked-questions-cstm mt-0 py-5">
                <h4 class="muted-text mb-4">Frequently Asked Questions (FAQs)</h4>

                @foreach($faqs as $faq)              
                    <div class="faq mb-2 w-full " style="border: 1px solid #d9d9d9">
                        <div class="question">
                            <h3 class="muted-text" style="font-weight: normal">{{ $faq->question }}</h3>

                            <svg width="15" height="10" viewBox="0 0 42 25">
                                <path d="M3 3L21 21L39 3" stroke="white" stroke-width="2" stroke-linecap="round" />
                            </svg>

                        </div>

                        <div class="answer text-muted">
                            <p>{{ $faq->answer }}</p>
                        </div>

                    </div>
                @endforeach

                <div class="mt-3">
                    <a href="{{ route('faq') }}" style="">Read more FAQs</a>
                </div>

            </section>



        </div>

    </div>
</div>
</div>

<!-- <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script> -->


<script>


    $(document).ready(function () {
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