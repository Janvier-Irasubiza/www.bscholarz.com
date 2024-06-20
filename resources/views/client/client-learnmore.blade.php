
@section('title', 'Application overview')

@section('content')

<x-client-layout>

<x-slot name="header">
</slot>

<div class="client-body pb-1">


            <div class="mb-5">
    @foreach($disciplines as $discipline)

        <div class="trends-summary">
        <div class="overflow-hidden">
        <div class="flex-section justify-content-center"  style="">

            <div class="col-lg-10 cstm-learn-desc-hold" style="">
                <div class="" style="align-items: center">
                    <div class="text-center pb-2" style="border-bottom: 1px solid #0000002d">
                        <strong><h2 style="font-size: 22px">{{ $discipline -> discipline_name }}</h2></strong>
                    </div>
                <div class="mb-3 mt-4">
                    {!! $discipline -> discipline_detailed_desc !!}
                </div>

                <div class="mb-3">
                    <strong>Ends: </strong> {{ $discipline -> due_date }} <br>
                    <strong>Started: </strong> {{ $discipline -> publish_date }} <br>
                </div>

                <div class="container">
                    <div class="row" style="">
                        <div class="col-lg p-1 d-flex align-items-center gap-1" style="border: 1px solid #0000002d; border-radius: 5px">

                        @php 
                            $included = explode(',', $discipline -> includes);

                            $required = explode(',', $discipline -> requirements);
                        @endphp 

                            <strong>Benefits:</strong>
                            <div class="" style="padding: 0px; overflow: auto; white-space: nowrap;">
                    <div class="d-flex gap-1" style="padding: 0px; margin: 0px; width: fit-content">

                        @foreach($included as $item)
                        
                      	<div style="width: fit-content; padding: 0px; margin: auto;">
                      	
                          <div class="includes mb-1" style=""> 
                            <span> {{ $item }} <i style="font-size: 13px" class="fa-regular fa-circle-check"></i> </span>
                        </div>
                          
                      	</div>
                        
                        @endforeach
                        </div>
                    </div> 
                        </div>
                    </div>

                    <div class="row mt-2" style="">
                <div class="col-lg p-1 pb-0 flex-section align-items-center gap-1" style="border: 1px solid #0000002d; border-radius: 5px">

                <strong>Requirements:</strong>
                <div class="container-fluid testimonial-group" style="padding: 0px; overflow: auto; white-space: nowrap;">
                    <div class="row text-center gap-1" style="padding: 0px; margin: 0px; width: fit-content">

                        @foreach($required as $item)
                        
                      	<div style="width: auto; padding: 0px; margin: auto;">
                      	
                          <div class="includes mb-1" style=""> 
                            {{ $item }} <i style="font-size: 13px" class="fa-regular fa-circle-check"></i>
                        </div>
                          
                      	</div>
                        
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>

                    

                    <div class="row pt-4">
                        <div class="col-lg d-flex justify-content-center gap-3" style="">
                        
                        @if(Auth::guard('client') -> user())
                          
                          <form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data"> @csrf
                                  
                            <input id="application_info" class="block mt-1 w-full" type="text" name="application_info" value="{{ $discipline -> id }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="application_info" hidden/>

                            <button class="apply-btn b-link">Request Service</button>

                          </form>

                        @else

                        <a href="{{ route('apply', ['discipline_id' => $discipline -> identifier]) }}" class="learn-apply" style="text-decoration: none; color: black">
                            Request Service <i class="fa-solid fa-arrow-right arrows"></i>
                        </a>

                        @endif


                        </div>
                    </div>

                </div>

                </div>
            </div>


            <div class="social-media-sct">
                <div class="d-block d-flex align-items-center justify-content-center">
                    <ul class="mt-2" style="; padding: 5px 0px 0px 10px">
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Join Our Whatsapp Community" target="blanc" href="https://whatsapp.com/channel/0029Va9WKPW7YSd1Ur3bYr12"><span class="fa-brands fa-whatsapp"></span></a> </li>
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Telegram" target="blanc" href="https://t.me/+AIWsTcgPUUwxMjc8"><span class="fa-brands fa-telegram"></span></a></li>
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Twitter" target="blanc" href="https://twitter.com/Bscholarz"><span class="fa-brands fa-twitter"></span></a></li>
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Instagram" target="blanc" href="https://www.instagram.com/bscholarz/"><span class="fa-brands fa-instagram"></span></a></li>
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On LinkedIn" target="blanc" href="https://linkedin.com/in/bscholar-z-414307299/"><span class="fa-brands fa-linkedin"></span></a></li>
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us Via Google Mail" target="blanc" href="https://mail.google.com/mail/?view=cm&fs=1&to=info@bscholarz.com"><span class="fa-brands fa-google"></span></a></li>
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Visit Our Youtube Channel" target="blanc" href="https://www.youtube.com/channel/UCx1ohaAVRC0UPaVcEDK0qwA"><span class="fa-brands fa-youtube"></span></a></li>
                        <li class="social-media-icon" style="display: block"><a class="sm-link" data-toggle="tooltip" data-bs-placement="top" title="Connect With Us On Facebook" target="blanc" href="https://www.facebook.com/BSCHOLARZ"><span class="fa-brands fa-facebook"></span></a></li> 
                    </ul>   
                </div>
            </div>
            
        </div>

        </div>
        </div>
    @endforeach
    </div>



 <!--   <section class="freq-asked-questions px-4 mt-0 mb-5">
        <h4>Frequently Asked Questions (FAQs)</h4>

            @foreach($faqs as $faq)    
            <div class="faq" style="">
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

        </section> -->
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

</x-client-layout>
