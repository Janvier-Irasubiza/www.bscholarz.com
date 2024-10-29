@section('title', 'Adverts')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">
    <div class="app-inner-layout__content">
                <div class="tab-content">
                <div>
                <div class="card">
                <div class="card-header-tab card-header py-3 d-flex">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                Adverts
                </div>
                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                <a href="{{ Auth::user() ? route('admin.publish-add') : route('md.publish-add') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">Publish New Ad</span>
                </a>
                </div>
                </div>

                <div class="card-body">
                <div class="row row-cols-4 g-3">

                @foreach($ads as $ad)
  <div class="col">
    <div class="card">

    @if(substr($ad -> media_type, 0, 5) == 'image')

    <img src="{{ asset('ads') }}/{{ $ad -> media }}" class="card-img-top" alt="Hollywood Sign on The Hill">

    @else

    <video src="{{ asset('ads') }}/{{ $ad -> media }}" class="card-img-top" autoplay></video>

    @endif

      <div class="card-body">
        <h5 class="card-title">{{ $ad -> title }} - 

        @if($ad -> status == 'active')

        <span style="font-size: 10px" class="badge bg-success rounded-pill px-3">{{ $ad -> status }}</span>

        @else 

        <span style="font-size: 10px" class="badge bg-danger rounded-pill px-3">{{ $ad -> status }}</span>

        @endif

        </h5>
        <p class="text-muted mb-0 mt-0" style="font-size: 13px">{{ $ad -> type }}</p>
        <p class="text-muted mb-0 mt-0" style="font-size: 13px">Epired after: {{ $ad -> expiry_date }}</p>
        <p class="text-muted mb-0 mt-1"><span style="font-weight: 600">{{ number_format($ad -> amount) }}</span> <small style="font-weight: 600">RWF</small> {{ $ad -> payment_circle }}</p>

      </div>    
      <div class="text-center d-block g-3 card-footer">

            @if($ad -> status == 'active')

            <a href="{{ Auth::user() ? route('admin.disactivate', ['ad_id' => $ad -> id]) : route('md.disactivate', ['ad_id' => $ad -> id]) }}" style="border: 2px solid; padding: 4px 10px; text-decoration: none" class="btn btn-link btn-sm btn-rounded mr-1">
              <i class="fa-solid fa-download"></i> 
            </a>

            @else 

            <a href="{{ Auth::user() ? route('admin.activate', ['ad_id' => $ad -> id]) : route('md.activate', ['ad_id' => $ad -> id]) }}" style="border: 2px solid; padding: 4px 10px; text-decoration: none" class="btn btn-link btn-sm btn-rounded mr-1">
                 <i class="fa-solid fa-upload"></i> 
            </a>

            @endif

            <a href="{{ Auth::user() ? route('admin.add-info', ['add_id' => $ad -> id]) : route('md.add-info', ['add_id' => $ad -> id]) }}" style="border: 2px solid; padding: 4px 10px; text-decoration: none" class="btn btn-link btn-sm btn-rounded mr-1">
      <i class="fa-solid fa-info"></i> 
            </a>

        <a href="{{ Auth::user() ? route('admin.delete-ad', ['ad_id' => $ad -> id]) : route('md.delete-ad', ['ad_id' => $ad -> id]) }}" class="btn btn-link btn-sm btn-rounded mr-1" style="border: 2px solid; padding: 4px 6px; color: #ec6c55; text-decoration: none">
        <i class="fa-solid fa-trash"></i> 
            </a>
                </div>
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

</x-app-layout>

