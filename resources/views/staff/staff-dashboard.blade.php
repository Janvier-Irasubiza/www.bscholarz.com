@section('title', 'Staff - Dashboard')


<x-staff-layout>
  
    <x-slot name="header">
    </x-slot>


    <div style="padding: 20px 32px">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">
                
                <div class="app-inner-layout__content">
                <div class="tab-content">
                <div>
                <div class="card">
                <div class="card-header-tab card-header py-3 d-flex align-items-center">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-4">
                <strong>My progress</strong> 
                </div>

                <div class="col-lg-4">

                @if(Session::has('success_msg'))

                <div class="alert alert-primary alert-dismissible pt-1 pb-1 px-2 fade show" role="alert">
                <div class='succ-msg py-0 d-flex gap-3 justify-content-between'>
                    <div class="text-success"><strong>{{Session::get('success_msg')}}</strong></div>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span style="font-size: 15px" class="fa fa-times" aria-hidden="true"></span>
                  </button>
                  </div>
                </div>

                  @php

                    Session::forget('success_msg');

                  @endphp

                  @endif
                </div>
    
                

                <div class="text-capitalize text-right col-lg-4 d-flex justify-content-end align-items-center gap-2">
                
                
                

                @if(Auth::guard('staff') -> user() -> working_status == 'Suspended')

                <button style="font-weight: 600; border: 1.3px solid; padding: 8px 10px" class="btn-wide btn-outline-2x mb-0 mr-md-2 btn btn-outline-focus btn-sm  alert alert-warning sd-btn">

                  You're currently suspended!

                </button>


                @else

              

                <button style="font-weight: 600; border: 1.3px solid" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm sd-btn">
                  Active Peers: {{ number_format($active_emp -> active) }}
                </button>

                <button data-bs-toggle="modal" data-bs-target="#createNewStudent" style="font-weight: 500; border: 1.3px solid; background-color: #5AB8A4; color: white" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm sd-btn">
                  Create New Client
                </button>

                @endif

                </div>



        <!-- Modal -->
        <div class="modal fade" id="createNewStudent" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content" style="top: 100px">
              <div class="modal-header">
                  <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Create New Client Account</h1></strong>
                  <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close" id="clodeModal"><i style="font-size: 24px; color: ghostwhite; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i></button>
              </div>
              <div class="modal-body pt-0" style="">
  
                <div class="d-flex items-center justify-center">

                <form method="POST" action="{{ route('staff-create-client') }}" class="w-full mt-3">
                  @csrf
          
                  <!-- Name -->
                  <div>
                      <x-input-label for="name" :value="__('Names')" />
                      <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" placeholder="Full name" required autofocus autocomplete="name" />
                      <x-input-error :messages="$errors->get('name')" class="mt-2" />
                  </div>
          
                  <!-- Email Address -->
                  <div class="mt-4">
                      <x-input-label for="email" :value="__('Email')" />
                      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" placeholder="username@example.com" required autocomplete="username" />
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
          
                  <!-- Password -->
                  <div class="mt-4">
                      <x-input-label for="password" :value="__('Password')" />
          
                      <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      placeholder="Create password"
                                      required autocomplete="new-password" />
          
                      <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>
          
                  <!-- Confirm Password -->
                  <div class="mt-4">
                      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
          
                      <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      placeholder="Confirm password"
                                      name="password_confirmation" required autocomplete="new-password" />
          
                      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                  </div>
          
                  <div class="flex items-center justify-center mt-4">
                      <x-primary-button class="ml-4 apply-btn">
                          {{ __('Create a client') }}
                      </x-primary-button>
                  </div>
              </form>
              
              </div>
              </div>
              
              </div>
  
          </div>
          </div>



                </div>
                <div class="no-gutters row px-2 py-3">
                <div class="col-sm-6 col-md-6 col-xl-6 d-flex justify-content-center" style="">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3 mr-5" style="background: #ec6c55bd;">
                <i class="fa-solid fa-list-check" style="font-size: 25px; padding: 0px 2px"></i></div></div>
                <div class="widget-chart-content col-lg-9 ml-4">
                <div class="widget-subheading">My Applications</div>
                <div class="widget-numbers">{{ number_format($my_applications) }}</div>
                <div class="widget-description opacity-8 text-focus">
                <div class="d-inline text-danger pr-1">
                <!-- <i class="fa fa-angle-down"></i>
                <span class="pl-1">54.1%</span> -->
                </div>
                Completed Applications
                </div>
                </div>
                </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
                <div class="col-sm-6 col-md-6 col-xl-6 d-flex justify-content-center" style="">
                <div style="border: none"  class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3 mr-5" style="background: #5AB8A4;">
                <i class="fa-solid fa-sack-dollar" style="font-size: 25px; padding: 0px 2px"></i></div></div>
                <div style="" class="widget-chart-content col-lg-9 ml-4">
                <div class="widget-subheading">My Funds ({{ $user_info -> percentage }}%)</div>
                <div class="widget-numbers"><span>{{ number_format($balance -> sum('assistant_pending_commission')) }} <small>Rwf</small></span></div>
                <div class="widget-description opacity-8 text-focus">
                <a href="{{ route('staff.disbursements', ['assistant' => Auth::guard('staff') -> user() -> id]) }}">View disbursements</a>
                <span class="text-info pl-1">
                <!-- <i class="fa fa-angle-down"></i>
                <span class="pl-1">14.1%</span> -->
                </span>
                </div>
                </div>
                </div>
                </div>
                </div>
             
    </div>
    </div>  

    @if(Auth::guard('staff') -> user() -> working_status != 'Suspended')

    <div style="padding: 20px 32px">
            <div class="overflow-hidden shadow-sm sm:rounded-lg p-2" style="">
    
    <div class="" style="padding: 0px; ">
        <div class="container" style="padding: 0px">
            <div class="d-flex" style="gap: 10px">
                <div class="col-lg-6 postponed-card">
                    <div class="mb-3">
                        <strong>Postponed Applications</strong>
                    </div>
                  
                  <form class="mb-2">
                    <input style = "border: 2px solid #4d4d4d; color: #000; border-radius: 5px" type="text" class="w-full" name="search" placeholder="Type here to search">
                    </form>

                    @if($postponed_applications->isNotEmpty())

                    @foreach($postponed_applications as $postponed)
                    @php
                    $applicant = DB::table('applicant_info') -> where('id', $postponed -> applicant) -> first();
                    $discipline = DB::table('disciplines') -> where('id', $postponed -> discipline_id) -> first()
                    @endphp
                    <div class="mb-4 client-info" style="">
                    <div class="container staff-client" style="">
                        <div class="row">
                            <div class="col-lg-6" style="padding: 5px 10px">
                                <strong><h1 style="font-size: 20px">{{ $applicant -> names }}</h1></strong>
                                <strong><small>{{ $applicant -> email }} <br> {{ $applicant -> phone_number }}</small></strong>
                            </div>

                            <div class="col-lg-6 client-pp d-flex align-items-center justify-content-center" style="">
                                <strong><h1 style="font-size: 16px">{{ $discipline -> discipline_name }}</h1></strong>
                            </div>
                        </div>
                    </div>

                    <div class="container d-flex align-items-center justify-content-center" style="padding: 5px; border-radius: 5px">
                        <div class="continue-app d-flex align-items-center justify-content-center" style="">
                            <a href="{{ route('mark-application-complete', ['application_id' => $postponed -> app_id]) }}" style="color: black" class="staff-resume-btn">Mark as Complete</a>
                            <a href="{{ route('reconsider-application', ['customer_info' => $postponed -> applicant, 'application_info' => $postponed -> app_id]) }}" style="color: black" class="staff-markas-btn">Resume Application</a>
                        </div>
                    </div>

                    </div>
                    @endforeach

                    @else

                    <div class="container-fluid testimonial-group">
                    <div class="row text-left gap-3" style="padding: 0px; margin: 0px">
                        <span style="font-size: 14px">You have no postponed applications</span>
                    </div>
                    </div>

                    @endif

                </div>


                <div class="col-lg-6 customers-card" style="">
                    <div class="mb-3">
                        <strong>Customers</strong>
                    </div>
                  
                  <form class="mb-2">
                    <input style = "border: 2px solid #4d4d4d; color: #000; border-radius: 5px" type="text" class="w-full" name="search" placeholder="Type here to search">
                    </form>

                    @if($ready_clients->isNotEmpty())

                    @foreach($ready_clients as $client)
                    @php
                    $client_info = DB::table('applicant_info') -> where('id', $client -> id) -> first();
                    $discipline = DB::table('disciplines') -> where('id', $client -> discipline) -> first();
                  	$reviewer = DB::table('staff') -> where('id', $client -> revied_by) -> first();
                    @endphp
                  
                  
                  	@if($client -> review_ccl == 'yes')
                  	<div class="mb-4 client-info-1" style="border: 3px solid #FAC898">
                      <div class="px-2 py-1 d-flex align-items-center">
                        <small style="font-weight: 500">Reviewed by: &nbsp </small><h5 style="font-weight: bold; font-size: 12px">{{ $reviewer -> names }}</h5>
                      </div>
                    <div class="container staff-client-1" style="">
                        <div class="row">
                            <div class="col-lg-6" style="padding: 5px 10px">
                                <strong><h1 style="font-size: 20px">{{ $client_info -> names }}</h1></strong>
                                <strong><small>{{ $client_info -> email }} <br> {{ $client_info -> phone_number }}</small></strong>
                            </div>

                            <div class="col-lg-6">
                              <div class="client-pp d-flex align-items-center justify-content-center" style="">
                                <strong><h1 style="font-size: 16px">{{ $discipline -> discipline_name }}</h1></strong>
                              
                            </div>
                          <div class="px-2">
                            <small><strong>{{ $client -> requested_on }} </strong> </small>
                            </div>
                              </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between py-2 px-4">

                    <a style="color: black" href="{{ route('customer-details', ['customer_info' => $client -> id, 'application_info' => $client -> application_id]) }}" class="staff-resume-btn-1" style="padding: 5px; border-radius: 5px">
                            Review request
                    </a>

                    <a href="#" class="ml-4 postpone-btn" style="color: black" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-application-id="{{ $client->application_id }}" data-service="{{ $discipline->discipline_name }}" data-client="{{ $client_info->names }}">
                      Delete
                    </a>
                   </div>

                    </div>
                  @endif
                  
                  	
                  	@if($client -> review_ccl != 'yes')
                    <div class="mb-4 client-info-1" style="">
                    <div class="container staff-client-1" style="">
                        <div class="row">
                            <div class="col-lg-6" style="padding: 5px 10px">
                                <strong><h1 style="font-size: 20px">{{ $client_info -> names }}</h1></strong>
                                <strong><small>{{ $client_info -> email }} <br> {{ $client_info -> phone_number }}</small></strong>
                            </div>

                             <div class="col-lg-6">
                              <div class="client-pp d-flex align-items-center justify-content-center" style="">
                                <strong><h1 style="font-size: 16px">{{ $discipline -> discipline_name }}</h1></strong>
                              
                            </div>
                          <div class="px-2">
                            <small><strong>{{ $client -> requested_on }} </strong></small>
                            </div>
                              </div>
                        </div>
                    </div>

                   <div class="d-flex justify-content-between py-2 px-4">

                    <a style="color: black" href="{{ route('customer-details', ['customer_info' => $client -> id, 'application_info' => $client -> application_id]) }}" class="staff-resume-btn-1" style="padding: 5px; border-radius: 5px">
                            Review request
                    </a>

                    <a href="#" class="ml-4 postpone-btn" style="color: black" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-application-id="{{ $client->application_id }}" data-service="{{ $discipline->discipline_name }}" data-client="{{ $client_info->names }}">
                      Delete
                    </a>
                   </div>

                    </div>
                  	@endif
                    @endforeach

                    <!-- Modal -->
                      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" style="margin-left: auto; margin-right: 16em;">
                              <div class="modal-content">
                                  <div class="p-3" style="border-bottom: 1px solid #e6e6e6">
                                      <p class="m-0" style="font-size: 18px;">Delete request</p>
                                  </div>
                                  <div class="modal-body">
                                      Are you sure you want to delete this application?
                                      <div class="mt-3">
                                          Service: <span id="service"></span><br>
                                          By: <span id="client"></span>
                                      </div>
                                      <div class="mt-3 mb-2" style="border-radius: 5px;">
                                          <i class="fa-solid fa-triangle-exclamation btn btn-danger" style="font-size: 16px; padding: 7px 10px;"></i>&nbsp; Remember that this action cannot be undone
                                      </div>
                                  </div>
                                  <div class="p-3 text-center" style="border-top: 1px solid #e6e6e6">
                                      <button type="button" class="btn apply-btn" data-bs-dismiss="modal" style="padding: 3px 20px; color: ghostwhite">Cancel</button>
                                      <a href="#" id="delete-link" class="ml-2 btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-danger">
                                          <span class="mr-2 opacity-7">
                                              <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                                          </span>
                                          <small><span class="fa fa-trash"></span></small>&nbsp;
                                          <span class="mr-1">Yes, Delete</span>
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <!-- End of modal -->


                      <!-- <toast> -->
                      <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header d-flex justify-content-between bg-secondary text-white">
                                    <strong class="mr-auto">Request deleted</strong>
                                    <small class="text-muted">just now</small>
                                </div>
                                <div class="toast-body">
                                    {{ session('delete_success') }}
                                </div>
                            </div>
                        </div>
                      <!-- </tast>  -->

                    @else

                    <div class="container-fluid testimonial-group">
                    <div class="row text-left gap-3" style="padding: 0px; margin: 0px">
                        <span style="font-size: 14px">No ready customers</span>
                    </div>
                    </div>

                    @endif
                    
                </div>


            </div>
        </div>
    </div>



    


    </div>

    @endif
      
      
          @if($under_review->isNotEmpty())
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    <strong>My Reviewed Clients</strong> 
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
      <th>Reviewed On</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($under_review as $debtor)
    
    @if($debtor -> deletion_status != 'Deletion Confirmed')
    <tr style="">
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

        <p class="fw-normal mb-1"><strong>{{ $debtor -> revied_on }}</strong></p>
      </td>
      <td class="text-center">
        <div class="w-full">
          <a style="color: black" href="{{ route('customer-details', ['customer_info' => $debtor -> id, 'application_info' => $debtor -> application_id]) }}" class="container d-flex align-items-center justify-content-center" style="padding: 5px; border-radius: 5px">
            <div class="continue-app d-flex align-items-center justify-content-center p-1" style="">
                <div class="staff-resume-btn-1">Re-Review</div>
            </div>
          </a>
        </div>
</td>
    </tr>
    
    @else
    
    <tr style="background: #ec6c55bd">
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

        <p class="fw-normal mb-1"><strong>{{ $debtor -> revied_on }}</strong></p>
      </td>
      <td class="text-center">
        <div class="w-full">
          <a style="color: black" href="{{ route('customer-details', ['customer_info' => $debtor -> id, 'application_info' => $debtor -> application_id]) }}" class="container d-flex align-items-center justify-content-center" style="padding: 5px; border-radius: 5px">
            <div class="continue-app d-flex align-items-center justify-content-center p-1" style="">
                <div class="staff-resume-btn-1">Re-Review</div>
            </div>
          </a>
        </div>
</td>
    </tr>
    
    @endif
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
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    <strong>Outstanding Clients</strong> 
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    @if(Auth::guard('staff') -> user() -> working_status != 'Suspended')

                    <a href="{{ route('record-activity') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                    <span class="mr-2 opacity-7">
                    <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                    </span>
                    <span class="mr-1">New record</span>
                    </a>

                    @endif

                    </div>
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

<table class="table align-middle mb-0 bg-white" id="example1">
  <thead class="bg-light">
    <tr>
      <th>Applicant Info</th>
      <th>Application Info</th>
      <th>Amount & Date</th>
      <th class="text-center">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($outstanding_clients as $debtor)

      @php

      $atdg_amt_exp = explode(';', $debtor -> outstanding_paid_amount);      

      $sum = 0;

        foreach ($atdg_amt_exp as $key => $value) {

            $number = explode('=>', $value);
            $sum += intval($number[0]);
            
        }

  @endphp


  @if($debtor -> outstanding_amount - $sum > 0)
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

        <p class="fw-normal mb-1"><strong>{{ number_format($debtor -> outstanding_amount - $sum) }}</strong> <br> {{ $debtor -> served_on }}</p>
      </td>
      <td class="text-center">
        <div class="d-flex align-items-center justify-content-center">
          <div class="action-btn mr-1">
            <button type="button" class="btn btn-link btn-sm btn-rounded action-btn debtorId" value="{{ $debtor -> application_id }}" data-bs-toggle="modal" data-bs-target="#exampleModal1"  style="text-decoration: none; background-color: #0D6EFD; color: white; border-radius: 20px;">
                Poke <i class="fa-solid fa-hand-point-right" style="transform: rotate(-45deg)"></i>
            </button>
          </div>

          <div class="action-btn ml-1">
            <button type="button" class="btn btn-link btn-sm btn-rounded clientId" value="{{ $debtor -> application_id }}" data-bs-toggle="modal" data-bs-target="#exampleModal" style="text-decoration: none; background-color: #80ffaa; color: black; border-radius: 20px;">
                Paid <i class="fa-regular fa-square-check" style=""></i>
            </button>
          </div>
        </div>
      </td>
    </tr>

    @endif
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


    </div>
    </div>
    </div>
    </div>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>

      $(document).ready(function() {
        $('.postpone-btn').click(function() {
            var service = $(this).data('service');
            var client = $(this).data('client');
            var applicationId = $(this).data('application-id'); 

            $('#service').text(service);
            $('#client').text(client);

            var applicationId = $(this).data('application-id');
            var deleteUrl = "{{ route('delete-request', ['application_id' => ':application_id']) }}";
            deleteUrl = deleteUrl.replace(':application_id', applicationId);
            $('#delete-link').attr('href', deleteUrl);
            console.log(deleteUrl);
        });
    });  
    
    let partialBtn = document.getElementById('partialBtn');

      partialBtn.addEventListener('click', function() {
        document.getElementById('partialDeptPayment').style.display="block";

        document.querySelector('.undo').style.display='block';
        document.getElementById('partialBtn').style.display='none';

      });

      document.querySelector('.undo').addEventListener('click', function () {
          document.getElementById('partialDeptPayment').style.display="none";
          document.getElementById('partialBtn').style.display='block';
          document.querySelector('.undo').style.display='none'

        });

        $(document).ready(function () {
            $(document).on('click', '.clientId', function () {
              $('.test').val($(this).val());
            });
          });

          $(document).ready(function () {
            $(document).on('click', '.debtorId', function () {
              $('.debtor').val($(this).val());
            });
          });

    </script>


</x-staff-layout>
