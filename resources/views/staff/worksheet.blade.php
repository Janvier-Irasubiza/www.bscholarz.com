@section('title', 'Staff - Worksheet')

<x-staff-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px" class="mb-4">
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 mb-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg font-weight-normal col-lg-7">
                    {{ Auth::guard('staff') -> user() -> names }}<br>
                    <p class="text-muted mb-0">{{ Auth::guard('staff') -> user() -> email }}</p>
                    <p class="text-muted mb-0">{{ Auth::guard('staff') -> user() -> phone_number }}</p>

                    </div>
                    <div class="btn-actions-pane-right d-flex flex-row-reverse text-capitalize col-lg-5">

                    <div class="widget-chart-content ml-2 px-3">
                    <div class="widget-subheading">Balance <small>(RWF)</small></div>

                    <div class="widget-numbers text-success"><span style="font-weight: 600">{{ number_format($my_funds -> commission) }}</span></div>
                    </div>

                    <div class="icon-wrapper d-flex align-items-center justify-content-center">
                    <div class="icon-wrapper-bg opacity-9 rounded-circle" style="background: #80ffaa; padding: 15px 17px">
                    <i class="fa-solid fa-sack-dollar" style="font-size: 25px"></i></div>
                    </div>

                    </div>                    
                    </div>
                    </div>

                    <form action="" method="post"> 
                    @csrf

                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <div class="d-flex">                    

                    <div class="col-lg-5">
                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" :value="__('Recordings')" />
                    <p class="text-muted mb-0" style="font-size: 13px">Served requests by </p>
                    </div>

                    <div class="col-lg-3 d-flex gap-2">
                        <a href="{{ route('sort-recs-this-week', ['assistant' => Auth::guard('staff') -> user() -> id]) }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3" style="color: #000; background: #cccccc">This month</span>
                            </p>
                        </a>

                        <a href="{{ route('sort-recs-all', ['assistant' => Auth::guard('staff') -> user() -> id]) }}">
                            <p class="fw-normal mb-1">
                                <span class="badge rounded-pill px-3" style="color: #000">All applications</span>
                            </p>
                        </a>

                    </div>

                    <div class="col-lg-4 d-flex flex-row-reverse gap-2">

                    </div>

                    </div>


                    <div class="info-div mt-3 mb-4">
                    
                    <table class="table align-middle mb-0 bg-white" id="example1">
                        <thead class="bg-light">

                        <tr>
                            <th>Applicant</th>
                            <th>Application</th>
                            <th>Served On</th>
                            <th class="text-left">Payment(RWF)</th>
                            <th class="text-left">Commission</th>
                            <th class="text-left">Status</th>
                            </tr>

                        </thead>
                        <tbody>

                        @foreach($my_applications as $application)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="fw-bold mb-1">{{ $application -> names }}</p>
                                    <p class="text-muted mb-0" style="font-size: 13px">{{ $application -> email }}</p>
                                    <p class="text-muted mb-0" style="font-size: 13px">{{ $application -> phone_number }}</p>
                                </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">{{ $application -> discipline_name }}</p>
                                <p class="text-muted mb-0" style="font-size: 13px">{{ $application -> discipline_organization }}</p>
                            </td>

                            <td>
                                <p class="fw-normal mb-1">{{ $application -> served_on }}</p>
                            </td>

                            <td class="text-left">
                            <p class="fw-normal mb-1">Paid: <strong>{{ number_format($application -> amount_paid) }}</strong></p>
                            <p class="fw-normal mb-1"> O/S: <strong>{{ number_format($application -> outstanding_amount) }}</strong></p>
                            </td>

                            <td class="text-left">
                            <p class="fw-normal mb-1">Paid: <strong>{{ number_format($application -> assistant_paid_commission) }}</strong></p>
                            <p class="fw-normal mb-1">O/S: <strong>{{ number_format($application -> assistant_pending_commission) }}</strong></p>

                            </td>

                            <td class="text-left">

                            <p class="fw-normal mb-1">
                            <span class="badge bg-success rounded-pill px-3">{{ $application -> remittance_status }}</span>
                            </p>

                            </td>

                            </tr>
                          @endforeach
                            
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
</x-app-layout>
