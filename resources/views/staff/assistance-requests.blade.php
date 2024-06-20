@section('title', 'Assistance Requests')

<x-staff-layout>

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
                Assistance Requests
                </div>
                </div>

                <div class="card-body">

                <table class="table align-middle mb-0 bg-white">
                      <thead class="bg-light">

                      <tr>
                          <th>Client</th>
                          <th>Issue</th>
                          <th>Issue Description</th>
                          <th class="text-left">Received on</th>
                          <th class="text-center">Reply</th>
                        </tr>

                      </thead>
                      <tbody>

                      @foreach($requests as $request)

                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              
                              <div class="">
                                <p class="fw-bold mb-1">{{ $request -> names }}</p>
                                <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> email }}</p>
                                <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> phone_number }}</p>
                              </div>
                            </div>
                          </td>
                          <td>
                            <p class="fw-normal mb-1">{{ $request -> issue }}</p>
                          </td>

                          <td>
                          {{ $request -> issue_desc }}
                          </td>

                          <td class="text-left" >
                          <p class="text-muted mb-0">{{ $request -> posted_on }}</p>
                          </td>

                          <td class="text-center">
                          <a data-id="{{ $request -> id }}" data-names="{{ $request -> names }}" data-email="{{ $request -> email }}" data-phone="{{ $request -> phone_number }}" data-issue="{{ $request -> issue }}" data-desc="{{ $request -> issue_desc }}" style="border: 2px solid; border-radius: 100px; padding: 2px 10px" class="btn btn-link btn-sm btn-rounded mr-1 requestInfo" data-toggle="modal" data-target="#seek">
                            <i class="fa-solid fa-reply"></i>
                                </a>

                    <!-- Modal -->
                    <div class="modal fade" id="seek" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog w-mdal modal-dialog-centered d-flex align-items-center" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title" style="text-align: left" id="staticBackdropLabel"></h5>
                                <small style="font-size: 14px;" class="text-muted mb-0">From: <span class="names"></span> - <span class="email"></span> - <span class="phone-number"></span></small>
                            </div>                            

                            <button type="button" class="close btn btn-danger" style="border: 3px solid;" data-dismiss="modal" aria-label="Close">
                                <span style="color: #000" aria-hidden="true" class="fa fa-times"></span>
                            </button>

                        </div>
                        
                        <form action="{{ route('staff.request-reply') }}" method="post" class="space-y-2" >   @csrf                     

                        <div class="modal-body">
                        
                          <input hidden style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px" name="client_id" id="client_id" class="block mt-1 w-full input-holder client-id"/>

                        <div>
                          <x-input-label for="names" style="text-align: left" class="text-left w-full" :value="__('Issue description')" />
                          <div style="padding: 6px 10px; text-align: left; border: 1px solid #00000050; color: #808080; border-radius: 4px"  id="names" class="block mt-1 w-full input-holder" ><span style="font-size: 14px; font-weight: 500; color: #404040" class="issue-desc">{{ $request -> issue_desc }} </span></div>
                      </div>

                        <div class="mt-4 w-full">
                            <x-input-label for="issue" style="text-align: left" class="text-left w-full" :value="__('Reply')" />
                            <p style="font-size: 14px; text-align: left" class="text-muted mb-0 text-left w-full">Reply to the issue</p>
                            <textarea placeholder="Type reply here..." id="reply_input" name="reply" class="block w-full" style="border: 2px solid #000; border-radius: 6px; padding: 6px; font-size: 14px" required ></textarea>
                            <label for="remember_me" class="d-flex items-center justify-content-start mt-2">
                              <input id="send_reply" type="checkbox" value="send" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember" style="border-radius: 4px; border: 1.5px solid #505050">
                              <span class="text-sm ml-2">{{ __('Notify client with the reply') }}</span>
                          </label>                            
                          <x-input-error :messages="$errors->get('reply')" class="mt-2" />
                        </div>

                        <div class="mt-4 mb-2 text-right d-flex justify-content-end">
                            <button type="submit" id="send_btn" style="padding: 5px 30px; font-size: 13px; font-weight: 600; color: ghostwhite; text-transform: uppercase" class="btn apply-btn">Save reply</button>
                        </div>
                        </div>
                        </form>
                        </div>
                    </div>
                    </div>
                    <!-- </> modal -->



                          </td>
                          
                        </tr>

                        @endforeach
                      </tbody>
                    </table>



</div>
                </div>
               
        </div>
    </div>
    </div>
</div>
</div>
</div>

<script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>

<script>

  $(document).ready(function () {
    $(document).on('click', '.requestInfo', function () {
      $('.modal-title').html($(this).attr('data-issue'));
      $('.names').html($(this).attr('data-names'));
      $('.email').html($(this).attr('data-email'));
      $('.phone-number').html($(this).attr('data-phone'));
      $('.client-id').val($(this).attr('data-id'));
      $('.issue-desc').html($(this).attr('data-desc'));                      
      $('#reply-input').trigger('focus');
      });
  });

  </script>

</x-staff-layout>

