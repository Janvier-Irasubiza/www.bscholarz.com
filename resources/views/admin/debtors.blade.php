@section('title', '{{ $member -> names }} sheet')

<x-app-layout>

<x-slot name="header">
</slot>

<div style="padding: 0px 20px 32px 20px" class="mb-4">
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2 mb-4">
                    <div class="app-inner-layout__content">
                    <div class="tab-content">
                    <div>
                    <div class="card">
                    <div class="card-header-tab card-header py-3 d-flex">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-7">
                    Debtors sheet  <br>
                    <p class="text-muted mb-0">Clients who have refused to pay </p>

                    </div>
                    <div class="btn-actions-pane-right d-flex flex-row-reverse text-capitalize col-lg-5">

                    <div class="widget-chart-content ml-2 px-3">
                    <div class="widget-subheading">Debts Amount <small>(RWF)</small></div>

                    <div class="widget-numbers text-success"><span style="font-weight: 600">{{ number_format($debtors -> sum('amount_not_paid')) }}</span></div>
                    </div>

                    <div class="icon-wrapper d-flex align-items-center justify-content-center">
                    <div class="icon-wrapper-bg opacity-9 rounded-circle" style="background: #80ffaa; padding: 15px 17px">
                    <i class="fa-solid fa-sack-dollar" style="font-size: 25px"></i></div>
                    </div>

                    </div>
                    </div>
                    </div>

                    <form action="{{ route('admin.pay-assistant') }}" method="post"> @csrf

                    <div style="border-top: none" class="d-block p-3 card-footer">

                    <div class="info-div mt-3 mb-4">

                    <table id="example1" class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">

                        <tr>
                            <th>Applicant</th>
                            <th>Application</th>
                            <th>Assistant</th>
                            <th>Served on</th>
                            <th>Service fee</th>
                            <th class="text-left">Amount not paid</th>
                            </tr>

                        </thead>
                        <tbody>

                        @foreach ($debtors as $request)
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

                        <td>
                            <p class="fw-normal mb-1">{{ number_format($request -> service_fee) }} RWF</p>
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
                        <p class="fw-normal mb-1">{{ number_format($request -> amount_not_paid) }} RWF</p>
                        <p class="text-muted mb-0" style="font-size: 13px"> Paid amount: {{ number_format($sum) }}</p>
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
