@section('title', 'Application info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 100px 32px 100px;">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2 px-3">

    <div class="container-fluid">
    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192); padding: 0px 100px;">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    Publish new application
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    <a style="font-weight: 500; border: 1.3px solid;" href="{{ route('admin.applications') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    Go to applications
                    </a>

                    </div>
                    </div>

                    <div class="px-5">
                      
    <form method="post" action="{{ route('admin.post-new-app') }}" class="mt-6 px-5 space-y-6 mt-4 mb-3" enctype="multipart/form-data">
        @csrf
      
      @if(Session::has('failed'))
      
      	{{ Session::get('failed') }}
      
      	<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Oops! </strong> {{ Session::get('failed') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      
      @endif

        <div>
            <x-input-label for="app_name" :value="__('Application Name')" />
            <small class="text-muted mb-0">Application name</small>
            <x-text-input id="app_name" name="app_name" type="text" class="mt-1 block w-full" :value="old('app_name')" required autofocus autocomplete="app_name" />
            <x-input-error class="mt-2" :messages="$errors->get('app_name')" />
        </div>

        <div>
            <x-input-label for="org" :value="__('Organization')" />
            <small class="text-muted mb-0">University, Country, or any other organization offering the application</small>
            <x-text-input id="org" name="org" type="text" class="mt-1 block w-full" :value="old('org')" required autocomplete="org" />
            <x-input-error class="mt-2" :messages="$errors->get('org')" />
        </div>

        <div class="" style="">
        <x-input-label for="category" :value="__('Category')" />
        <small class="text-muted mb-0">Scholarship, Job, Training or other opportunity</small>
            <select id="category" class="block mt-1 w-full" style=" border: 2px solid #4d4d4d; border-radius: 6px; padding: 5px 10px" name="category"
                            required autocomplete="category">
              
              				@if(old('category'))
              					<option value="{{ old('category') }}">{{ old('category') }}</option>
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
            <select id="mode" class="block mt-1 w-full" style=" border: 2px solid #4d4d4d; border-radius: 6px; padding: 5px 10px" name="mode"
                            required autocomplete="mode">
              
              				@if(old('mode'))
                            	<option value="{{ old('mode') }}">{{ old('mode') }}</option>
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
            <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country')" required autocomplete="country" />
            <x-input-error class="mt-2" :messages="$errors->get('country')" />
        </div>

        <div>
            <x-input-label for="requirements" :value="__('Requirements')" />
            <small class="text-muted mb-0">Comma separeted Requirements</small>
            <textarea rows="4" id="requirements" name="requirements" class="mt-1 block w-full" style="border: 2px solid #000; border-radius: 6px" required autocomplete="requirements"> {{ old('requirements') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('requirements')" />
        </div>

        <div>
            <x-input-label for="benefits" :value="__('Benefits')" />
            <small class="text-muted mb-0">Enter comma separeted benefits</small>
            <textarea rows="4" id="benefits" name="benefits" class="mt-1 block w-full" style="border: 2px solid #000; border-radius: 6px"  required autocomplete="benefits"> {{ old('benefits') }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('benefits')" />
        </div>

        <div>
            <x-input-label for="short_desc" :value="__('Short Description')" />
            <small class="text-muted mb-0">Short description of the application</small>
            <textarea rows="5" id="word_count" name="short_desc" class="mt-1 block w-full" style="border: 2px solid #000; border-radius: 6px" required autocomplete="short_desc"> {{ old('short_desc') }} </textarea>
            <p class="mb-0 text-right">35 words max - <span id="count_left" style="font-size:16px; color:black;">35</span> words left.</span></p>
            <x-input-error class="mt-2" :messages="$errors->get('short_desc')" />
        </div>

        <div>
            <x-input-label for="desc" :value="__('Description')" />
            <small class="text-muted mb-0">Detailed description of the application</small>
            <div class="w-full" style="border: 2px solid #000 !important; border-radius: 6px;">
            <textarea rows="10" id="desc" name="desc" class="textarea mt-1 block w-full" value="" required autocomplete="desc"> {{ old('desc') }} </textarea>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('desc')" />
        </div>

        <div class="" style="">
        <x-input-label for="status" :value="__('Status')" />
        <small class="text-muted mb-0">Available or comming soon</small>
            <select id="status" class="block mt-1 w-full" style=" border: 2px solid #4d4d4d; border-radius: 6px; padding: 5px 10px" name="status"
                            required autocomplete="status">
              
              				@if(old('status'))
                            	<option value="{{ old('status') }}">{{ old('status') }}</option>
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
            <select id="specialty" class="block mt-1 w-full" style=" border: 2px solid #4d4d4d; border-radius: 6px; padding: 5px 10px" name="specialty"
                            required autocomplete="specialty">
              
              				@if(old('specialty'))
              					<option value="{{ old('specialty') }}">{{ old('specialty') }}</option>
              				@else
                            
                            <option value="General">General</option>
                            <option value="Trendings">Trendings</option>
                            <option value="Carousel">Carousel</option>
              
              				@endif
                            
                            </select>

            <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
        </div>
      
      	<div class="">
        <x-input-label for="birth_date" :value="__('Start Date')" />
            <x-text-input id="start_date" class="block mt-1 w-full" type="datetime-local" name="start_date" :value="old('start_date')" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="start_date" />
            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
        </div>

        <div class="">
        <x-input-label for="birth_date" :value="__('Due Date')" />
            <x-text-input id="due_date" class="block mt-1 w-full" type="datetime-local" name="due_date" :value="old('due_date')" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="due_date" />
            <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="price" :value="__('Service fee')" />
            <small class="text-muted mb-0">Application price</small>
            <x-text-input id="price" name="price" type="text" class="mt-1 block w-full" :value="old('price')" required autocomplete="price" />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>
      
      <div>
            <x-input-label for="link" :value="__('Link To Application Platform')" />
            <x-text-input id="link" name="link" type="text" class="mt-1 block w-full" :value="old('link')" required autocomplete="link" />
            <x-input-error class="mt-2" :messages="$errors->get('link')" />
        </div>
      
      	<div>
            <x-input-label for="link" :value="__('Link To Official Institution')" />
            <x-text-input id="link" name="link_to_institution" type="text" class="mt-1 block w-full" :value="old('link_to_institution')" required autocomplete="link" />
            <x-input-error class="mt-2" :messages="$errors->get('link_to_institution')" />
        </div>

        <div>
            <x-input-label style="font-size: 15px" for="name" :value="__('Poster')" />
            <small class="text-semi-muted mb-0">Application Poster</small>
            <div class="d-flex gap-1 mt-2">
              		<div style="position: relative">
                    <input class="text-left" type="button" id="uploadPreview" value="Select document" style="border: 1px solid #4d4d4d; border-radius: 6px; background: ghostwhite; padding: 4px 10px;" id="olBtn" data-element="insertOrderedList">
                    <input type="file" id="uploadFile" class="col-lg-11 w-full upload-file" style="top: 0px;" onchange="exc();" name="poster" >
                      </div>
                      
                    <button class="remove-file" id="removeFile" onclick="removeFileFun()" type="button">
                    <span class="fa-solid fa-folder-minus" style="border: 1px solid #b30000; border-radius: 3px; padding: 7px; color: #b30000;"></span>
                    </button>
    
    <x-input-error style="color: darkred; list-style: none" :messages="$errors->get('poster')"/>
      </div>
      </div>

        <div class="flex items-center gap-4">
        <x-primary-button class="apply-btn" style="border: none">
                {{ __('Publish') }}
            </x-primary-button>
        </div>
    </form>
    </div>
    </div>


    <script src="{{ asset('bootstrap/dist/js/jquery.min.js') }}"></script>


    <script>
          const removeFileBtn = document.getElementById("removeFile");

            function PreviewFile() {
                document.getElementById("uploadPreview").value = document.getElementById("uploadFile").value.match(/[\/\\]([\w\d\s\.\-\(/)]+)$/)[1];
            };

            function removeFileShow() {
            removeFileBtn.style.display = "block";
            };

            function removeFileFun () {
                document.getElementById("uploadFile").value = null;
                document.getElementById("uploadPreview").value = "Select Document";
                removeFileBtn.style.display = "none";
            }

            function exc() {
            PreviewFile();
            removeFileShow()
            }

            var max_count = 35;
            $(document).ready(function () {
                var wordCounts = {};
                $("#word_count").keyup(function () {
                    var matches = this.value.match(/\b/g);
                    wordCounts[this.id] = matches ? matches.length / 2 : 0;
                    var finalCount = 0;
                    $.each(wordCounts, function (k, v) {
                        finalCount += v;
                    });
                    var vl = this.value;
                    if (finalCount > max_count) {
                        vl = vl.substring(0, vl.length - 1);
                        this.value = vl;
                    }
                    var countleft = parseInt(max_count - finalCount);

                    $('#display_count').html(finalCount);
                    $('#count_left').html(countleft);
                    am_cal(finalCount);
                });
                }).keyup();

                

    </script>


    </div>
</div>

</x-app-layout>