@section('title', 'Application info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

    <div class="container-fluid">
    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    {{ $app_info -> discipline_name }} </br>
                    <small class="text-muted mb-0">{{ $app_info -> organization }}</small>
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-danger"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <small><span class="fa fa-trash"></span></small> &nbsp;
                <span class="mr-1">Delete</span>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="margin-left: auto; margin-right: 16em;">
                    <div class="modal-content">
                    <div class="text-center p-3"  style="border-bottom: 1px solid #e6e6e6">
                        <p class="m-0" style="font-size: 18px;">Delete <strong>{{ $app_info -> discipline_name }}</strong> <small>of</small> <strong>{{ $app_info -> organization }}</strong></p>
                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    </div>
                    <div class="modal-body text-center">
                    Are you sure you want to delete this application? </br>

                    <div class="mt-3 mb-2" style="border-radius: 5px; ">
                    <i class="fa-solid fa-triangle-exclamation btn btn-danger" style="font-size: 16px; padding: 7px 10px 10px 10px"></i> &nbsp; Remember that this action can not be undone
                    </div>

                    </div>
                    <div class="p-3 text-center" style="border-top: 1px solid #e6e6e6">
                       <button type="button" class="btn apply-btn" data-bs-dismiss="modal" style="padding: 3px 20px; color: ghostwhite">Cancel</button>
                        <a href="{{ route('admin.delete-app', ['app_id' => $app_info -> id]) }}" class="ml-2 btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-danger">
                        <span class="mr-2 opacity-7">
                        <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                        </span>
                        <small><span class="fa fa-trash"></span></small> &nbsp;
                        <span class="mr-1">Yes, Delete</span>
                        </a>
                       </div>

                    </div>
                </div>
                </div>
                    <!-- End of modal -->

                    </div>
                    </div>
                    
    <form method="post" action="{{ route('admin.edit-app') }}" class="mt-6 space-y-6 mt-4 mb-3"  enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="app_name" :value="__('Application Name')" />
            <small class="text-muted mb-0">Degree level to be attained, Position, or any other title to be gained</small>
            <x-text-input id="app_id" hidden style="border: 1px solid rgba(0, 0, 0, 0.192)" name="app_id" type="text" class="mt-1 block w-full" value="{{ $app_info -> id }}" required  autocomplete="app_name" />
            <x-text-input id="app_name" style="border: 1px solid rgba(0, 0, 0, 0.192)" name="app_name" type="text" class="mt-1 block w-full" value="{{ $app_info -> discipline_name }}" required  autocomplete="app_name" />
            <x-input-error class="mt-2" :messages="$errors->get('app_name')" />
        </div>

        <div>
            <x-input-label for="org" :value="__('Organization')" />
            <small class="text-muted mb-0">University, Country, or any other organization offering the application</small>
            <x-text-input id="org" name="org" style="border: 1px solid rgba(0, 0, 0, 0.192)" type="text" class="mt-1 block w-full" value="{{ $app_info -> organization }}" required autocomplete="org" />
            <x-input-error class="mt-2" :messages="$errors->get('org')" />
        </div>

        <div class="" style="">
        <x-input-label for="category" :value="__('Category')" />
        <small class="text-muted mb-0">Scholarship, Job, Training or other opportunity</small>
          
         <select id="category" class="block mt-1 w-full" style=" border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px; padding: 5px 10px" name="category"
                            required autocomplete="category">
           
         @if($app_info -> category == 'Scholarship')
          
           <option value="Scholarship" selected>Scholarship</option>
           <option value="Study Loan">Study Loan</option>
           <option value="Job">Job</option>
           <option value="Fellowship">Fellowship</option>
           <option value="Training">Training</option>
           
           @elseif($app_info -> category == 'Study Loan')
          
           <option value="Scholarship">Scholarship</option>
           <option value="Study Loan" selected>Study Loan</option>
           <option value="Job">Job</option>
           <option value="Fellowship">Fellowship</option>
           <option value="Training">Training</option>
           
           @elseif($app_info -> category == 'Job')
           
           <option value="Scholarship">Scholarship</option>
           <option value="Study Loan">Study Loan</option>
           <option value="Job" selected>Job</option>
           <option value="Fellowship">Fellowship</option>
           <option value="Training">Training</option>
           
           @elseif($app_info -> category == 'Fellowship')
           
           <option value="Scholarship">Scholarship</option>
           <option value="Study Loan">Study Loan</option>
           <option value="Job">Job</option>
           <option value="Fellowship" selected>Fellowship</option>
           <option value="Training">Training</option>
           
           @elseif($app_info -> category == 'Training')
           
           <option value="Scholarship">Scholarship</option>
           <option value="Study Loan">Study Loan</option>
           <option value="Job">Job</option>
           <option value="Fellowship">Fellowship</option>
           <option value="Training" selected>Training</option>
           
           @else
           
           <option value="Scholarship">Scholarship</option>
           <option value="Study Loan">Study Loan</option>
           <option value="Job">Job</option>
           <option value="Fellowship">Fellowship</option>
           <option value="Training">Training</option>
           
           @endif
          
           </select>
          
        <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <div class="" style="">
        <x-input-label for="mode" :value="__('Mode')" />
        <small class="text-muted mb-0">Mode of attendance - Remote, phyisical or blended</small>
          
          <select id="mode" class="block mt-1 w-full" style="border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px; padding: 5px 10px" name="mode"
                            required autocomplete="mode">

            @if($app_info -> mode == 'Physical')
            
            <option value="Physical" selected>Physical</option>
            <option value="Remote">Remote</option>
            <option value="Blended">Blended</option>
            
            @elseif($app_info -> mode == 'Remote')
            
            <option value="Physical">Physical</option>
            <option value="Remote" selected>Remote</option>
            <option value="Blended">Blended</option>
            
            @elseif($app_info -> mode == 'Blended')
            
            <option value="Physical">Physical</option>
            <option value="Remote">Remote</option>
            <option value="Blended" selected>Blended</option>
            
            @else
            
            <option value="Physical">Physical</option>
            <option value="Remote">Remote</option>
            <option value="Blended">Blended</option>
            
            @endif
            
          </select>
          
        <x-input-error :messages="$errors->get('mode')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="country" :value="__('Country')" />
            <small class="text-muted mb-0">Destination country</small>
            <x-text-input id="country" style="border: 1px solid rgba(0, 0, 0, 0.192)" name="country" type="text" class="mt-1 block w-full" value="{{ $app_info -> country }}" required autocomplete="country" />
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <div>
            <x-input-label for="requirements" :value="__('Requirements')" />
            <small class="text-muted mb-0">Application Requirements</small>
            <textarea rows="4" id="requirements" style="border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px" name="requirements" class="mt-1 block w-full" style="border: 2px solid #000; border-radius: 6px" required autocomplete="requirements"> {{ $app_info -> requirements }} </textarea>
            <x-input-error class="mt-2" :messages="$errors->get('requirements')" />
        </div>

        <div>
            <x-input-label for="benefits" :value="__('Benefits')" />
            <small class="text-muted mb-0">What are benefits for the applications</small>
            <textarea rows="4" id="benefits"style="border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px"  name="benefits" class="mt-1 block w-full" style="border: 2px solid #000; border-radius: 6px" required autocomplete="benefits"> {{ $app_info -> includes }} </textarea>
            <x-input-error class="mt-2" :messages="$errors->get('benefits')" />
        </div>

        <div>
            <x-input-label for="desc" :value="__('Short Description')" />
            <small class="text-muted mb-0">Short description of the application</small>
            <textarea rows="10" id="short_desc" style="border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px" name="short_desc" class="mt-1 block w-full" style="border: 2px solid #000; border-radius: 6px" required autocomplete="short_desc"> {{ $app_info -> discipline_desc }} </textarea>
            <x-input-error class="mt-2" :messages="$errors->get('short_desc')" />
        </div>
      
      <div>
            <x-input-label for="desc" :value="__('Description')" />
            <small class="text-muted mb-0">Detailed description of the application</small>
            <div class="w-full" style="border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px;">
            <textarea rows="10" id="desc" name="desc" class="textarea mt-1 block w-full" value="" required autocomplete="desc">{!! $app_info -> discipline_detailed_desc !!}</textarea>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('desc')" />
        </div>

        <div class="" style="">
        <x-input-label for="status" :value="__('Status')" />
        <small class="text-muted mb-0">Available, comming soon, ending soon, or ended</small>
          
          <select id="status" class="block mt-1 w-full" style="border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px; padding: 5px 10px" name="status"
                            required autocomplete="status">

            @if($app_info -> status == 'Available')
            
            <option value="Available" selected>Available</option>
            <option value="Comming soon">Comming soon</option>
            <option value="Ending soon">Ending soon</option>
            <option value="Ended">Ended</option>
            
            @elseif($app_info -> status == 'Comming soon')
            
            <option value="Available">Available</option>
            <option value="Comming soon" selected>Comming soon</option>
            <option value="Ending soon">Ending soon</option>
            <option value="Ended">Ended</option>
            
            @elseif($app_info -> status == 'Ending soon')
            
            <option value="Available">Available</option>
            <option value="Comming soon">Comming soon</option>
            <option value="Ending soon" selected>Ending soon</option>
            <option value="Ended">Ended</option>
            
            @eleseif($app_info -> status == 'Ended')
            
            <option value="Available">Available</option>
            <option value="Comming soon">Comming soon</option>
            <option value="Ending soon">Ending soon</option>
            <option value="Ended" selected>Ended</option>
            
            @else
            
            <option value="Available">Available</option>
            <option value="Comming soon">Comming soon</option>
            <option value="Ending soon">Ending soon</option>
            <option value="Ended">Ended</option>
            
            @endif
            
          </select>
          
        <x-input-error :messages="$errors->get('status')" class="mt-2" />
        </div>

        <div class="" style="">
        <x-input-label for="specialty" :value="__('Specialty')" />
        <small class="text-muted mb-0">Carousel, Trendings, or General</small>
          
          <select id="specialty" class="block mt-1 w-full" style="border: 1px solid rgba(0, 0, 0, 0.192); border-radius: 6px; padding: 5px 10px" name="specialty"
                  required autocomplete="specialty">
            
            @if($app_info -> speciality == 'General')

            <option value="General" selected>General</option>
            <option value="Trendings">Trendings</option>
            <option value="Carousel">Carousel</option>
            
            @elseif($app_info -> speciality == 'Trendings')
            
            <option value="General">General</option>
            <option value="Trendings" selected>Trendings</option>
            <option value="Carousel">Carousel</option>
            
            @elseif($app_info -> speciality == 'Carousel')
            
            <option value="General">General</option>
            <option value="Trendings">Trendings</option>
            <option value="Carousel" selected>Carousel</option>
            
            @else
            
            <option value="General">General</option>
            <option value="Trendings">Trendings</option>
            <option value="Carousel" selected>Carousel</option>
            
            @endif

          </select>

        <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
        </div>

        <div class="">
        <x-input-label for="due_date" :value="__('Due Date')" />
            <x-text-input id="due_date" style="border: 1px solid rgba(0, 0, 0, 0.192); color: #000" class="block mt-1 w-full" type="datetime-local" name="due_date" value="{{ $app_info -> due_date }}" required autocomplete="due_date" />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="price" :value="__('Service fee')" />
            <small class="text-muted mb-0">Application price</small>
            <x-text-input id="price" style="border: 1px solid rgba(0, 0, 0, 0.192)" name="price" type="text" class="mt-1 block w-full" value="{{ $app_info -> service_fee }}" required  autocomplete="price" />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>
      
      	<div>
            <x-input-label for="link" :value="__('Link')" />
            <small class="text-muted mb-0">Link to application platform</small>
            <x-text-input id="link" name="link" type="text" class="mt-1 block w-full" value="{{ $app_info -> link }}" required autocomplete="link" style="border: 1px solid rgba(0, 0, 0, 0.192)" />
            <x-input-error class="mt-2" :messages="$errors->get('link')" />
        </div>

        <div>
            <x-input-label for="link" :value="__('Institution Link')" />
            <small class="text-muted mb-0">Link to the Institution</small>
            <x-text-input id="link" name="link_to_institution" type="text" class="mt-1 block w-full" value="{{ $app_info -> website_link }}" required autocomplete="link_to_institution" style="border: 1px solid rgba(0, 0, 0, 0.192)" />
            <x-input-error class="mt-2" :messages="$errors->get('link_to_institution')" />
        </div>

        <div>
            <x-input-label style="font-size: 15px" for="name" :value="__('Poster')" />
            <small class="text-semi-muted mb-0">Application Poster</small></br>
            <input type="text" hidden value="{{ $app_info -> poster }}" class="text-left" name="old_poster" >
            <div class="d-flex gap-1 mt-2">

        <div class="div" tsyle="position: relative">
        <div style="width: 200px; height: 100px;" class="d-flex">
        <img class="img-responsive" style="max-width: 100%; max-height: 100%; border-radius: 6px;" id="uploadPreview" src="{{ asset('images') }}/{{ $app_info -> poster }}" alt="User">
        <input type="file" id="uploadImage" class="text-left" onchange="PreviewFile(event);" name="poster" style="padding: 3.3%; position: absolute; bottom: 6.3em; width: 14.8%; left: 3.2em; right: auto; border: 1px solid red; right: 0px; opacity: 0" >
        </div>
   
    <x-input-error style="color: darkred; list-style: none" :messages="$errors->get('poster')"/>
      </div>
        </div>
      </div>

        <div class="flex items-center gap-4">
        <x-primary-button class="apply-btn" style="border: none">
                {{ __('save changes') }}
            </x-primary-button>
        </div>
    </form>
    </div>

    <script>
          const removeFileBtn = document.getElementById("removeFile");

          function PreviewFile(event){
            if(event.target.files.length > 0){
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("uploadPreview");
                preview.src = src;
            }
            }

            function removeFileShow() {
                removeFileBtn.style.display = "block";
            };

            function removeFileFun () {
                document.getElementById("uploadFile").value = null;
                document.getElementById("uploadPreview").value = "Select Document";
                removeFileBtn.style.display = "none";
            }

            function exc() {
            removeFileShow()
            }
    </script>


    </div>
</div>

</x-app-layout>