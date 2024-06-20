@section('title', 'Dashboard')

<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">
                
                <div class="app-inner-layout__content">
                <div class="tab-content">
                <div>
                <div class="card">
                <div class="card-header-tab card-header py-3 d-flex">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                Working progress 
                </div>
                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                <a href="{{ route('admin.org') }}" style="font-weight: 600; border: 1.3px solid" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm sd-btn">
                Active Employees: {{ number_format($active_emp -> active) }}
                </a>
                </div>
                </div>
                <div class="no-gutters flex-section justify-content-between px-2 py-3">
                <!-- <div class="col-sm-6 col-md-4 col-xl-4">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #ec6c55bd;">
                <i class="fa-solid fa-person-booth" style="font-size: 25px"></i></div></div>
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Prospects</div>
                <div class="widget-numbers">{{ number_format(count($userRequests)) }}</div>
                <div class="widget-description opacity-8 text-focus">
                <div class="d-inline text-danger pr-1">
                </div> 
                Pending customers
                </div>
                </div>
                </div> 
                </div> 
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div> -->
                <div class="col-sm-6 col-md-4 col-xl-4">
                <div style="border: none"  class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #5AB8A4;">
                <i class="fa-solid fa-people-group" style="font-size: 25px"></i></div></div>
                <div style="" class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Customers</div>
                <div class="widget-numbers"><span>{{ number_format(count($readyCustomers)) }}</span></div>
                <div class="widget-description opacity-8 text-focus">
                Ready to be served
                <span class="text-info pl-1">
                <!-- <i class="fa fa-angle-down"></i>
                <span class="pl-1">14.1%</span> -->
                </span>
                </div>
                </div>
                </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex justify-content-end">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #80ffaa;">
                <i class="fa-solid fa-person-circle-check" style="font-size: 25px"></i></div>
                </div>
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Clients</div>
                <div class="widget-numbers text-success"><span>{{ number_format(count($servedCustomers)) }}</span></div>
                <div class="widget-description text-focus">
                Served customers
                <span class="text-warning pl-1">
                <!-- <i class="fa fa-angle-up"></i>
                <span class="pl-1">7.35%</span> -->
                </span>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="text-center d-block p-3 card-footer">
                <a href="{{ route('admin.revenue') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">Navigate to Revenue</span>
                </a>
                </div>
                </div>
        </div>
    </div>
    </div>
    </div>
      
      
      
      
     @if($requested_delete->isNotEmpty())
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    <strong style="color: red">Delete Requests</strong> 
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    </div>
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">


  <table class="table align-middle mb-0 bg-white" id="example1">
  <thead class="bg-light">
    <tr>
      <th>Applicant Info</th>
      <th>Application Info</th>
      <th>Deleted On</th>
      <th>Deleted By</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($requested_delete as $debtor)
    
    @php
      $deleted_by = DB::table('staff') -> where('id', $debtor -> revied_by) -> first();
    @endphp
    
    <tr>
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="" style="padding: 0px 5px">
            <p class="fw-bold mb-1">{{ $debtor -> names }}</p>
            <p class="text-muted mb-0">{{ $debtor -> email }} <br> {{ $debtor -> phone_number }}</p>
          </div>
        </div>
      </td>
      
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="" style="padding: 0px 5px">
            <p class="fw-bold mb-1">{{ $debtor -> discipline_name }}</p>
            <p class="text-muted mb-0">{{ $debtor -> discipline_organization }} - {{ $debtor -> discipline_country }}</p>
          </div>
        </div>
      </td> 
      
      <td>
        <p class="fw-normal mb-1"><strong>{{ $debtor -> deleted_on }}</strong></p>
      </td>
      
      <td>
        <div class="d-flex align-items-center" style="margin: 0px">
          <div class="" style="padding: 0px 5px">
            <small class="mb-1">{{ $deleted_by -> names }}</small>
          </div>
        </div>
      </td> 
      
      <td class="text-center">
        <div class="w-full">
          <a style="color: black" href="{{ route('assess', ['customer_info' => $debtor -> id, 'application_info' => $debtor -> application_id]) }}" class="container d-flex align-items-center justify-content-center" style="padding: 5px; border-radius: 5px">
            <div class="continue-app d-flex align-items-center justify-content-center p-1" style="">
                <div class="staff-resume-btn-1">ASSESS</div>
            </div>
          </a>
        </div>
	  </td>
    </tr>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="top: 100px">
            <div class="modal-header">
                <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Record Payment</h1></strong>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"><i style="font-size: 24px; color: ghostwhite; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">

              <div class="d-flex items-center justify-center p-0" style="">

              <form action="{{ route('mark-debtor-as-paid') }}" method="post"> @csrf
                <input type="text" name="app_id" class="test" required hidden>
                <button href="" style="color: black" class="ml-4 complete-payment mark-paid">Complete Payment</button>
              </form>       

              <button id="partialBtn" style="color: black" class="ml-4 complete-payment">
                  {{ __('Partial Payment') }}
              </button>

              <button style="color: black" class="ml-4 complete-payment undo">
                  {{ __('Undo') }}
              </button>

            </div>


            <div id="partialDeptPayment" class="mt-3">
              <form action="{{ route('mark-partial-payment') }}" method="POST" class="mt-3">
              @csrf
                <div class="" style="width: 75%; margin: auto">
                    <x-input-label for="link" :value="__('How much have you received?')" />
                    <input type="text" name="app_id" class="test" required hidden>
                    <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="amountReceived" class="block mt-1 w-full" type="text" name="amountReceived" :value="(amountReceived)" placeholder="Enter amount you have received" autocomplete="amountReceived" required/>
                    <x-input-error :messages="$errors->get('amountReceived')" class="mt-2" />
                </div>

                <div class="modal-footer d-flex align-items-center justify-content-center mt-3"> 
                  <button type="submit" class="btn btn-secondary bg-danger" style="border: none; color: ghostwhite; font-weight: bold; text-transform: uppercase; font-size: 13px; ">Record Payment</button>
                </div>
            </form>

            </div>

            </div>
            
            </div>

        </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="top: 100px">
            <div class="modal-header">
                <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Record Payment</h1></strong>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"><i style="font-size: 24px; color: ghostwhite; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body pt-0" style="border-top: 0.01em solid #ddd">

              <div class="d-flex items-center justify-center p-0" style="">

              <form action="{{ route('mark-as-greed') }}" method="POST" class="">
              @csrf
                <div class="" style="">
                    <input type="text" name="app_id" class="debtor" required hidden>
                </div>

                <div class="d-flex align-items-center justify-content-center mt-3 mr-3"> 
                  <button type="submit" class="btn complete-payment" style="border: 2px solid #000; color: #000; font-weight: bold; text-transform: uppercase; font-size: 13px; ">Mark As Greed</button>
                </div>
              </form>

              <form action="{{ route('remind-to-pay') }}" method="POST" class="">
              @csrf
                <div class="" style="">
                    <input type="text" name="app_id" class="debtor" required hidden>
                </div>

                <div class="d-flex align-items-center justify-content-center mt-3 ml-3"> 
                  <button type="submit" class="btn complete-payment" style="border: 2px solid #000; color: #000; font-weight: bold; text-transform: uppercase; font-size: 13px; ">Remind To Pay</button>
                </div>
              </form>

            </div>
            </div>
            
            </div>

        </div>
        </div>

    @endforeach

  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
@endif


      
      
      
      

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-6">
                    Applications 
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-6">

                    <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('admin.requests') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    View clients requests
                    </a>

                    <a href="{{ route('admin.new-application') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">New application</span>
                </a>

                    </div>
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <table id="example1" class="table align-middle mb-0 bg-white">
  <thead class="bg-light">
    <tr>
      <th>Application</th>
      <th>Category</th>
      <th>Country</th>
      <th class="text-center">Price</th>
      <th class="text-center">Actions</th>
    </tr>
  </thead>
  <tbody>

  @foreach($applications as $discipline)
    <tr>
      <td>
        <div class="d-flex align-items-center">
          <div class="">
            <p class="fw-bold mb-1">{{ $discipline -> discipline_name }}</p>
            <p class="text-muted mb-0" style="font-size: 13px">{{ $discipline -> organization }}</p>
          </div>
        </div>
      </td>
      <td>
        <p class="fw-normal mb-1">{{ $discipline -> category }}</p>
      </td>

      <td>
        <p class="fw-normal mb-1">{{ $discipline -> country }}</p>
      </td>

      <td class="text-center">
        <p class="fw-normal mb-1">{{ $discipline -> service_fee }}</p>
      </td>

      <td class="text-center">
      <a href="{{ route('admin.app-info', ['identifier' => $discipline -> identifier]) }}" style="border: 2px solid; border-radius: 100px; padding: 2px 10px" class="btn btn-link btn-sm btn-rounded mr-1">
      <i class="fa-solid fa-info"></i>
            </a>
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

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    Assistance requests 
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    </div>
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <table class="table align-middle mb-0 bg-white">
                      <thead class="bg-light">

                      <tr>
                          <th>Client</th>
                          <th>Issue</th>
                          <th>Issue Description</th>
                          <th class="text-left">Received on</th>
                          <th class="text-center">Action</th>
                        </tr>

                      </thead>
                      <tbody>

                      @foreach($requests as $request)

                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              
                              <div class="">
                                <p class="fw-bold mb-1">{{ $request -> names }}</p>
                                <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> names }}</p>
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
                        
                        <form action="{{ route('request-reply') }}" method="post" class="space-y-2" >   @csrf                     

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

                  const send_reply = document.getElementById('send_reply');

                  send_reply.addEventListener('change', function() {
                    if (send_reply.checked) {
                      document.getElementById('send_btn').textContent = 'SAVE AND SEND REPLY';
                    }

                    else {
                      document.getElementById('send_btn').textContent = 'SAVE REPLY';
                    }
                  });

                </script>
    
</x-app-layout>
