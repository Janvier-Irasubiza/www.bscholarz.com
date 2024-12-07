@section('title', 'Dashboard')

<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">
        <!-- Working Progress Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">
                            <div class="card-header-tab card-header py-3 d-flex">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                                    <h1 style="font-size: 1.3em">Working Progress</h1>
                                </div>
                                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                                    <a href="{{ route('admin.org') }}" style="font-weight: 600; border: 1.3px solid"
                                        class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm sd-btn">
                                        Active Employees: {{ number_format($activeEmployeeCount) }}
                                    </a>
                                </div>
                            </div>
                            <div class="no-gutters flex-section justify-content-between gap-2 px-3 py-3"
                                style="padding-right: 32px !important">
                                <div class="sum-card rounded p-2 col-lg-4 pb-3">
                                    <h1 class="card-header-title fw-700 text-center f-20">Business Revenues</h1>
                                    <div class="d-flex justify-content-start align-items-start px-2 gap-3 mt-1">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 text-center justify-content-center d-flex flex-column mt-1"
                                            style="height: 100px;">
                                            <h4>Total Income</h4>
                                            <div class="widget-numbers">{{ number_format($total_revenues) }} K</div>
                                        </div>
                                        <!-- Right Column -->
                                        <div class="justify-content-center col-lg-6 d-flex flex-column align-items-start justify-content-start"
                                            style="height: 100px; padding: 10px;">
                                            <div>
                                                <small style="font-size: 10px">Today</small>
                                                <div style="font-size: 13px">
                                                    <strong>{{ number_format($today_revenues) }} &nbsp; RWF</strong>
                                                </div>
                                            </div>
                                            <div class="mb-1">
                                                <small style="font-size: 10px">This week</small>
                                                <div style="font-size: 13px">
                                                    <strong>{{ number_format($this_week_revenues) }} &nbsp; RWF</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="sum-card rounded p-2 col-lg-4 pb-3" style="margin-right: 0px">
                                    <h1 class="card-header-title fw-700 text-center f-20">Business Productivity</h1>
                                    <div class="d-flex justify-content-start align-items-start px-2 gap-3 mt-1">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 text-center justify-content-center d-flex flex-column mt-1"
                                            style="height: 100px;">
                                            <h4>Service Requests</h4>
                                            <div class="widget-numbers">{{ number_format($total_requests) }}</div>
                                        </div>
                                        <!-- Right Column -->
                                        <div class="justify-content-center col-lg-6 d-flex flex-column align-items-start justify-content-start"
                                            style="height: 100px; padding: 10px;">
                                            <div>
                                                <small style="font-size: 10px">Today</small>
                                                <div style="font-size: 13px">
                                                    <strong>{{ number_format($today_requests) }} &nbsp;
                                                        Requests</strong></div>
                                            </div>
                                            <div class="mb-1">
                                                <small style="font-size: 10px">This week</small>
                                                <div style="font-size: 13px">
                                                    <strong>{{ number_format($this_week_requests) }} &nbsp;
                                                        Requests</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sum-card rounded p-2 col-lg-4 pb-3">
                                    <h1 class="card-header-title fw-700 text-center f-20">Business Store</h1>
                                    <div class="d-flex justify-content-start align-items-start px-2 gap-3 mt-1">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 text-center justify-content-center d-flex flex-column mt-1"
                                            style="height: 100px;">
                                            <h4>Total Services</h4>
                                            <div class="widget-numbers">{{ number_format($total_services) }}</div>
                                        </div>
                                        <!-- Right Column -->
                                        <div class="justify-content-center col-lg-6 d-flex flex-column align-items-start justify-content-start"
                                            style="height: 100px; padding: 10px;">
                                            <div>
                                                <small style="font-size: 10px">Ready</small>
                                                <div style="font-size: 13px">
                                                    <strong>{{ number_format($ready_services) }} &nbsp;
                                                        Services</strong></div>
                                            </div>
                                            <div class="mb-1">
                                                <small style="font-size: 10px">Upcoming</small>
                                                <div style="font-size: 13px">
                                                    <strong>{{ number_format($upcoming_services) }} &nbsp;
                                                        Services</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="text-center d-block p-3 card-footer">
                                <a href="{{ route('admin.revenue') }}"
                                    class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                                    <span class="mr-2 opacity-7">
                                        <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                                    </span>
                                    <span class="mr-1">Navigate to Revenue</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mt-3">
            <div class="bg-white w-full sm:rounded-lg p-3 w-full">
                <div class="widget-subheading d-flex justify-content-between align-items-center">
                    <h1 style="font-size: 1.3em">Current services</h1>

                    <a href="{{ route('admin.revenue') }}"
                        class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                        <span class="mr-2 opacity-7"><i
                                class="icon icon-anim-pulse ion-ios-analytics-outline"></i></span>
                        <span class="mr-1">New service</span>
                    </a>

                </div>
                <div
                    class="d-flex justify-content-between align-items-center no-shadow rm-border bg-transparent widget-chart text-left border rounded p-3 mt-3">
                    <div class="">
                        <div class="widget-chart-content ml-1 w-full">
                            <div class="widget-subheading">
                                <p>Current services</p>
                            </div>
                            <div class="widget-numbers text-success"><span>{{ number_format($applicationCount) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="">
                        <div class="widget-chart-content ml-1 w-full">
                            <div class="widget-subheading">
                                <p>Deadlined services</p>
                            </div>
                            <div class="widget-numbers text-success">
                                <span>{{ number_format($deadlinedAppsCount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white col-lg-3 sm:rounded-lg p-3">
                <div class="widget-subheading d-flex justify-content-between align-items-center">
                    <h1 style="font-size: 1.3em">Appointments</h1>
                </div>
                <div
                    class="d-flex justify-content-between align-items-center no-shadow rm-border bg-transparent widget-chart text-left border rounded p-3 mt-3">
                    <div class="">
                        <div class="widget-chart-content ml-1 w-full">
                            <div class="widget-numbers text-success">
                                <span>{{ number_format($appointments) }}</span>
                            </div>
                            <a href="{{ route('admin.appointments') }}" class="underline">View Appointments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3 mt-3">
            <div class="bg-white w-full sm:rounded-lg p-3">
                <div
                    class="d-flex justify-content-between align-items-center no-shadow rm-border bg-transparent widget-chart text-left border rounded p-3">
                    <div class="d-flex gap-4">
                        <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                            <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #ff6666;">
                                <i class="fa-solid fa-trash text-white" style="font-size: 23px"></i>
                            </div>
                        </div>
                        <div class="widget-chart-content col-lg-9 ml-1">
                            <div class="widget-subheading">Delete requests</div>
                            <div class="widget-numbers text-success">
                                <span>{{ number_format($requestedDeleteCount) }}</span>
                            </div>
                            <div class="widget-description text-focus">Needs a confirmation</div>
                        </div>
                    </div>

                    <div class="btn-actions-pane-right text-capitalize text-right">
                        <a href="{{ route('admin.revenue') }}"
                            class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                            <span class="mr-2 opacity-7"><i
                                    class="icon icon-anim-pulse ion-ios-analytics-outline"></i></span>
                            <span class="mr-1">Review</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white w-full sm:rounded-lg p-3">
                <div
                    class="d-flex justify-content-between align-items-center no-shadow rm-border bg-transparent widget-chart text-left border rounded p-3">
                    <div class="d-flex gap-4">
                        <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                            <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #80ffaa;">
                                <i class="fa-solid fa-message" style="font-size: 25px"></i>
                            </div>
                        </div>
                        <div class="widget-chart-content col-lg-9 ml-1">
                            <div class="widget-subheading">Assistance requests</div>
                            <div class="widget-numbers text-success">
                                <span>{{ number_format($assistanceRequestCount) }}</span>
                            </div>
                            <div class="widget-description text-focus">Needs a review</div>
                        </div>
                    </div>

                    <div class="btn-actions-pane-right text-capitalize text-right">
                        <a href="{{ route('admin.assistance-requests') }}"
                            class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                            <span class="mr-1">See requests</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>




    </div>
    </div>
    </div>
    </div>

    </div>

</x-app-layout>