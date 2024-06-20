@section('title', '{{ $member -> names }} sheet')

<x-rhythm-box>

<x-slot name="header">
</slot>

<div class="py-2" style="padding: 0px 80px 0px 98px">
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-5 mb-5">
<div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-7">
                    <div class="widget-subheading">{{ $member -> names }}  </div>
                    <p class="text-muted mb-0">{{ $member -> email }} </p>
                    <p class="text-muted mb-0">{{ $member -> phone_number }} </p>

                    </div>
                    <div class="btn-actions-pane-right d-flex flex-row-reverse text-capitalize col-lg-5">

                    <div class="widget-chart-content ml-2 px-3">
                    <div class="widget-subheading">Balance <small>(RWF)</small></div>

                    <div class="widget-numbers text-success"><span style="font-weight: 600">{{ number_format($balance -> sum('assistant_pending_commission')) }}</span></div>
                    </div>

                    <div class="icon-wrapper d-flex align-items-center justify-content-center">
                    <div class="icon-wrapper-bg opacity-9 rounded-circle" style="background: #80ffaa; padding: 15px 17px">
                    <i class="fa-solid fa-sack-dollar" style="font-size: 25px"></i></div>
                    </div>

                    </div>                    
                    </div>
                    </div>

                    <form action="{{ route('admin.pay-assistant') }}" method="post"> @csrf

                    <input type="text" name="assistant" value="{{ $member -> id }}" hidden>

                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <div class="d-flex">                    

                    <div class="col-lg-5">
                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Recordings')" />
                    <p class="text-muted mb-0" style="font-size: 13px">Served requests by {{ $member -> names }} </p>
                    </div>

                    <div class="col-lg-3 d-flex gap-2">
                        <a href="{{ route('rhythmbox.sort-recs-this-week', ['assistant' => $member -> id]) }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3" style="color: #000; background: #cccccc">This week</span>
                            </p>
                        </a>

                        <a href="{{ route('rhythmbox.sort-recs-all', ['assistant' => $member -> id]) }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3" style="color: #000">All applications</span>
                            </p>
                        </a>

                    </div>

                    </div>

                    <div class="info-div mt-3 mb-4">
                    
                    <table id="table" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">

                        <tr>
                            <th>Applicant</th>
                            <th>Application</th>
                            <th>Served On</th>
                            <th class="text-left">Amount paid</th>
                            <th class="text-center">Commission</th>
                            </tr>

                        </thead>
                        <tbody>

                        @foreach ($completedApp as $request) 

                        @if($request -> remittance_status == 'Paid')    

                        <tr style="background: #ca11112f;">

                        @else

                        <tr>

                        @endif
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
                                <p class="fw-normal mb-1">{{ $request -> served_on }}</p>
                            </td>


                            @php

                                $atdg_amt_exp = explode(';', $request -> outstanding_paid_amount);      

                                $sum = 0;

                                foreach ($atdg_amt_exp as $key => $value) {

                                    $number = explode('=>', $value);
                                    $sum += intval($number[0]);
                                    
                                }

                            @endphp

                            <td class="text-left">
                            <p class="fw-normal mb-1">{{ number_format(intval($request -> amount_paid) + $sum) }} RWF</p>
                                <p class="text-muted mb-0" style="font-size: 13px"> Outstanding amount: {{ number_format(floatval($request -> service_fee) - (intval($request -> amount_paid) + $sum)) }}</p>
                            </td>

                            <td class="text-center">
                            <p class="fw-normal mb-1">@if($request -> assistant_pending_commission > 0) {{ number_format($request -> assistant_pending_commission) }} @else {{ number_format($request -> assistant_paid_commission) }} @endif <small>RWF</small></p>

                            @if($request -> remittance_status == 'Paid')
                            <p class="fw-normal mb-1">
                            <span class="badge bg-success rounded-pill px-3">{{ $request -> remittance_status }}</span>
                            </p>
                            @else
                            <p class="fw-normal mb-1">
                            <span class="badge bg-secondary rounded-pill px-3">{{ $request -> remittance_status }}</span>
                            </p>
                            @endif 

                            </td>

                            </tr>

                            @endforeach

                            <tr>

                            <td colspan="3">
                            <th>Sum <p class="text-muted mb-0" style="font-size: 13px"> To be disbursed </p> </th>
                            </td>

                            <td>
                                <p class="fw-normal mb-1 text-center">{{ number_format($completedApp -> sum('assistant_pending_commission')) }} <small>RWF</small></p>
                            </td>

                            </tr>
                            
                        </tbody>
                    </table>
                    
                    </div>
               
                    </div>

                    </form>

                    </div>
                    </div>
                    </div>
                    
                    

    </div>
</div>

<script>

    var table = $('#table').DataTable();
    table.row(':eq(0)', { page: 'current' }).select();
    table.row(':eq(0)', { page: 'current' }).deselect();

</script>

</x-rhythm-box>