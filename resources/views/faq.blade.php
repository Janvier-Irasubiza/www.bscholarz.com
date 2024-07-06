@extends ('layouts.bbg-layout')

@section('title', 'FAQs')

@section('content')

<div class="body-content" style="background-color: #F8FAFF">
<div class="bscholars-desc p-0">

    <div class="container-fluid pt-2 px-4 py-2" style="background-color: #F8FAFF">
        <div class="d-flex justify-content-center px-5 py-2">
            <div class="col-lg-10 bg-white px-3 py-3" style="border-radius: 7px">
                <div class="pb-5" id="list-item-1" data-offset="100">
                <section class="freq-asked-questions mt-4">
				<h2 class="d-flex align-items-center mb-5" style="color: #1E4682; padding: 0px; height: 25px">Frequently Asked Questions (FAQs)</h2>

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

					<div class="mt-4">
                      Not helpful? &nbsp; <a href="#" data-toggle="modal" data-target="#seek" style="">Ask your question</a>
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

$(document).ready(function(){ 
    $('.sidebar-drawer').toggleClass('hide');
});


let section = document.querySelectorAll('list-example');
let navLinks = document.querySelectorAll('abt-sect-desc');

window.onScroll = () => {
    
    section.forEach(sec =>{

        let top = window.scrollY;
        let offset = sec.offsetTop;
        let height = sec.offsetHeight;
        let id = sec.getAttribute('id');

        if(top >= offset && top < offset + height){
            navLinks.forEach(links =>{
                links.classList.remove('active');
                document.querySelector('list-example[href*=' + id + ']').classList.add('active');
            });
        }

    });

}

</script>

@stop