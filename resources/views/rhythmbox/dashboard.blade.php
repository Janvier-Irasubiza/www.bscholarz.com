@section('title', 'RB-A')

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
                Business Revenue
                </div>
                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                

                <!-- <a href="{{ route('admin.transfer') }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm btn btn-primary">
                <span class="mr-2 opacity-7">
                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                </span>
                <span class="mr-1">Make transfer</span>
                </a> -->


                </div>
                </div>
                <div class="no-gutters row px-2 py-3">
                <div class="col-sm-6 col-md-4 col-xl-4">
                <div style="border: none" class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #ec6c55bd;">
                <i class="fa-solid fa-person-booth" style="font-size: 25px"></i></div></div>
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Applications <small>(RWF)</small></div>
                <div class="widget-numbers">{{ number_format($app_incomes -> sum('amount_paid')) }}</div>
                <div class="widget-description opacity-8 text-focus">
                <div class="d-inline text-danger pr-1">

                <!-- <i class="fa fa-angle-down"></i>
                <span class="pl-1">54.1%</span> -->

                </div>
                @if(count($todayApps) > 0) {{ number_format(count($todayApps)) }} @else No @endif apps today <small>(</small>{{ number_format($todayApps -> sum('amount_paid')) }}<small>) - @if($assistantsCommission -> commission > 0) commisions: {{ number_format($assistantsCommission -> commission) }} @else No debt @endif</small>
                </div>
                </div>
                </div>
                </div>
                <div class="divider m-0 d-md-none d-sm-block"></div>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-4">
                <div style="border: none"  class="card no-shadow rm-border bg-transparent widget-chart text-left">
                <div class="d-flex">
                <div class="icon-wrapper col-lg-3 d-flex align-items-center justify-content-center mr-1">
                <div class="icon-wrapper-bg opacity-9 rounded-circle p-3" style="background: #5AB8A4;">
                <i class="fa-solid fa-rectangle-ad" style="font-size: 25px"></i></div></div>
                <div style="" class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Ads <small>(RWF)</small></div>
                <div class="widget-numbers"><span>{{ number_format($ads -> sum('amount_gen')) }}</span></div>
                <div class="widget-description opacity-8 text-focus">
                @if(count($todayAds) > 0) {{ number_format(count($todayAds)) }} @else No @endif new client<small></small> today
                <span class="text-info pl-1">

                <!-- <i class="fa fa-angle-down"></i>
                <span class="pl-1">14.1%</span> -->
                
                </span>
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
                <i class="fa-solid fa-sack-dollar" style="font-size: 25px"></i></div>
                </div>
                <div class="widget-chart-content col-lg-9 ml-1">
                <div class="widget-subheading">Balance <small>(RWF)</small></div>
                <div class="widget-numbers text-success"><span>{{ number_format(Auth::guard('rhythmbox') -> user() -> pending_amount) }}</span></div>
                <div class="widget-description text-focus">

                <p class="mb-0" style="font-weight: 600">Received Funds: {{ number_format($received_amount -> paid_amount) }} <smaLL>(RWF)</smaLL></p>

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

<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-3 mb-5">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-apps" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><i class="icon icon-anim-pulse fa-solid fa-person-booth"></i> &nbsp; Apps</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-ads" type="button" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fa-solid fa-rectangle-ad"></i> &nbsp; Adverts</button>
    <!-- <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-transfers" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Money Transfers</button> -->
  </div>

<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-apps" role="tabpanel" aria-labelledby="nav-apps-tab">
  
  <div class="info-div mt-3 mb-4">
    <table id="" class="table align-middle mb-0 bg-white">
        <thead class="bg-light">

        <tr>
            <th>Applicant</th>
            <th>Application</th>
            <th>Assistant</th>
            <th>Served On</th>
            <th class="text-left">Amount paid</th>
            </tr>

        </thead>
        <tbody>

        @foreach ($app_incomes as $request) 
        <tr>
        <td>
            <div class="d-flex align-items-center">
            <div class="">
                <p class="fw-bold mb-1">{{ $request -> names }}</p>
                <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> email }}</p>
                <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> phone_number }}</p>
            </div>
            </div>
        </td>
        <td>
            <p class="fw-normal mb-1">{{ $request -> discipline_name }}</p>
            <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> discipline_organization }}</p>
        </td>

        <td>
            <p class="fw-normal mb-1">{{ $request -> assistant_names }}</p>
            <p class="text-muted mb-0" style="font-size: 13px">{{ $request -> assistant_phone_number }}</p>

        </td>

        <td>
            <p class="fw-normal mb-1">{{ $request -> served_on }}</p>
        </td>

        <td class="text-left">
        <p class="fw-normal mb-1">{{ number_format($request -> amount_paid) }} RWF</p>
            <p class="text-muted mb-0" style="font-size: 13px"> Outstanding amount: {{ number_format(floatval($request -> service_fee) - floatval($request -> amount_paid)) }}</p>
                </a>
        </td>
        </tr>

            @endforeach
            
        </tbody>
    </table>

  </div>

  </div>

  <div class="tab-pane fade" id="nav-ads" role="tabpanel" aria-labelledby="nav-ads-tab">

  <div class="info-div mt-3 mb-4">
  <table id="" class="table align-middle mb-0 bg-white">
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
                    <p class="fw-bold mb-1">{{ $ad -> title }}</p>
                    <p class="text-muted mb-0" style="font-size: 13px">African Leadership University</p>
                </div>
                </div>
                </td>
                <td>
                <p class="fw-normal mb-1">{{ $ad -> type }}</p>
                </td>

                <td>
                <p class="mb-0">{{ $ad -> expiry_date }}</p>
                <p class="text-muted mb-0" style="font-size: 13px">Started On: {{ $ad -> posted_on }}</p>
                </td>

                <td class="" >
                {{ number_format($ad -> amount) }}
                <p class="text-muted mb-0" style="font-size: 13px">{{ $ad -> payment_circle }}</p>
                    </td>

                <td class="text-right" >
                {{ number_format($ad -> amount_gen) }} RWF
                </td>

                </tr>

                @endforeach
            </tbody>
        </table>
  </div>

  </div>
  
  <div class="tab-pane fade" id="nav-transfers" role="tabpanel" aria-labelledby="nav-transfers-tab">
  
  <div class="info-div mt-3 mb-4">
    No content
  </div>

  </div>

</div>
</div>


</div>

</x-rhythm-box>

