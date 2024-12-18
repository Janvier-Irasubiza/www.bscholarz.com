@section('title', 'Pending Payments')

<x-accountant-layout>
    <x-slot name="header"></x-slot>

    <div style="padding: 0px 20px 32px 20px">
        <!-- Outstanding Payments Section -->
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
                                    <a href="{{ route('accountant-deptors', ['download' => 'excel']) }}"
                                        class="btn btn-primary" id="exportExcel">Export to Excel</a>
                                </div>
                            </div>
                            <div style="border-top: none" class="d-block p-3 card-footer">
                                <table class="table align-middle mb-0 bg-white" id="example1">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Debtor Info</th>
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
                                                            <p class="fw-bold mb-1">{{ $dept->names }}</p>
                                                            <p class="text-muted mb-0">{{ $dept->email }} <br>
                                                                {{ $dept->phone_number }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="margin: 0px">
                                                        <div class="" style="padding: 0px 5px">
                                                            <p class="fw-bold mb-1">{{ $dept->discipline_name }}</p>
                                                            <p class="text-muted mb-0">
                                                                {{ $dept->discipline_organization }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="fw-normal mb-1">
                                                        <strong>{{ $dept->outstanding_amount }}</strong> </p>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <div class="action-btn mr-1">
                                                            <a href="{{ route('remind-debtor', ['transaction' => $dept->application_id]) }}"
                                                                type="button"
                                                                class="btn btn-link btn-sm btn-rounded action-btn debtorId"
                                                                style="text-decoration: none; background-color: #0D6EFD; color: white; border-radius: 20px;">
                                                                Remind
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

        <!-- Show Reminded Table Button -->
        <div class="text-left mt-4">
            <button id="toggleRemindedTable" class="btn btn-primary">Show Reminded Debtors</button>
        </div>

        <!-- Reminded Debtors Section -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-4 d-none" id="remindedTableContainer">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">
                            <div class="card-header-tab card-header py-3 d-flex">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-8">
                                    <strong>Reminded Debtors</strong>
                                </div>
                            </div>
                            <div style="border-top: none" class="d-block p-3 card-footer">
                                <table class="table align-middle mb-0 bg-white" id="remindedDebtorsTable">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Debtor Info</th>
                                            <th>Unpaid Service</th>
                                            <th>Unpaid Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reminded_debtors as $unpaid_dept)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center" style="margin: 0px">
                                                        <div class="" style="padding: 0px 5px">
                                                            <p class="fw-bold mb-1">{{ $unpaid_dept->names }}</p>
                                                            <p class="text-muted mb-0">{{ $unpaid_dept->email }} <br>
                                                                {{ $unpaid_dept->phone_number }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="margin: 0px">
                                                        <div class="" style="padding: 0px 5px">
                                                            <p class="fw-bold mb-1">{{ $unpaid_dept->discipline_name }}</p>
                                                            <p class="text-muted mb-0">
                                                                {{ $unpaid_dept->discipline_organization }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="fw-normal mb-1">
                                                        <strong>{{ $unpaid_dept->outstanding_amount }}</strong> </p>
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

        <!-- Success/Error Modals -->
        @if (session('success'))
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog text-center">
                    <div class="modal-content">
                        <div class="modal-body text-success fw-bold">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog text-center">
                    <div class="modal-content">
                        <div class="modal-body text-danger fw-bold">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#remindedDebtorsTable').DataTable({
                lengthChange: false, // Remove "Show entries" dropdown (length menu)
                pageLength: 10, // Optional: Set the default number of rows displayed
            });

            // Toggle Reminded Table Visibility
            $('#toggleRemindedTable').on('click', function () {
                const container = $('#remindedTableContainer');
                container.toggleClass('d-none'); // Toggle visibility
                $(this).text(container.hasClass('d-none') ? 'Show Reminded Debtors' : 'Hide Reminded Debtors');
            });

            // Handle modals for success or error
            @if (session('success'))
                $('#errorModal').modal('hide');
                $('#successModal').modal('show');
            @elseif (session('error'))
                $('#errorModal').modal('show');
                $('#successModal').modal('hide');
            @endif
        });
    </script>
</x-accountant-layout>
