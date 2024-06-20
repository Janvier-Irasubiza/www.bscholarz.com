@section('title', 'Administration')

<x-rhythm-box>

<x-slot name="header">
</slot>

<div class="py-2" style="padding: 0px 80px 0px 98px">


<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-5">
    <div class="app-inner-layout__content">
                <div class="tab-content">
                <div>
                <div class="card">
                <div class="card-header-tab card-header py-3 d-flex">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                Business Overview
                </div>

                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                </div>
                </div>
                <div class="no-gutters flex-section justify-content-between px-2 py-3">
                <!-- <div class="col-sm-6 col-md-4 col-xl-4">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #ec6c55bd;">
                <i class="fa-solid fa-person-booth" style="font-size: 25px"></i></div></div>
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Website visitors</div>
                <div class="widget-numbers">{{ number_format('56789') }}</div>
                <div class="widget-description opacity-8 text-focus">
                <div class="d-inline text-danger pr-1">

                </div>
               <a href=""><p class="mb-0">View analytics</p></a>
                </div>
                </div>
                </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div> -->
                <div class="col-sm-6 col-md-4 col-xl-4">
                <div style="border: none"  class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #5AB8A4;">
                <i class="fa-solid fa-users" style="font-size: 25px"></i></div></div>
                <div style="" class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Community
                </div>
                <div class="widget-numbers"><span>{{ number_format(count($clients)) }}</span></div>
                <div class="widget-description opacity-8 text-focus">
                <p class="mb-0">{{ number_format(count($clients_requests)) }} Clients requests</p>

                </div>
                </div>
                </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-4">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle" style="background: #80ffaa; padding: 15px 17px">
                <i class="fa-solid fa-person-digging" style="font-size: 25px"></i></div>
                </div>
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Staff</div>
                <div class="widget-numbers text-success"><span>{{ number_format(count($staff)) }}</span></div>
                <div class="widget-description text-focus">

                <p class="mb-0"> @if($active_staff > 0)  {{ number_format($active_staff) }} Online <small>(</small>working<small>)</small>  @else  None is working @endif </p>
                
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
        </div>
    </div>
    </div>
</div>


    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-3">

    <div class="card">

    <div class="card-header-tab card-header py-3 d-flex" style="border-bottom: 1px solid rgba(0, 0, 0, 0.192)">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                    Searches</br>
                    <small class="text-muted mb-0">Searched keywords</small>
                    </div>
                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">

                    </div>
                    </div>
                    <div class="card-body pb-2">

                    <div class="row">

                    @foreach($searches as $keyword)

                    <div class="col-md-3 mb-2">
                        <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">{{ $keyword -> keyword }}

                            </h5>
                            <p class="text-muted mb-0 mt-0" style="font-size: 13px">Counts: {{ $keyword -> count }}</p>

                        </div>    
                        </div>
                    </div>

                    @endforeach

            </div>

            </div>
            </div>
            </div>
            </div>

</x-rhythm-box>
