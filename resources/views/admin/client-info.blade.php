@section('title', 'Client Info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px" class="mb-4">
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 mb-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-5">
                    {{ $request_info -> names }}  <br>
                    <p class="text-muted mb-0">{{ $request_info -> email }} </p>
                    <p class="text-muted mb-0">{{ $request_info -> phone_number }} </p>

                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-7">


                    </div>
                    </div>
                    <div style="border-top: none" class="d-block p-3 card-footer">

                <div class="d-flex gap-3">
                    <div class="col-lg-7">
                    @csrf

                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Personal Info')" />
                    <div class="info-div mt-3 mb-4">
                        <!-- Name -->
                    <div>
                        <x-input-label for="names" :value="__('Names')" />
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> names }} </div>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-3">
                        <x-input-label for="email" :value="__('Email')" />
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> email }} </div>
                    </div>

                    <!-- Password -->
                    <div class="d-flex gap-3">
                    <div class="col-lg-5 mt-3">
                        <x-input-label for="phone_number" :value="__('Phone number')" />
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> phone_number }} </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-4 mt-3">
                    <x-input-label for="birth_date" :value="__('Date of birth')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> dob }} </div>
                    </div>

                    <!-- Password -->
                    <div class="mt-3 col-lg-3" style="padding: 0px 32px 0px 0px;">
                    <x-input-label for="gender" :value="__('Gender')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> gender }} </div>
                    </div>

                        </div>
                    </div>

                    <x-input-label style="font-size: 17px; font-weight: 600" for="p_info" :value="__('Parents Info')" />
                    <div class="info-div mt-3 mb-4">

                    <x-input-label for="f_info" :value="__('Father Info')" />
                    <div class="d-flex gap-3 mb-3">
                        <!-- Name -->
                    <div class="col-lg-5">
                    <small class="text-semi-muted mb-0">Full name</small>
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> father_names }} </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-4">
                    <small class="text-semi-muted mb-0">Email</small>
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> father_email }}</div>
                    </div>

                    <!-- Password -->
                    <div class="">
                    <small class="text-semi-muted mb-0">Phone number</small>
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> father_phone }}</div>
                    </div>
                    </div>

                    <x-input-label for="m_info" :value="__('Mother Info')" />
                    <div class="d-flex gap-3 mb-4">
                        <!-- Name -->
                    <div class="col-lg-5">
                    <small class="text-semi-muted mb-0">Full name</small>
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> mother_names }}</div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-4">
                    <small class="text-semi-muted mb-0">Email</small>
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> mother_email }}</div>
                    </div>

                    <!-- Password -->
                    <div class="">
                    <small class="text-semi-muted mb-0">Phone number</small>
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> mother_phone }}</div>
                    </div>
                    </div>

                    <div class="d-flex gap-3">
                        <!-- Name -->
                    <div class="col-lg-5">

                    <x-input-label for="name" :value="__('Are both your parents alive?')" />
                        <div class="d-flex gap-3">
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> parents_alive }}</div>

                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-7" style="padding: 0px 20px 0px 0px">
                    <x-input-label for="guardian" :value="__(' If no, who is alive')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> guardian }}</div>
                    </div>
                    </div>
                    </div>

                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Address Info')" />
                    <div class="info-div mt-3 mb-3">


                    <div class="d-flex gap-3">
                    <div class="col-lg-4 mt-3">
                        <x-input-label for="phone_number" :value="__('Country')" />
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> country }}</div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-4 mt-3">
                    <x-input-label for="birth_date" :value="__('Province')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> province }}</div>
                    </div>

                    <!-- Password -->
                    <div class="mt-3 col-lg-4" style="padding: 0px 32px 0px 0px;">
                    <x-input-label for="gender" :value="__('City')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> city }}</div>
                    </div>

                        </div>
                    </div>

                    

                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Academic Background')" />
                    <div class="info-div mt-3 mb-4">

                    <div class="mb-4" id="backSection">
                        <!-- Name -->
                    

                        @foreach($edu_info as $level)

                        <div class="inner-info-div">
                    <div>
                        <x-input-label for="education_level" :value="__('Level of education')" />
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $level -> education_level }}</div>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-3">
                        <x-input-label for="email" :value="__('From which institution or School')" />
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $level -> institution }}</div>
                    </div>

                    <!-- Password -->
                    <div class="mt-3">
                    <x-input-label for="phone_number" :value="__('Graduatioon date')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $level -> graduation_date }}</div>
                    </div>
                    </div>

                        @endforeach

                    </div>

                    </div>

                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Supporting Documents')" />
                    <div class="info-div mt-3 mb-4">
                    
                    <div>
                    <x-input-label style="font-size: 15px" for="name" :value="__('Upload your document')" />
                    <small class="text-semi-muted mb-0">ID card, Transcripts, and your CV</small>

                    @foreach($client_documnent as $document)
                    <a href="{{ asset('documents') }}/{{ $document -> document }}"><div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $document -> document }}</div></a>
                    @endforeach
                
                    </div>
                    </div>


                
                    </div>

                    <div class="col-lg-5 px-3">
            

                    @if($clientApps->isNotEmpty())
                    <div class="d-flex gap-2 mb-0"> 
                        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Applications')" class="mb-0" /> - <span style="color: ghostwhite; padding: 0px 20px 2px 20px; border-radius: 20px; font-weight: 600; font-size: 17px" class="bg-success mb-0"><small>Served</small></span></div>
                    <div class="info-div mt-3 mb-4">
                    


                    <!-- Application -->

                    <div>
                            <div class="adds-card" style="">
                            
                                <div class="container-fluid testimonial-group">
                                <div class="py-2" style="padding: 0px; margin: 0px">
                                    
                                @foreach($clientApps as $app)

                                <div class="application-hold px-2 mb-2">

                                    <div class="mb-2" style="font-size: 19px">
                                    <strong>{{ substr($app -> discipline_name, 0, 20) }}... (<small><strong>{{ $app -> discipline_country }}</strong></small>)</strong><br>

                                    <p class="text-muted mb-0 mt-0" style="font-size: 13px">Request on: {{ $app -> requested_on }}</p>
                                    <p class="text-muted mb-0 mt-0" style="font-size: 13px">Assisted on: {{ $app -> served_on }} by {{ $app -> assistant_names}}</p>
                                    <p class="text-muted mb-0 mt-0" style="font-size: 13px">Amount paid: {{ number_format($app -> amount_paid) }} <small>RWF</small></p>

                                </div>
                                    <small class="status-btn" style="border: 1px solid #ddd; padding: 5px 10px; border-radius: 10px; font-size: 14px">{{ $app -> application_status }}</small>

                                </div>

                                @endforeach

                                    </small>
                                    </div>

                                </div>
                            </div>

                    </div>

                </div>

                @endif



                @if($clientAppsRequests->isNotEmpty())
                <div class="d-flex gap-2 mb-0"> <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Applications')" class="mb-0" /> - <span style="color: ghostwhite; padding: 0px 20px 2px 20px; border-radius: 20px; font-weight: 600; font-size: 15px" class="bg-warning mb-0"><small>Not Yet Served</small></span></div>
                    <div class="info-div mt-3 mb-3">
                    


                    <!-- Application -->

                    <div>
                            <div class="adds-card" style="">
                            
                                <div class="container-fluid testimonial-group">
                                <div class="py-2" style="padding: 0px; margin: 0px">
                                    
                                @foreach($clientAppsRequests as $app)

                                <div class="application-hold px-2 mb-2">

                                    <div class="mb-2" style="font-size: 19px">
                                    <strong>{{ substr($app -> discipline_name, 0, 20) }}... (<small><strong>{{ $app -> discipline_country }}</strong></small>)</strong><br>

                                    <p class="text-muted mb-0 mt-0" style="font-size: 13px">Requested on: {{ $app -> requested_on }}</p>
                                    <p class="text-muted mb-0 mt-0" style="font-size: 13px">Amount paid: {{ number_format($app -> amount_paid) }} <small>RWF</small></p>

                                </div>

                                @if($app -> application_status == 'Complete')
                                <p class="fw-normal mb-1">
                                <span class="badge bg-success rounded-pill px-3">{{ $app -> application_status }}</span>
                                </p>

                                @elseif($app -> application_status == 'In progress')

                                <p class="fw-normal mb-1">
                                <span class="badge bg-warning rounded-pill px-3">{{ $app -> application_status }}</span>
                                </p>

                                @elseif($app -> application_status == 'Postponed')

                                <p class="fw-normal mb-1">
                                <span class="badge bg-danger rounded-pill px-3">{{ $app -> application_status }}</span>
                                </p>

                                @else
                                <p class="fw-normal mb-1">
                                <span class="badge bg-secondary rounded-pill px-3">{{ $app -> application_status }}</span>
                                </p>
                                @endif
                                </div>

                                @endforeach

                                    </small>
                                    </div>

                                </div>
                            </div>

                    </div>

                </div>

                @endif



                </div>


                    <!-- End of applications -->

                    
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

</x-app-layout>