
@section('title', 'Client - Apply')

@section('content')

<x-client-layout>

<x-slot name="header">
</slot>

<div class="client-body-csmt-1 mb-3 py-5" style="">

    <div class="col-lg-10">
        
    <div class="acc-details-other margin">
    <div class="d-flex justify-content-center align-items-center mb-4 py-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.151);">
    <strong><h2 style="font-size: 20px">{{ $application_info -> discipline_name }}</h2></strong>
</div>
<form method="POST" action="{{ route('client-appication') }}" enctype="multipart/form-data">
    <div class="">
        <div class="px-3">
        @csrf

        <input id="application_info" class="block mt-1 w-full" type="text" name="application_info" value="{{ $application_info -> id }}" style="padding: 6px 10px; color: #808080; border: 2px solid #4d4d4d" required autocomplete="application_info" hidden/>

<div class="ocassion-desc-hold" style="margin-top: -10px;">
        <div>
            <p>{{ $application_info -> discipline_desc }}</p>
        </div>

        <div class="pb-3 mt-3">
            <strong>Ends: </strong> {{ $application_info -> due_date }} <br>
            <strong>Started: </strong> {{ $application_info -> publish_date }} <br>
            <strong>Service fee: </strong> {{ $application_info -> service_fee }} 
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg p-1 pb-0 align-items-center flex-section gap-2" style="border: 1px solid #0000002d; border-radius: 5px">

                @php 
                    $included = explode(',', $application_info -> includes);
                    $required = explode(',', $application_info -> requirements);
                @endphp 

                    <strong>Benefits:</strong>

                    <div class="container-fluid testimonial-group" style="padding: 0px">
                    <div class="row text-center gap-1" style="padding: 0px; margin: 0px; overflow: auto; white-space: nowrap; margin: auto">

                        @foreach($included as $item)
                        
                      	<div style="width: auto; padding: 0px; margin: auto">
                      	
                          <div class="includes mb-1" style=""> 
                            {{ $item }} <i style="font-size: 13px" class="fa-regular fa-circle-check"></i>
                        </div>
                          
                      	</div>
                        
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2" style="">
                <div class="col-lg p-1 pb-0 flex-section align-items-center gap-2" style="border: 1px solid #0000002d; border-radius: 5px">

                <strong>Requirements:</strong>
                <div class="container-fluid testimonial-group" style="padding: 0px">
                    <div class="row text-center gap-1" style="padding: 0px; margin: 0px; overflow: auto; white-space: nowrap; margin: auto">

                        @foreach($required as $item)
                        
                      	<div style="width: auto; padding: 0px; margin: auto">
                      	
                          <div class="includes mb-1" style=""> 
                            {{ $item }} <i style="font-size: 13px" class="fa-regular fa-circle-check"></i>
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

        

        <div class="button-section mt-4 px-3">
            <x-primary-button class="apply-btn px-5" style="">
                {{ __('Request service') }}
            </x-primary-button>
        </div>
        
        </form>

        </div>

        <script>

            const newBackSection = document.querySelector('.new-back-sections');        

            function addBackSection() {
                const backSection = document.createElement('div');
                backSection.classList.add('mt-4');
                backSection.setAttribute('id','backSection');

                const inner_info_div = document.createElement('div');
                inner_info_div.classList.add('inner-info-div');
                
                const inputHolder = document.createElement('div');
                inputHolder.classList.add('mt-3');

                const GraduationinputHolder = document.createElement('div');
                GraduationinputHolder.classList.add('mt-3');

                // Level of education
                const div = document.createElement('div');
                const undoBtnSection = document.createElement('div');
                const educationLevelLabel = document.createElement('label');
                educationLevelLabel.textContent = 'Level of education';
                const undoBtnDiv = document.createElement('div');
                const undoBtn = document.createElement('button');
                undoBtn.textContent = 'Undo';
                undoBtn.classList.add('secondary-btn');

                var content = '<div>'+
                        '<div class="d-flex justify-content-between">'+
                        '<label for="education_level" />Level of education</label>'+
                        '<button type="button" id="undoBtn" onclick="removeSection();" class="secondary-btn">undo</button>'+
                        '</div>'+
                        '<input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="education_level" class="block mt-1 w-full" type="text" name="education_level[]"  placeholder="Current Level of education" required autofocus autocomplete="education_level" />'+
                        // '<li :messages="$errors->get('education_level[]')" class="mt-2" />'+
                    '</div>'+

                    '<div class="mt-3">'+
                        '<label for="email">From which institution or School</label>'+
                        '<input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="institution" class="block mt-1 w-full" type="text" name="institution[]"  placeholder="Institution or school name" required autocomplete="institution" />'+
                        // '<x-input-error :messages="$errors->get('institution[]')" class="mt-2" />'+
                    '</div>'+

                    '<div class="mt-3">'+
                    '<label for="phone_number">Graduatioon date</label>'+
                        '<input style = "padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080; border-radius: 6px" id="graduation_date" class="block mt-1 w-full" type="date" style="padding: 6px 10px; border: 2px solid #4d4d4d; color: #808080" name="graduation_date[]" placeholder="Your phone number" required autocomplete="graduation_date" />'+
                        // '<x-input-error :messages="$errors->get('graduation_date[]')" class="mt-2" />'+
                    '</div>'+
                    '</div>'
                    '</div>';
                    newBackSection.append(backSection);
                    backSection.append(inner_info_div);
                    inner_info_div.append(div);

                    div.innerHTML = content;

                }

                function removeSection () {
                    document.getElementById('undoBtn').parentElement.parentElement.parentElement.parentElement.remove();                    
                }

                // Add files function
                function addDocSection () {

                    console.log('clicked');
                    
                // Supporting documents
                const newFilesWrapper = document.querySelector('.new-files-wrapper');
                const fileInputWrapper = document.createElement('div');
                fileInputWrapper.classList.add('d-flex', 'gap-1', 'mt-2');
                fileInputWrapper.style = "position: relative";

                // New file

                const fileHolder = document.createElement('div');
                fileHolder.classList.add('col-lg-11');
                fileHolder.style = 'border-radius: 5px; width: 90%;  overflow: hidden';

                const newFileInputPreview = document.createElement('input');
                newFileInputPreview.classList.add('w-full', 'text-left');
                newFileInputPreview.type = 'button';
                newFileInputPreview.value = 'Select document';
                newFileInputPreview.setAttribute('id', 'uploadPreview');
                newFileInputPreview.style = 'border: 2px solid #4d4d4d; border-radius: 6px; background: ghostwhite; padding: 4px 10px;';

                const newFileInput = document.createElement('input');
                newFileInput.type = 'file';
                newFileInput.setAttribute('id','uploadFile');
                newFileInput.classList.add('w-full', 'upload-file');
                newFileInput.addEventListener('change', PreviewFile(event));
                newFileInput.name = 'document[]';
                newFileInput.style = "width: 90%; border: 1px solid"

                // Remove file button
                const removeFileBtnWrapper = document.createElement('button');
                removeFileBtnWrapper.type = 'button';
                removeFileBtnWrapper.classList.add('remove-file');
                removeFileBtnWrapper.setAttribute('id', 'removeNewFile');

                const removeFileBtnContent = document.createElement('span');
                removeFileBtnContent.classList.add('fa-solid', 'fa-folder-minus');
                removeFileBtnContent.style = 'border: 1px solid #b30000; border-radius: 3px; padding: 7px; color: #b30000';

                const removeInputBtnWrapper = document.createElement('button');
                removeInputBtnWrapper.type = 'button';
                removeInputBtnWrapper.classList.add('remove-file');
                removeInputBtnWrapper.setAttribute('id', 'removeNewFile');

                const removeInputBtnContent = document.createElement('span');
                removeInputBtnContent.classList.add('fa', 'fa-times');
                removeInputBtnContent.style = 'border: 1px solid #b30000; border-radius: 3px; padding: 7px; color: #b30000';

                newFileInput.addEventListener('change', function () {
                    newFileInputPreview.value = newFileInput.value.match(/[\/\\]([\w\d\s\.\-\(/)]+)$/)[1];
                    removeFileBtnWrapper.style.display = "block";
                    removeInputBtnWrapper.style.display = "none";
                });

                    newFilesWrapper.append(fileInputWrapper);
                    fileInputWrapper.append(fileHolder);
                    fileHolder.append(newFileInputPreview, newFileInput);
                    fileInputWrapper.append(removeFileBtnWrapper, removeInputBtnWrapper);
                    removeFileBtnWrapper.append(removeFileBtnContent);
                    removeInputBtnWrapper.append(removeInputBtnContent);
                    removeInputBtnWrapper.style.display = "block";

                    removeFileBtnWrapper.addEventListener('click', function () {
                        newFileInput.value = null;
                        newFileInputPreview.value = 'Select document';
                        removeFileBtnWrapper.style.display = "none";
                        removeInputBtnWrapper.style.display = "block";
                    });

                    removeInputBtnWrapper.addEventListener('click', function () {
                        newFileInput.value = null;
                        newFileInputPreview.value = 'Select document';
                        removeInputBtnWrapper.parentElement.remove();
                        removeInputBtnWrapper.style.display = "none";
                    });

                }

            const removeFileBtn = document.getElementById("removeFile");

            function PreviewFile(event) {
                document.getElementById("firstUploadPreview").value = document.getElementById("uploadFile").value.match(/[\/\\]([\w\d\s\.\-\(/)]+)$/)[1];
                removeFileShow()
            };

            function removeFileShow() {
            removeFileBtn.style.display = "block";
            };

            function removeFileFun () {
                document.getElementById("uploadFile").value = null;
                document.getElementById("firstUploadPreview").value = "Select Document";
                removeFileBtn.style.display = "none";
            }
        </script>

    </div>

</div>

</x-client-layout>
