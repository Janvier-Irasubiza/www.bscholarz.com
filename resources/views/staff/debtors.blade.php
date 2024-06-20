@section('title', 'My Work Sheet')

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
                    <h1 style="font-size: 25px"><strong>{{ $debtor -> names }}</strong></h1>
                    <p class="text-muted mb-0" style="font-size: 20px">{{ $debtor -> email }} </p>
                    <p class="text-muted mb-0" style="font-size: 18px">{{ $debtor -> phone_number }}</p>

                    </div>
                    </div>

                    <form action="" method="post"> @csrf

                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <div class="d-flex">                    

                    <div class="col-lg-5">
                    <x-input-label style="font-size: 17px; font-weight: 600" for="name" value="Debts as per unpaid application (s)" />
                    </div>

                    <div class="col-lg-4 d-flex flex-row-reverse gap-2">
                        

                    </div>

                    </div>


                    <div class="info-div mt-3 mb-4">
                    
                    <table id="table" class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">

                        <tr>
                            <th>Application Info</th>
                            <th>Date of Application</th>
                            <th>Application Fee</th>
                            <th>Paid Fee</th>
                            <th>Application Assistant</th>
                            <th class="text-left">Loan (RWF)</th>
                        </tr>

                        </thead>
                        <tbody>

                        @foreach ($debts as $application) 
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="fw-bold mb-1">{{ $application -> discipline_name }}</p>
                                    <p class="text-muted mb-0" style="font-size: 13px">{{ $application -> discipline_organization }} - {{ $application -> discipline_country}}</p>
                                </div>
                                </div>
                            </td>
                            <td>
                            <p class="fw-normal mb-1">Request: {{ $application -> requested_on }}</p>
                            <p class="fw-normal mb-1">Service: {{ $application -> served_on }}</p>
                            </td>

                            <td>
                                <p class="fw-normal mb-1">{{ number_format($application -> service_fee) }}</p>
                            </td>

                            <td class="text-left">
                            <p class="fw-normal mb-1">{{ number_format($application -> amount_paid) }}</p>
                            </td>

                            <td class="text-left">
                            <p class="fw-normal mb-1">{{ $application -> assistant_names }}</p>

                            </td>

                            <td class="text-left">

                            <p class="fw-normal mb-1"><strong style="color: red">{{ number_format($application -> amount_not_paid) }}</strong></p>

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