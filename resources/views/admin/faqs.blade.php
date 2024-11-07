@section('title', 'FAQs')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">
    <div class="app-inner-layout__content">
                <div class="tab-content">
                <div>
                <div class="card">
                <div class="card-header-tab card-header py-3 d-flex">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                FAQs
                </div>
                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                <a class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary" data-toggle="modal" data-target="#newFaq">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">New FAQ</span>
                </a>
                </div>
                </div>

                <div class="card-body">


                <div class="">

                @foreach($faqs as $faq)    
                    <div class="faq mb-2" style="">
                        <div class="question">
                            <h4>{{ $faq -> question }}</h4>

                            <div class="d-flex align-items-center gap-3">
                            <svg width="15" height="10" viewBox="0 0 42 25">
                                <path d="M3 3L21 21L39 3" stroke="white" stroke-width="2" stroke-linecap="round"/>
                            </svg>

                            <a data-id="{{ $faq -> id }}" data-faq="{{ $faq -> question }}" data-answer="{{ $faq -> answer }}" class="requestInfo underline text-sm hover:text-gray-600 dark:hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"  data-toggle="modal" data-target="#seek">
                                {{ __('Edit') }}
                            </a>

                            <a class="underline text-sm hover:text-gray-600 dark:hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ Auth::user() ? route('delete-faq', ['id' => $faq -> id]) : route('md.delete-faq', ['id' => $faq -> id]) }}">
                                {{ __('Delete') }}
                            </a>

                            </div>

                        </div>

                        <div style="border-top: 1px solid #a6a6a6" class="answer">
                            <p>{{ $faq -> answer }}</p>
                        </div>

                    </div>
                @endforeach

                </div>

        </div>
    </div>
            
    </div>
    </div>
    </div>
</div>
</div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="seek" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" style="text-align: left" id="staticBackdropLabel"></h5>
                            </div>                            

                            <button type="button" class="close btn btn-danger" style="border: 3px solid;" data-dismiss="modal" aria-label="Close">
                                <span style="color: #000" aria-hidden="true" class="fa fa-times"></span>
                            </button>

                        </div>
                        
                        <form action="{{ Auth::user() ? route('edit-faq') : route('md.edit-faq') }}" method="post" class="space-y-2" >   @csrf                     

                        <div class="modal-body">
                        
                          <input hidden style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px" name="faq" id="faq" class="block mt-1 w-full input-holder faq-id"/>

                          <div class="w-full">
                          <textarea rows="1" id="question-input" name="question" class="block w-full" style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required ></textarea>                          
                          </div>

                        <div class="mt-3 w-full">
                            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Answer')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Detailed answer</p>
                            <textarea rows="5" id="answer-input" name="answer" class="block w-full" style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required ></textarea>                          
                          <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                        </div>

                        <div class="mt-4 mb-2 text-right d-flex justify-content-end">
                            <button type="submit" id="send_btn" style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase" class="btn apply-btn">Save changes</button>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- </> modal -->



  <!-- Modal -->
  <div class="modal fade" id="newFaq" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" style="text-align: left" id="staticBackdropLabel">Post new FAQ</h5>
                            </div>                            

                            <button type="button" class="close btn btn-danger" style="border: 3px solid;" data-dismiss="modal" aria-label="Close">
                                <span style="color: #000" aria-hidden="true" class="fa fa-times"></span>
                            </button>

                        </div>
                        
                        <form action="{{ Auth::user() ? route('post-faq') : route('md.post-faq') }}" method="post" class="space-y-2" >   @csrf                     

                        <div class="modal-body">
                        

                          <div class="w-full">
                          <textarea placeholder="Type question here..." rows="1" id="question-input" name="question" class="block w-full" style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required ></textarea>                          
                          </div>

                        <div class="mt-3 w-full">
                            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Answer')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Detailed answer</p>
                            <textarea placeholder="Type answer here..." rows="5" id="answer-input" name="answer" class="block w-full" style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required ></textarea>                          
                          <x-input-error :messages="$errors->get('answer')" class="mt-2" />
                        </div>

                        <div class="mt-4 mb-2 text-right d-flex justify-content-end">
                            <button type="submit" id="send_btn" style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase" class="btn apply-btn">Post FAQ</button>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- </> modal -->

<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>

<script>

const faqs = document.querySelectorAll(".faq");

faqs.forEach((faq) => {
    faq.addEventListener("click", () => {
        faq.classList.toggle("active");
    })
});


$(document).ready(function () {
    $(document).on('click', '.requestInfo', function () {
        $('.modal-title').html($(this).attr('data-faq'));
        $('.faq-id').val($(this).attr('data-id'));
        $('#question-input').val($(this).attr('data-faq'));
        $('#answer-input').val($(this).attr('data-answer'));
    });
});

</script> 

</x-app-layout>

