@section('title', 'Advert Info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

    <div class="container-fluid">
    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    Publish advert - 

                    @if($ad -> status == 'active')

                    <span style="font-size: 10px" class="badge bg-success rounded-pill px-3">{{ $ad -> status }}</span>

                    @else 

                    <span style="font-size: 10px" class="badge bg-danger rounded-pill px-3">{{ $ad -> status }}</span>

                    @endif

                    <br>

                    <p class="text-muted mt-1 mb-0" style="font-size: 13px">Posted on{{ $ad -> posted_on }}</p>

                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    <a style="font-weight: 500; border: 1.3px solid;" href="{{ Auth::user() ? route('admin.ads') : route('md.ads') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                    View adverts
                    </a>

                    </div>
                    </div>
    <form method="post" action="{{ Auth::user() ? route('admin.update-ad') : route('md.update-ad') }}" class="mt-6 space-y-6 mt-4 mb-3" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="title" :value="__('Title')" />
            <small class="text-muted mb-0">Ttile to be view by the audience</small>
            <x-text-input id="title" name="advert" type="text" hidden class="mt-1 block w-full" value="{{ $ad -> id }}" required autocomplete="title" style="border: 1.3px solid #b3b3b3"/>
            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" value="{{ $ad -> title }}" required autocomplete="title" style="border: 1.3px solid #b3b3b3"/>
            <x-input-error class="mt-2" :messages="$errors->get('title')" />
        </div>

        <div>
            <x-input-label for="owner" :value="__('Owner names')" />
            <small class="text-muted mb-0">Publisher</small>
            <x-text-input id="owner" name="owner" type="text" class="mt-1 block w-full" value="{{ $ad -> owner }}" required autocomplete="owner" style="border: 1.3px solid #b3b3b3"/>
            <x-input-error class="mt-2" :messages="$errors->get('owner')" />
        </div>

        <div>
            <x-input-label for="owner_phone" :value="__('Owner phone')" />
            <small class="text-muted mb-0">Publisher contact</small>
            <x-text-input id="owner_phone" name="owner_phone" type="text" class="mt-1 block w-full" value="{{ $ad -> owner_phone }}" required autocomplete="owner_phone" style="border: 1.3px solid #b3b3b3" />
            <x-input-error class="mt-2" :messages="$errors->get('owner_phone')" />
        </div>

        <div>
            <x-input-label for="ad_type" :value="__('Advert type')" />
            <small class="text-muted mb-0">Primary or secondary</small>
            <x-text-input id="ad_type" class="block mt-1 w-full" type="text" value="{{ $ad -> type }}" style=" border: 1.3px solid #b3b3b3; border-radius: 6px; padding: 5px 10px" name="ad_type"
                            required autocomplete="ad_type"/>

            <x-input-error class="mt-2" :messages="$errors->get('ad_type')" />
        </div>

        <div>
            <x-input-label for="amount" :value="__('Amount')" />
            <small class="text-muted mb-0">Amount to be paid</small>
            <x-text-input id="amount" name="amount" type="text" class="mt-1 block w-full" value="{{ $ad -> amount }}" required autocomplete="amount" style="border: 1.3px solid #b3b3b3"/>
            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
        </div>

        <div>
            <x-input-label for="payment_cycle" :value="__('Payment cyle')" />
            <small class="text-muted mb-0">In which cycle</small>
            <x-text-input id="payment_cycle" name="payment_cycle" type="text" class="mt-1 block w-full" value="{{ $ad -> payment_circle }}" required autocomplete="payment_cycle" style="border: 1.3px solid #b3b3b3"/>
            <x-input-error class="mt-2" :messages="$errors->get('payment_cycle')" />
        </div>

        <div>
            <x-input-label for="ex_date" :value="__('Expiry date')" />
            <small class="text-muted mb-0">When is it going inactive</small>
            <x-text-input id="ex_date" name="ex_date" style="border: 1.3px solid #b3b3b3; padding: 5px 10px" type="text" value="{{ $ad -> expiry_date }}" class="mt-1 block w-full" required autocomplete="ex_date" />
            <x-input-error class="mt-2" :messages="$errors->get('ex_date')" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <small class="text-muted mb-0">Active or Inactive</small>
            <x-text-input id="status" class="block mt-1 w-full" type="text" value="{{ $ad -> status }}" style=" border: 1.3px solid #b3b3b3; border-radius: 6px; padding: 5px 10px" name="status"
                            required autocomplete="status"/>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div>
            <x-input-label style="font-size: 15px" for="name" :value="__('Media')" />
            <small class="text-semi-muted mb-0">Advert Media</small></br>
            <input type="text" hidden value="{{ $ad -> media }}" class="text-left" name="old_media" >
            <div class="d-flex gap-1 mt-2">

        <div class="div" tsyle="position: relative">
        <div style="width: 200px; height: 100px;" class="d-flex">
        <img class="img-responsive" style="max-width: 100%; max-height: 100%; border-radius: 6px;" id="uploadPreview" src="{{ asset('ads') }}/{{ $ad -> media }}" alt="User">
        <input type="file" id="uploadImage" class="text-left" onchange="PreviewFile(event);" name="media" style="padding: 3.3%; position: absolute; bottom: 6.3em; width: 14.8%; left: 3.2em; right: auto; border: 1px solid red; right: 0px; opacity: 0" >
        </div>
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


    </div>
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

</x-app-layout>