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
                        <div class="card border px-1">
                            <div class="bg-white flex-section justify-content-between px-5 py-3">
                                <div class="">
                                    <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex gap-4">
                                            <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #5AB8A4;">
                                                    <i class="fa-solid fa-people-group" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div style="" class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Applications</div>
                                                <div class="widget-numbers"><span>{{ number_format($readyCustomerCount) }}</span></div>
                                                <div class="widget-description opacity-8 text-focus">
                                                    <u>1 Active</u> &nbsp; <u>2 Expired</u>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>
                                <div class="">
                                    <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex gap-4">
                                            <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #80ffaa;">
                                                    <i class="fa-solid fa-rectangle-ad" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Adverts</div>
                                                <div class="widget-numbers text-success"><span>{{ number_format($servedCustomerCount) }}</span></div>
                                                <div class="widget-description text-focus">
                                                    <u>1 Active</u> &nbsp; <u>3 Expired</u>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex gap-4">
                                            <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #80ffaa;">
                                                    <i class="fa-solid fa-users" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Subscribers</div>
                                                <div class="widget-numbers text-success"><span>{{ number_format($servedCustomerCount) }}</span></div>
                                                <div class="widget-description text-focus">
                                                    Our subscribers
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

</x-app-layout>
