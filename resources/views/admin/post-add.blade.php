@section('title', 'Post advert')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">

    <div class="container-fluid">
    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    Publish advert
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    <a style="font-weight: 500; border: 1.3px solid;" href="{{ route('admin.ads') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    View adverts
                    </a>

                    </div>
                    </div>
    <form method="post" action="{{ route('admin.post-add') }}" class="mt-6 space-y-6 mt-4 mb-3" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <small class="text-muted mb-0">Ttile to be view by the audience</small>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="" required autocomplete="title" />
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="owner" :value="__('Owner names')" />
            <small class="text-muted mb-0">Publisher</small>
            <x-text-input id="owner" name="owner" type="text" class="mt-1 block w-full" value="" required autocomplete="owner" />
            <x-input-error class="mt-2" :messages="$errors->get('owner')" />
        </div>

        <div>
            <x-input-label for="owner_phone" :value="__('Owner phone')" />
            <small class="text-muted mb-0">Publisher contact</small>
            <x-text-input id="owner_phone" name="owner_phone" type="text" class="mt-1 block w-full" value="" required autocomplete="owner_phone" />
            <x-input-error class="mt-2" :messages="$errors->get('owner_phone')" />
        </div>

        <div>
            <x-input-label for="ad_type" :value="__('Advert type')" />
            <small class="text-muted mb-0">Primary or secondary</small>
            <select id="ad_type" class="block mt-1 w-full" style=" border: 2px solid #4d4d4d; border-radius: 6px; padding: 5px 10px" name="ad_type"
                            required autocomplete="ad_type">

                            <option value="Primary">Primary</option>
                            <option value="Secondary">Secondary</option>
                            </select>

            <x-input-error class="mt-2" :messages="$errors->get('ad_type')" />
        </div>

        <div>
            <x-input-label for="amount" :value="__('Amount')" />
            <small class="text-muted mb-0">Amount to be paid</small>
            <x-text-input id="amount" name="amount" type="text" class="mt-1 block w-full" value="" required autocomplete="amount" />
            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
        </div>

        <div>
            <x-input-label for="payment_cycle" :value="__('Payment cyle')" />
            <small class="text-muted mb-0">In which cycle</small>
            <x-text-input id="payment_cycle" name="payment_cycle" type="text" class="mt-1 block w-full" value="" required autocomplete="payment_cycle" />
            <x-input-error class="mt-2" :messages="$errors->get('payment_cycle')" />
        </div>

        <div>
            <x-input-label for="ex_date" :value="__('Expiry date')" />
            <small class="text-muted mb-0">When is it going inactive</small>
            <x-text-input id="ex_date" name="ex_date" style="border: 2px solid #4d4d4d; padding: 5px 10px" type="datetime-local" class="mt-1 block w-full" required autocomplete="ex_date" />
            <x-input-error class="mt-2" :messages="$errors->get('ex_date')" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <small class="text-muted mb-0">Active or Inactive</small>
            <select id="status" class="block mt-1 w-full" style=" border: 2px solid #4d4d4d; border-radius: 6px; padding: 5px 10px" name="status"
                            required autocomplete="status">

                            <option value="Inactive">Inactive</option>
                            <option value="Active">Active</option>
                            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div class="mt-3">
        <x-input-label for="media" :value="__('Media')" />
        <small class="text-muted mb-0">Advert media file</small>
        <div class="d-flex gap-1 mt-2">
            <input class="text-left" type="button" id="uploadPreview" value="Select file" style="border: 2px solid #4d4d4d; border-radius: 6px; background: ghostwhite; padding: 4px 10px;" id="olBtn" data-element="insertOrderedList">
            <input type="file" id="uploadFile" class="col-lg-11 upload-file" onchange="exc();" name="media" >
            <button class="remove-file" id="removeFile" onclick="removeFileFun()" type="button">
                <span class="fa-solid fa-folder-minus" style="border: 1px solid #b30000; border-radius: 3px; padding: 7px; color: #b30000;"></span>
            </button>    
    <x-input-error style="color: darkred; list-style: none" :messages="$errors->get('media')"/>
      </div>
      </div>

        <div class="flex items-center gap-4">
        <x-primary-button class="apply-btn" style="border: none">
                {{ __('publish advert') }}
            </x-primary-button>
        </div>
    </form>
    </div>


    </div>
</div>

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
    document.getElementById("uploadPreview").value = "Select file";
    removeFileBtn.style.display = "none";
}

function exc() {
PreviewFile();
removeFileShow()
}
</script>

</x-app-layout>