@section('title', 'User Requests')

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
                    {{ $request_info -> discipline_name }}  <br>
                    <p class="text-muted mb-0">{{ $request_info -> discipline_organization }} </p>

                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-7 d-flex flex-row-reverse">

                    <!-- <div class="ml-5">
                        @if(!($request_info -> application_status == 'Postponed') && !($request_info -> application_status == 'Complete'))

                        <a href="{{ route('postpone', ['request_id' => $request_info -> application_id]) }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn secondary-btn" style="color: ghostwhite; font-size: 13px; text-transform: capitalize">
                        <span class="mr-2 opacity-7">
                        <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                        </span>
                        <span class="mr-1">Postpone</span>
                        </a>

                        @endif

                        @if(!($request_info -> application_status == 'Complete'))

                        <a href="{{ route('complete', ['request_id' => $request_info -> application_id]) }}" style="font-weight: 500; border: 1.3px solid;" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 btn-primary"> <i class="fa-solid fa-check-double"></i> &nbsp; Mark as complete </a>

                        @endif
                    </div> -->

                    <div>
                    <a style="font-weight: 600; border: 1.3px solid;" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    {{ $request_info -> payment_status }} 
                    </a>

                    @if($request_info -> application_status == 'Pending')

                    <a style="font-weight: 600; border: none;" class="btn-wide bg-warning btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    {{ $request_info -> application_status }} 
                    </a>

                    @elseif($request_info -> application_status == 'In progress')

                    <a style="font-weight: 600; border: none; color: ghostwhite" class="btn-wide bg-info btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    {{ $request_info -> application_status }} 
                    </a>

                    @elseif($request_info -> application_status == 'Postponed')

                    <a style="font-weight: 600; border: none; color: ghostwhite" class="btn-wide bg-danger btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    {{ $request_info -> application_status }} 
                    </a>

                    @else

                    <a style="font-weight: 600; border: none; color: ghostwhite" class="btn-wide bg-success btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    {{ $request_info -> application_status }} 
                    </a>

                    @endif
                    </div>

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
                        <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> applicant_country }}</div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-4 mt-3">
                    <x-input-label for="birth_date" :value="__('Province')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> province }}</div>
                    </div>

                    <!-- Password -->
                    <div class="mt-3 col-lg-4" style="padding: 0px 32px 0px 0px;">
                    <x-input-label for="gender" :value="__('City')" />
                    <div style = "padding: 6px 10px; border: 1px solid #00000023; color: #808080; border-radius: 6px"  id="names" class="block mt-1 w-full input-holder" >{{ $request_info -> applicant_city }}</div>
                    </div>

                        </div>
                    </div>
                
                    </div>

                    <div class="col-lg-5 px-3">
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

                    <!-- @if($request_info -> application_status == 'Pending')

                    <a href="{{ route('app-apply', ['request_id' => $request_info -> application_id, 'applink' => $request_info -> link]) }}" target="blank" style="font-weight: 500; color: ghostwhite" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 apply-btn"> <i class="fa-solid fa-arrow-up-right-from-square"></i> &nbsp; Apply </a>

                    @elseif($request_info -> application_status == 'Postponed')

                    <a href="{{ route('app-apply', ['request_id' => $request_info -> application_id, 'applink' => $request_info -> link]) }}" target="blank" style="font-weight: 500; color: ghostwhite" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 apply-btn"> <i class="fa-solid fa-arrow-up-right-from-square"></i> &nbsp; Resume Application </a>
                    
                    @elseif($request_info -> application_status == 'Complete')

                    <a style="font-weight: 500; color: ghostwhite; display: none" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 apply-btn"> <i class="fa-solid fa-double-check"></i> &nbsp; Application Complete </a>

                    @else

                    <a style="font-weight: 500; color: ghostwhite" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 apply-btn"> <i class="fa-solid fa-arrow-up-right-from-square"></i> &nbsp; Application going on </a>
                    
                    @endif -->

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