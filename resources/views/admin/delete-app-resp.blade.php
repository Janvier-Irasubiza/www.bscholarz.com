@section('title', 'Application info')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">

    <div class="container-fluid">
    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-sm font-weight-normal col-lg-8">
                    {{ $app -> discipline_name }} <small>of</small> {{ $app -> organization }} was successfull delete and from now on, it'll not be reached by the users.
                    Click button in the right, or refresh the page to go back to applications.          
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    <a href="{{ route('admin.applications') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn apply-btn" >
                        <span class="mr-1">Back to applications</span>
                    </a>


                    </div>
                    </div>
                    
    </div>

    </div>
</div>

</x-app-layout>