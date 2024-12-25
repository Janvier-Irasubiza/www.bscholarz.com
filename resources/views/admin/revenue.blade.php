@section('title', 'Revenue')

<x-app-layout>

    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">
                            <div class="card-header-tab card-header py-3 d-flex">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                                    Overview
                                </div>
                            </div>
                            <div class="no-gutters flex-section justify-content-between gap-2 px-3 py-3" style="padding-right: 32px !important">
                                <div class="sum-card rounded p-2 col-lg-4 pb-3">
                                    <h1 class="card-header-title fw-700 text-center f-20">Business Revenues</h1>
                                    <div class="d-flex justify-content-start align-items-start px-2 gap-3 mt-1">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 text-center justify-content-center d-flex flex-column mt-1" style="height: 100px;">
                                            <h4>Total Income</h4>
                                            <div class="widget-numbers">{{ number_format($total_revenues) }} K</div>
                                        </div>
                                        <!-- Right Column -->
                                        <div class="justify-content-center col-lg-6 d-flex flex-column align-items-start justify-content-start" style="height: 100px; padding: 10px;">
                                            <div>
                                                <small style="font-size: 10px">Today</small>
                                                <div style="font-size: 13px"><strong>{{ number_format($today_revenues) }} &nbsp; RWF</strong></div>
                                            </div>
                                            <div class="mb-1">
                                                <small style="font-size: 10px">This week</small>
                                                <div style="font-size: 13px"><strong>{{ number_format($this_week_revenues) }} &nbsp; RWF</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="sum-card rounded p-2 col-lg-4 pb-3" style="margin-right: 0px">
                                    <h1 class="card-header-title fw-700 text-center f-20">Business Productivity</h1>
                                    <div class="d-flex justify-content-start align-items-start px-2 gap-3 mt-1">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 text-center justify-content-center d-flex flex-column mt-1" style="height: 100px;">
                                            <h4>Service Requests</h4>
                                            <div class="widget-numbers">{{ number_format($total_requests) }}</div>
                                        </div>
                                        <!-- Right Column -->
                                        <div class="justify-content-center col-lg-6 d-flex flex-column align-items-start justify-content-start" style="height: 100px; padding: 10px;">
                                            <div>
                                                <small style="font-size: 10px">Today</small>
                                                <div style="font-size: 13px"><strong>{{ number_format($today_requests) }} &nbsp; Requests</strong></div>
                                            </div>
                                            <div class="mb-1">
                                                <small style="font-size: 10px">This week</small>
                                                <div style="font-size: 13px"><strong>{{ number_format($this_week_requests) }} &nbsp; Requests</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="sum-card rounded p-2 col-lg-4 pb-3">
                                    <h1 class="card-header-title fw-700 text-center f-20">Business Store</h1>
                                    <div class="d-flex justify-content-start align-items-start px-2 gap-3 mt-1">
                                        <!-- Left Column -->
                                        <div class="col-lg-6 text-center justify-content-center d-flex flex-column mt-1" style="height: 100px;">
                                            <h4>Total Services</h4>
                                            <div class="widget-numbers">{{ number_format($total_services) }}</div>
                                        </div>
                                        <!-- Right Column -->
                                        <div class="justify-content-center col-lg-6 d-flex flex-column align-items-start justify-content-start" style="height: 100px; padding: 10px;">
                                            <div>
                                                <small style="font-size: 10px">Ready</small>
                                                <div style="font-size: 13px"><strong>{{ number_format($ready_services) }} &nbsp; Services</strong></div>
                                            </div>
                                            <div class="mb-1">
                                                <small style="font-size: 10px">Upcoming</small>
                                                <div style="font-size: 13px"><strong>{{ number_format($upcoming_services) }} &nbsp; Services</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
                <div class="app-inner-layout__content">
                    <div class="tab-content">
                        <div>
                            <div class="card" style="border: none">
                                <div class="card-body">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#applications" type="button" role="tab" aria-controls="home" aria-selected="true">
                                                <i class="fa-solid fa-person-booth fa-fw me-2"></i> Applications
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#ads" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                                <i class="fa-solid fa-rectangle-ad fa-fw me-2"></i> Ads
                                            </button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="applications" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="px-2 py-2">
                                                <table id="example1" class="table align-middle mb-0 bg-white">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Applicant</th>
                                                            <th>Application</th>
                                                            <th>Assistant</th>
                                                            <th>Served on</th>
                                                            <th class="text-left">Amount paid</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($app_incomes as $request)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="">
                                                                        <p class="fw-bold mb-1">{{ $request->names }}</p>
                                                                        <p class="text-muted mb-0" style="font-size: 13px">{{ $request->email }}</p>
                                                                        <p class="text-muted mb-0" style="font-size: 13px">{{ $request->phone_number }}</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="fw-normal mb-1">{{ $request->discipline_name }}</p>
                                                                <p class="text-muted mb-0" style="font-size: 13px">{{ $request->discipline_organization }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="fw-normal mb-1">{{ $request->assistant_names }}</p>
                                                                <p class="text-muted mb-0" style="font-size: 13px">{{ $request->assistant_phone_number }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="fw-normal mb-1">{{ $request->served_on }}</p>
                                                            </td>

                                                            @php
                                                            $atdg_amt_exp = explode(';', $request->outstanding_paid_amount);
                                                            $sum = 0;
                                                            foreach ($atdg_amt_exp as $key => $value) {
                                                                $number = explode('=>', $value);
                                                                $sum += intval($number[0]);
                                                            }
                                                            @endphp

                                                            <td class="text-left">
                                                                <p class="fw-normal mb-1">{{ number_format(intval($request->amount_paid) + $sum) }} RWF</p>
                                                                <p class="text-muted mb-0" style="font-size: 13px"> Outstanding amount: {{ number_format(floatval($request->service_fee) - (intval($request->amount_paid) + $sum)) }}</p>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="ads" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="px-2 py-2">
                                                <table id="example1" class="table align-middle mb-0 bg-white">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Ad</th>
                                                            <th>Type</th>
                                                            <th>Due Date</th>
                                                            <th>Amount</th>
                                                            <th class="text-right">Amount Generated</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($ads as $ad)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="">
                                                                        <p class="fw-bold mb-1">{{ $ad->title }}</p>
                                                                        <p class="text-muted mb-0" style="font-size: 13px">African Leadership University</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="fw-normal mb-1">{{ $ad->type }}</p>
                                                            </td>
                                                            <td>
                                                                <p class="mb-0">{{ $ad->expiry_date }}</p>
                                                                <p class="text-muted mb-0" style="font-size: 13px">Started On: {{ $ad->posted_on }}</p>
                                                            </td>
                                                            <td>
                                                                {{ number_format($ad->amount) }}
                                                                <p class="text-muted mb-0" style="font-size: 13px">{{ $ad->payment_circle }}</p>
                                                            </td>
                                                            <td class="text-right">
                                                                {{ number_format($ad->amount_gen) }} RWF
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="transfers" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="px-2 py-2">
                                                <table id="example1" class="table align-middle mb-0 bg-white">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Amount</th>
                                                            <th class="text-right">Transferred on</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 45px; height: 45px" class="rounded-circle"/>
                                                                    <div class="ms-3">
                                                                        <p class="fw-bold mb-1">Undergraduate</p>
                                                                        <p class="text-muted mb-0">African Leadership University</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0">02 Oct, 2023</p>
                                                            </td>
                                                            <td class="text-right">
                                                                <p class="text-muted mb-0">4000</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 45px; height: 45px" class="rounded-circle"/>
                                                                    <div class="ms-3">
                                                                        <p class="fw-bold mb-1">Undergraduate</p>
                                                                        <p class="text-muted mb-0">African Leadership University</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="text-muted mb-0">02 Oct, 2023</p>
                                                            </td>
                                                            <td class="text-right">
                                                                <p class="text-muted mb-0">7000</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" alt="" style="width: 45px; height: 45px" class="rounded-circle"/>
                                                                    <div class="ms-3">
                                                                        <p class="fw-bold mb-1">Undergraduate</p>
                                                                        <p class="text-muted mb-0">African Leadership University</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <p class="fw-normal mb-1">USA</p>
                                                            </td>
                                                            <td class="text-right">
                                                                <p class="text-muted mb-0">5000</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
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
