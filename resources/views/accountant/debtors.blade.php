@section('title', 'Pending Payments')

<x-accountant-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">
                            <div class="card-header-tab card-header py-3 d-flex">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                                    <strong>Outstanding Payments</strong>
                                </div>
                                <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                                </div>
                            </div>
                            <div style="border-top: none" class="d-block p-3 card-footer">
                                <table class="table align-middle mb-0 bg-white" id="example1">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Deptor Info</th>
                                            <th>Unpaid Service</th>
                                            <th>Unpaid Amount</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($unpaid_applications as $dept)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center" style="margin: 0px">
                                                    <div class="" style="padding: 0px 5px">
                                                        <p class="fw-bold mb-1">{{ $dept -> deptor_names }}</p>
                                                        <p class="text-muted mb-0">{{ $dept -> deptor_email }} <br> {{ $dept -> deptor_phone }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="margin: 0px">
                                                    <div class="" style="padding: 0px 5px">
                                                        <p class="fw-bold mb-1">{{ $dept -> application_name }}</p>
                                                        <p class="text-muted mb-0">{{ $dept -> application_org }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1"><strong>{{ $dept -> outstanding_amount}}</strong> </p>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="action-btn mr-1">
                                                        <button type="button" class="btn btn-link btn-sm btn-rounded action-btn debtorId" style="text-decoration: none; background-color: #0D6EFD; color: white; border-radius: 20px;">
                                                            Remind
                                                        </button>
                                                    </div>
                                                    <div class="action-btn ml-1">
                                                        <a href="{{ route('transaction-review', ['transaction' => $dept->app_id, 'applicant' => $dept->applicant, 'application' => $dept->discipline_id, 'agent' => $dept->assistant]) }}" class="btn btn-link btn-sm btn-rounded clientId" value="application_id" style="text-decoration: none; background-color: #80ffaa; color: black; border-radius: 20px;">
                                                            Rewiew
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-accountant-layout>
