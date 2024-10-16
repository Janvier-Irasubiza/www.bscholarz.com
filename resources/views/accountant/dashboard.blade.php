@section('title', 'Dashboard')

<x-accountant-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">
                            <div class="card-header-tab card-header py-3 d-flex">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                                    Overview
                                </div>
                                
                            </div>
                            <div class="no-gutters flex-section justify-content-between px-2 py-3">
                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex">
                                            <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #5AB8A4;">
                                                    <i class="fa-solid fa-people-group" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div style="" class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Customers</div>
                                                <div class="widget-numbers"><span>----</span></div>
                                                <div class="widget-description opacity-8 text-focus">
                                                    Ready to be served
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-xl-4">
                                    <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex justify-content-end">
                                            <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #80ffaa;">
                                                    <i class="fa-solid fa-person-circle-check" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Clients</div>
                                                <div class="widget-numbers text-success"><span>----</span></div>
                                                <div class="widget-description text-focus">
                                                    Served customers
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

    </div>

</x-accountant-layout>
