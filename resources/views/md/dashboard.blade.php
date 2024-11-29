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
                                    <div style="border: none"
                                        class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex gap-4">
                                            <div
                                                class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #5AB8A4;">
                                                    <i class="fa-solid fa-people-group" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div style="" class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Applications</div>
                                                <div class="widget-numbers">
                                                    <span class="active-apps">---</span>
                                                </div>
                                                <div class="widget-description opacity-8 text-focus">
                                                    <u>
                                                        <span class="a-apps">---</span> Active</u> &nbsp;
                                                    <u>
                                                        <span class="x-apps">---</span> Expired
                                                    </u>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>
                                <div class="">
                                    <div style="border: none"
                                        class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex gap-4">
                                            <div
                                                class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #80ffaa;">
                                                    <i class="fa-solid fa-rectangle-ad" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Adverts</div>
                                                <div class="widget-numbers text-success"><span
                                                        class="active-ads">---</span></div>
                                                <div class="widget-description text-focus">
                                                    <u><span class="a-ads">---</span> Active</u> &nbsp; <u><span class="x-ads"></span> Expired</u>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <div style="border: none"
                                        class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="d-flex gap-4">
                                            <div
                                                class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                                                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3"
                                                    style="background: #80ffaa;">
                                                    <i class="fa-solid fa-users" style="font-size: 25px"></i>
                                                </div>
                                            </div>
                                            <div class="widget-chart-content col-lg-9 ml-1">
                                                <div class="widget-subheading">Subscribers</div>
                                                <div class="widget-numbers text-success"><span class="subs">---</span>
                                                </div>
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let activeApps = document.querySelector('.active-apps');
                let a_Apps = document.querySelector('.a-apps');
                let xApps = document.querySelector('.x-apps');
                let activeAds = document.querySelector('.active-ads');
                let a_Ads = document.querySelector('.a-ads');
                let xAds = document.querySelector('.x-ads');
                let subs = document.querySelector('.subs');

                fetch('/md/index')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const dashboard = data.data;
                            console.log(data);

                            // Update UI
                            activeApps.textContent = dashboard.activeApps;
                            a_Apps.textContent = dashboard.activeApps;
                            xApps.textContent = dashboard.xApps;
                            activeAds.textContent = dashboard.activeAds;
                            a_Ads.textContent = dashboard.activeAds;
                            xAds.textContent = dashboard.xAds;
                            subs.textContent = dashboard.subs;
                        } else {
                            console.error('Failed to fetch data');
                        }
                    })
                    .catch(err => {
                        console.error('Error fetching dashboard data:', err);
                    });
            });
        </script>
    </div>
</x-app-layout>