@section('title', 'Testimonials')

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
                Testimonials
                </div>
                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                <a href="{{ Auth::user() ? route('new-testmony') : route('md.new-testmony') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">New testmony</span>
                </a>
                </div>
                </div>

                <div class="card-body">

                @foreach($motivation as $testmony)
                <div class="mb-5 space-y-6">

                <div class="testimony mt-3" style="">
            <div class="flex-section gap-4">

            <div class="col-lg-4">

            <div class="d-flex gap-4 align-items-center mb-4 mt-3">
            <img class="saying-profile-picture-cst" style="display: block" src="{{ asset('images') }}/{{ $testmony -> motivator_pp }}" alt="Profile">


            <div class="">
                <strong><h4 style="font-size: 13px; padding: 10px; box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px; border-radius: 7px; background-color: #5dc5afad">{{ $testmony -> motivator_names }}</h4></strong>
            </div>
            </div>

                <div class="motiv-saying" style="">
                    <h1>{{ $testmony -> motivation_theme }}.</h1>
                    <small><strong>"{{ $testmony -> motivation_sentence }}"</strong></small>
                </div>
            </div>

                <div class="col-lg-">

                <div class="px-4 py-3" style="background-color: #fff; border-radius: 5px;">
                <p style="font-size: 14px">{{ $testmony -> motivation }} </p>
                </div>
                    

                <div class="mt-3 ml-2 d-flex gap-3">
                <a class="underline text-sm hover:text-gray-600 dark:hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ Auth::user() ? route('edit-testmony', ['testmony' => $testmony -> id]) : route('md.edit-testmony', ['testmony' => $testmony -> id]) }}">
                    {{ __('Edit testmony') }}
                </a>

                <a class="underline text-sm hover:text-gray-600 dark:hover:text-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ Auth::user() ? route('delete-testmony', ['id' => $testmony -> id, 'file' => $testmony -> motivator_pp]) : route('md.delete-testmony', ['id' => $testmony -> id, 'file' => $testmony -> motivator_pp]) }}">
                    {{ __('Delete') }}
                </a>

                </div>
                    
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

