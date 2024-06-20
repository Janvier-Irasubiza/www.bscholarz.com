@section('title', 'Customer - Details')

<x-staff-layout>

<x-slot name="header">
</slot>

<div style="padding: 20px 32px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2">

    <div class="card">

    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
        <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-9" style="">
          <strong>{{ $application_requested -> discipline_name }} - Pre-Deletion Assessmemnt</strong>
        </div>
      
      	<div class="col-lg-4 d-flex justify-content-start" style="">
          <div class="">
            <a href="{{ route('recover', ['application_id' => $application_requested -> application_id]) }}" class="ml-4 postpone-btn bg-success" style="color: black">
              RECOVER
            </a>
          </div>
          
          <div>
            <a href="{{ route('confirm-d', ['application_id' => $application_requested -> application_id]) }}" class="ml-4 postpone-btn" style="color: black">
              DELETE
            </a>
          </div>
      	</div>
    </div>
<div class="card-body">

<div class="apply-form" style="">


<form method="POST" action="{{ route('client-profile-update') }}" enctype="multipart/form-data">
@csrf

    <div class="acc-details-other" style="">
    <div class="d-flex justify-content-center align-items-center mb-4 pt-0 py-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151)">
    
        <div class="personal-info col-lg-12" style="">
        
        <div class="row" style="">
            <div class="small-8 medium-2 large-2 columns col-lg-2 pt-2" style="height: 145px">
                <div class="circle">
                @if(!is_null($client_info -> profile_picture))
                <img id="uploadPreview" class="profile-pic" src="{{ asset('profile_pictures') }}/{{ $client_info -> profile_picture }}">
                @else
                <img id="uploadPreview" class="profile-pic" src="{{ asset('profile_pictures') }}/profileee.png">
                @endif
                </div>
            </div>

            <div class="col-lg-5 d-flex align-items-center" style="height: auto">
            @if($all_details->isNotEmpty())
            <a href="{{ route('debtor-details', ['debtor_info' => $client_info -> id]) }}" class="debt-status" style="color: #000; text-transform: uppercase; font-weight: bold">
                Unpaid Applications
            </a>
            @endif
            </div>

            <div class="col-lg-5 info-hold-details" style="">

            <div style="">

            <div style=""><strong><h1 style="font-size: 30px; display: flex; justify-content: right">{{ $client_info -> names }}</h1></strong></div>
                <div style="font-size: 19px; display: flex; justify-content: right"><h5>{{ $client_info -> email }}</h5></div>
                <div style="font-size: 18px; display: flex; justify-content: right"><h5>{{ $client_info -> phone_number }}</h5></div>
                <div class="mt-3" style="font-size: 18px; display: flex; justify-content: right; align-items:center"><div style="border: 2px solid #d9d9d9; border-radius: 4px; display: flex; align-items: center" class="px-1">Requested on: &nbsp; <h5>{{ $application_requested  -> requested_on }}</h5></div></div>
            </div>
            </div>

        </div>

        </div>

    </div>

    <div class="d-flex gap-3">
        <div class="col-lg-7">

        <!-- Personal -->
        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Personal Info')" />
        <div class="info-div mt-3 mb-4">
            
        <div>
            <x-input-label for="names" :value="__('Names')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" hidden id="names" class="block mt-1 w-full input-holder" type="text" name="old_pp" value="{{ $client_info -> profile_picture }}" disabled/>
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="names" class="block mt-1 w-full input-holder" type="text" name="names" value="{{ $client_info -> names }}" placeholder="Full name" autofocus autocomplete="names" disabled/>
            <x-input-error :messages="$errors->get('names')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Email')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $client_info -> email }}" placeholder="username@example.com" autocomplete="email" disabled/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="d-flex gap-3">
        <div class="col-lg-5 mt-3">
            <x-input-label for="phone_number" :value="__('Phone number')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" value="{{ $client_info -> phone_number }}" placeholder="Your phone number" autocomplete="phone_number" disabled/>
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="col-lg-4 mt-3">
        <x-input-label for="birth_date" :value="__('Date of birth')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="birth_date" class="block mt-1 w-full" type="date" name="birth_date" value="{{ $client_info -> dob }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" autocomplete="birth_date" disabled/>
            <x-input-error :messages="$errors->get('birth_date')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-3 col-lg-3" style="padding: 0px 32px 0px 0px;">
        <x-input-label for="gender" value="Gender" />
            <select id="gender" class="block mt-1 w-full" style=" border: 2px solid #4d4d4d; border-radius: 6px; padding: 5px 10px" name="gender"
                         autocomplete="gender" disabled>

                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            </select>

            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

            </div>
        </div>
        <!-- end of personal -->

        <!-- Parent's Info -->
        <x-input-label style="font-size: 17px; font-weight: 600" for="p_info" :value="__('Parents Info')" />
        <div class="info-div mt-3 mb-4">

        <x-input-label for="f_info" :value="__('Father Info')" />
        <div class="d-flex gap-3 mb-3">
              <!-- Name -->
        <div class="col-lg-5">
        <small class="text-semi-muted mb-0">Full name</small>
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="father_name" class="block mt-1 w-full" type="text" name="father_name" value="{{ $client_info -> father_names }}" placeholder="Full name" autofocus autocomplete="father_name" disabled/>
            <x-input-error :messages="$errors->get('father_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="col-lg-4">
        <small class="text-semi-muted mb-0">Email</small>
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="faher_email" class="block mt-1 w-full" type="email" name="faher_email" value="{{ $client_info -> father_email }}" placeholder="username@example.com" autocomplete="faher_email" disabled/>
            <x-input-error :messages="$errors->get('faher_email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="">
        <small class="text-semi-muted mb-0">Phone number</small>
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="father_phone" class="block mt-1 w-full" value="{{ $client_info -> father_phone }}"
                            type="text"
                            name="father_phone"
                            placeholder="Phone number"
                            autocomplete="father_phone" disabled/>

            <x-input-error :messages="$errors->get('father_phone')" class="mt-2" />
        </div>
        </div>

        <x-input-label for="m_info" :value="__('Mother Info')" />
        <div class="d-flex gap-3 mb-4">

        <!-- Name -->
        <div class="col-lg-5">
        <small class="text-semi-muted mb-0">Full name</small>
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="mother_name" class="block mt-1 w-full" type="text" name="mother_name" value="{{ $client_info -> mother_names }}" placeholder="Full name" autofocus autocomplete="mother_name" disabled/>
            <x-input-error :messages="$errors->get('mother_name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="col-lg-4">
        <small class="text-semi-muted mb-0">Email</small>
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="mother_email" class="block mt-1 w-full" type="email" name="mother_email" value="{{ $client_info -> mother_email }}" placeholder="username@example.com" autocomplete="mother_email" disabled/>
            <x-input-error :messages="$errors->get('mother_email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="">
        <small class="text-semi-muted mb-0">Phone number</small>
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="mother_phone" class="block mt-1 w-full" value="{{ $client_info -> mother_phone }}"
                            type="text"
                            name="mother_phone"
                            placeholder="Phone number"
                            autocomplete="mother_phone" disabled/>

            <x-input-error :messages="$errors->get('mother_phone')" class="mt-2" />
        </div>
        </div>

        <div class="d-flex gap-3">

        <!-- Name -->
        <div class="col-lg-5">

        <x-input-label for="name" :value="__('Are both your parents alive?')" />
            <div class="d-flex gap-3">
                <div class="mt-2">
                <label for="remember_me" class="inline-flex items-center">
                    @if($client_info -> parents_alive == 'yes')
                <input id="yes" type="radio" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="alive" value="yes" style="border-radius: 4px; border: 1.5px solid #505050" checked disabled>
                @else
                <input id="yes" type="radio" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="alive" value="yes" style="border-radius: 4px; border: 1.5px solid #505050" disabled>
                @endif
                 <span class="ml-2 text-sm">{{ __('Yes') }}</span>
            </label>
                </div>

                <div class="mt-2">
                <label for="remember_me" class="inline-flex items-center">
                @if($client_info -> parents_alive == 'no')
                <input style="color: #808080; border-radius: 6px" id="no" type="radio" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="alive" value="no" style="border-radius: 4px; border: 1.5px solid #505050" checked disabled>
                @else
                <input style="color: #808080; border-radius: 6px" id="no" type="radio" class="shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="alive" value="no" style="border-radius: 4px; border: 1.5px solid #505050" disabled>
                @endif
                <span class="ml-2 text-sm">{{ __('No') }}</span>
            </label>
                </div>

            </div>
        </div>

        <!-- Email Address -->
        <div class="col-lg-7" style="padding: 0px 20px 0px 0px">
        <x-input-label for="guardian" :value="__(' If no, who is alive')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="guardian" class="block mt-1 w-full" type="text" name="guardian" value="{{ $client_info -> guardian }}" placeholder="your answer here" autocomplete="guardian" disabled/>
            <x-input-error :messages="$errors->get('guardian')" class="mt-2" />
        </div>
        </div>
        </div>
        <!-- End of Parents -->

        <!-- Address -->
        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Address Info')" />
        <div class="info-div mt-3 mb-3">

        <!-- Password -->
        <div class="d-flex gap-3">
            <div class="">
            <x-input-label for="country" :value="__('Country')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="country" class="block mt-1 w-full" type="text" name="country" value="{{ $client_info -> country }}" placeholder="your country" autocomplete="country" disabled/>
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
            </div>

            <div class="">
            <x-input-label for="province" :value="__('Province')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="province" class="block mt-1 w-full" type="text" name="province" value="{{ $client_info -> province }}" placeholder="Your province" autocomplete="province" disabled/>
            <x-input-error :messages="$errors->get('province')" class="mt-2" />
            </div>

            <div class="">
            <x-input-label for="city" :value="__('City')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="city" class="block mt-1 w-full" type="text" name="city" value="{{ $client_info -> city }}" placeholder="Your city" autocomplete="city" disabled/>
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
            </div>
            
        </div>
        </div>

        @if(!is_null($applications_items -> username))


        <!-- Personal -->
        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Applicant Credentials')" />
        <div class="info-div mt-3 mb-4">
            
        <div>
            <x-input-label for="names" :value="__('Username/Email/Phone Number')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="names" class="block mt-1 w-full input-holder" type="email" name="email" value="{{ $applications_items -> username }}" placeholder="Email or username" autofocus autocomplete="email" disabled/>
            <x-input-error :messages="$errors->get('names')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Password')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="password" class="block mt-1 w-full" type="text" name="password" value="{{ $applications_items -> password }}" placeholder="username@example.com" autocomplete="password" disabled/>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Link to the dashboard')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="email" class="block mt-1 w-full" type="text" name="link" value="{{ $applications_items -> link_to_dashboard }}" placeholder="username@example.com" autocomplete="email" disabled/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-input-label for="reason" :value="__('Reason for postponing')" />
            <textarea style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="reason" class="block mt-1 w-full" type="text" name="reason" autocomplete="reason" disabled>{{ $applications_items -> postponing_reason }}</textarea>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        </div>
        <!-- end of personal -->


        @endif


        <!-- End of Address -->       
        </div>

        <div class="col-lg-5 px-3">
        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Academic Background')" />
        <div class="info-div mt-3 mb-4">
        
        @foreach($client_background as $background)
        <div class="mb-4" id="backSection">
        
            <!-- Name -->
        <div class="inner-info-div">
        <div>
            <x-input-label for="education_level" :value="__('Level of education')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="education_level" class="block mt-1 w-full" type="text" name="education_level[]" value="{{ $background -> education_level }}" placeholder="Current Level of education" autofocus autocomplete="education_level" disabled/>
            <x-input-error :messages="$errors->get('education_level[]')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-3">
            <x-input-label for="email" :value="__('Institution or School')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="institution" class="block mt-1 w-full" type="text" name="institution[]" value="{{ $background -> institution }}" placeholder="Institution or school name" autocomplete="institution" disabled/>
            <x-input-error :messages="$errors->get('institution[]')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-3">
        <x-input-label for="phone_number" :value="__('Achievement date')" />
            <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="graduation_date" class="block mt-1 w-full" type="date" style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080" name="graduation_date[]" value="{{ $background -> graduation_date }}" placeholder="Your phone number" autocomplete="graduation_date" disabled/>
            <x-input-error :messages="$errors->get('graduation_date[]')" class="mt-2" />
        </div>
        </div>
        
        </div>
        @endforeach

        <div class="new-back-sections"></div>

        <div class="mt-3 text-right">
        
        </div>
        </div>

        <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Supporting Documents')" />
        <div class="info-div mt-3 mb-4">
           
        <div>
            <x-input-label style="font-size: 15px" for="name" :value="__('Client supporting documents')" />
            @foreach($client_docs as $doc)
            <div class="d-flex gap-1 mt-2" style="">
            <a href="{{ asset('documents') }}/{{ $doc -> document }}">{{ $doc -> document }}</a>
                    <!-- <input type="file" id="uploadFile" class="col-lg-11 upload-file" onchange="exc();" name="document[]"> -->
                <x-input-error style="color: darkred; list-style: none" :messages="$errors->get('document')"/>
            </div>
            @endforeach

      <div class="new-files-wrapper"></div>
      
        </div>

        </div>
        </div>

        
        </div>

        <div class="flex items-center justify-end mt-5">
			<?php /*
          	{--
            @if(!is_null($applications_items -> username))

            <a target="blanck" id="startApp" href="{{ route('resume-postponed-application', ['application_info' => $application_requested -> application_id]) }}" style="color: black" class="ml-4 apply-btn">
                {{ __('Resume Application') }}
            </a>
          
          	<div class="d-flex justify-content-end">
              
             <a id="completeApp" href="{{ route('mark-application-complete', ['application_id' => $application_requested -> application_id]) }}" style="color: black; display: none" class="ml-4 mark-as-btn">Mark as Complete</a>
          
          	 <a href="{{ route('staff-dashboard') }}" class="ml-4 postpone-btn" style="color: black">
                Cancel
            </a>
              
              </div>
          
            @else

            <button type="button" class="ml-4 postpone-btn" data-bs-toggle="modal" data-bs-target="#exampleModal" style="color: black">
                {{ __('Postpone Application') }}
            </button>

            @if($applications_items -> status == 'In Progress')
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal1" style="color: black" class="ml-4 mark-as-btn">Mark as Complete</button>
            @else

            <a id="completeApp" href="{{ route('mark-application-complete', ['application_id' => $application_requested -> application_id]) }}" style="color: black; display: none" class="ml-4 mark-as-btn">Mark as Complete</a>

            <a target="blanck" id="startApp" href="{{ route('begin-application', ['application_info' => $application_requested -> application_id]) }}" style="color: black" class="ml-4 apply-btn">
                {{ __('Start Application') }}
            </a>
            @endif
            @endif
          --}
            */ ?>
        </div>
        
        </form>
  		


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form action="{{ route('postponed-data', ['application_id' => $application_requested -> application_id]) }}" method="POST">
        @csrf
            <div class="modal-content" style="border: 1px solid red; top: 100px">
            <div class="modal-header">
                <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Postpone Application</h1></strong>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"><i style="font-size: 24px; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">

                <div class="">
                    <x-input-label for="username" :value="__('Client Username/Email')" />
                    <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="username" class="block mt-1 w-full" type="text" name="username" :value="(username)" placeholder="Enter username, email or phone number" autocomplete="username" required/>
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div class="mt-3">
                    <x-input-label for="password" :value="__('Client Password')" />
                    <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="password" class="block mt-1 w-full" type="text" name="password" :value="(password)" placeholder="Enter client password" autocomplete="password" required/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-3">
                    <x-input-label for="link" :value="__('The link to your current state')" />
                    <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="link" class="block mt-1 w-full" type="text" name="link" :value="(link)" placeholder="Paste the link here" autocomplete="link" required/>
                    <x-input-error :messages="$errors->get('link')" class="mt-2" />
                </div>

                <div class="mt-3">
                    <x-input-label for="reason" :value="__('Reason for postponing')" />
                    <textarea style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="reason" class="block mt-1 w-full" type="text" name="reason" :value="reason" placeholder="Describe the reason you are postponing this" autocomplete="reason" required></textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border: 2px solid #000; color: #000; font-weight: bold">Cancel</button>
                <button type="button submit" class="btn btn-secondary bg-danger" style="border: none; color: #000; font-weight: bold">Postpone</button>
            </div>
            </div>
        </form>

        </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form action="{{ route('completed-app-data', ['application_id' => $application_requested -> application_id]) }}" method="POST">
        @csrf
            <div class="modal-content" style="border: 1px solid red; top: 100px">
            <div class="modal-header">
                <strong><h1 style="font-size: 14px" class="modal-title fs-5" id="exampleModalLabel">Complete Application</h1></strong>
                <button type="button" class="btn-close bg-danger" data-bs-dismiss="modal" aria-label="Close"><i style="font-size: 24px; margin-left: 0px; margin-top: -10px" class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">

                <div class="">
                    <x-input-label for="link" :value="__('Client Username/Email')" />
                    <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="username" class="block mt-1 w-full" type="text" name="username" :value="(username)" placeholder="Enter username, email or phone number" autocomplete="username" required/>
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div class="mt-3">
                    <x-input-label for="link" :value="__('Client Password')" />
                    <input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="password" class="block mt-1 w-full" type="text" name="password" :value="(password)" placeholder="Enter client password" autocomplete="password" required/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-3">
                    <x-input-label for="reason" :value="__('Observation')" />
                    <textarea style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="reason" class="block mt-1 w-full" type="text" name="observation" :value="observation" placeholder="Observation" autocomplete="observation"></textarea>
                    <x-input-error :messages="$errors->get('observation')" class="mt-2" />
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border: 2px solid #000; color: #000; font-weight: bold">Cancel</button>
                <button type="button submit" class="btn btn-secondary bg-danger" style="border: none; color: #000; font-weight: bold">Complete</button>
            </div>
            </div>
        </form>

        </div>
        </div>


</div>

</div>
</div>
</div>
</div>


<script>

    const startApp = document.getElementById('startApp');

    startApp.addEventListener('click', function() {
        document.getElementById('completeApp').style.display = 'block';
      startApp.style.display = 'none';
    });

</script>

</x-app-layout>
