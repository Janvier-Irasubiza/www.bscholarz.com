@section('title', 'Transactions')

<x-accountant-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-2 mt-2">
            <div class="app-inner-layout__content">
                <div class="tab-content">
                    <div>
                        <div class="card">
                            <div class="card-header-tab card-header">
                                Complete Transactions
                                <div class="d-flex py-3">
                                    <form method="GET" action="{{ route('sort-complete-apps') }}" style="display: contents;">
                                        <div class="sort-sect col-lg-8 d-flex gap-2">
                                            <div class="btn btn-primary" id="sortButton" onclick="showSortOptions()">
                                                Sort Entries
                                            </div>
                                            <div class="col-lg-3" id="sortByContainer" style="display: none;">
                                                <select id="sortBy" name="sortBy" class="w-full" required style="border: 2px solid; border-radius: 7px; font-size: 14px; padding: 5px 5px" onchange="showRelevantInputs()">
                                                    <option value="">Sort By</option>
                                                    <option value="date" {{ $sortBy == 'date' ? 'selected' : '' }}>Date</option>
                                                    <option value="employee" {{ $sortBy == 'employee' ? 'selected' : '' }}>Employee</option>
                                                    <option value="application" {{ $sortBy == 'application' ? 'selected' : '' }}>Application</option>
                                                </select>
                                            </div>
                                            <div id="employeeInput" class="col-lg-4" style="display: none;">
                                                <select id="employee" name="employee" class="w-full" style="border: 2px solid; border-radius: 7px; font-size: 14px; padding: 5px 5px">
                                                    <option value="">Select Employee</option>
                                                    @foreach ($employees as $staff)
                                                    <option value="{{ $staff->id }}" {{ $employee == $staff->id ? 'selected' : '' }}>{{ $staff->names }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div id="applicationInput" class="col-lg-4" style="display: none;">
                                                <select id="application" name="application" class="w-full" style="border: 2px solid; border-radius: 7px; font-size: 14px; padding: 5px 5px">
                                                    <option value="">Select Application</option>
                                                    @foreach ($complete_transactions_unique as $app)
                                                    <option value="{{ $app->discipline_identifier }}" {{ $application == $app->discipline_identifier ? 'selected' : '' }}>{{ $app->discipline_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div id="dateInputs" class="col-lg-5 d-flex gap-2" style="display: none !important">
                                                <div>
                                                    <x-input-label for="start_date" :value="__('From')" style="font-size: 10px; margin-top: -7px"/>
                                                    <input class="block w-full px-1 p-0" type="date" name="start_date" id="start_date" value="{{ $startDate }}" style="padding: 6px 10px; border: 2px solid #4d4d4d; border-radius: 6px; margin-top: -4px; color: #808080;"/>
                                                </div>
                                                <div>
                                                    <x-input-label for="end_date" :value="__('To')" style="font-size: 10px; margin-top: -7px"/>
                                                    <input class="block w-full px-1 p-0" type="date" name="end_date" id="end_date" value="{{ $endDate }}" style="padding: 6px 10px; border: 2px solid #4d4d4d; border-radius: 6px; margin-top: -4px; color: #808080;"/>
                                                </div>
                                            </div>
                                            <div id="sortBtn" class="sort-btn" style="display: none">
                                                <button class="border bg-success px-2 py-1 rounded text-white" style="margin-top: 2px">Sort</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="btn-actions-pane-right text-capitalize text-right col-lg-4">
                                        <a href="{{ route('export.transactions', ['download' => 'excel', 'type' => 'complete']) }}" class="btn btn-primary" id="exportExcel">Export to Excel</a>
                                    </div>
                                </div>

                            </div>
                            <div style="border-top: none" class="d-block p-3 card-footer"> here
                                <table id="example1" class="table align-middle mb-0 bg-white">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Amount Paid</th>
                                            <th>Payment Date</th>
                                            <th>Assistant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($complete_transactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="">
                                                        <p class="fw-normal mb-1">{{ $transaction->payment_id }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">{{ $transaction->amount_paid }}</p>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">{{ $transaction->served_on }}</p>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1">{{ $transaction->assistant_names }}</p>
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

            <!-- Load Scripts -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

            <script>
                // Initialize DataTable with buttons
                $(document).ready(function() {

                    // Keep selected options visible
                    const sortBy = '{{ $sortBy }}';
                    const employee = '{{ $employee }}';
                    const application = '{{ $application }}';

                    if (sortBy) {
                        $('#sortByContainer').show();
                        $('#sortBy').val(sortBy);
                        showRelevantInputs(); // Show the relevant inputs based on sortBy value
                    }

                    if (employee) {
                        $('#employeeInput').show();
                        $('#employee').val(employee);
                    }

                    if (application) {
                        $('#applicationInput').show();
                        $('#application').val(application);
                    }

                    // Export to Excel functionality
                    document.getElementById('exportExcel').addEventListener('click', function () {
                        // Create a new workbook and add a worksheet
                        const wb = XLSX.utils.book_new();

                        // Get the table data and convert it to a worksheet
                        const ws = XLSX.utils.table_to_sheet(document.getElementById('example1'));

                        // Append the worksheet to the workbook
                        XLSX.utils.book_append_sheet(wb, ws, 'Pending Transactions');

                        // Write the workbook to a file
                        XLSX.writeFile(wb, 'Pending_Transactions.xlsx');
                    });


                    // Add event listeners to show the sort button when inputs change
                    $('#sortBy, #employee, #application, #start_date, #end_date').on('change', function() {
                        $('#sortBtn').show();
                    });

                    $('#sortBy').on('change', function() {
                        $('#employee').val('');
                        $('#application').val('');
                        $('#start_date').val('');
                        $('#end_date').val('');
                        $('#sortBtn').show();
                    })
                });

                // Show the sort options when the button is clicked
                function showSortOptions() {
                    document.getElementById('sortByContainer').style.display = 'block';
                    document.getElementById('sortBtn').style.display = 'block';
                }

                // Show relevant inputs based on sorting selection
                function showRelevantInputs() {
                    document.getElementById('dateInputs').style.setProperty('display', 'none', 'important');
                    document.getElementById('employeeInput').style.display = 'none';
                    document.getElementById('applicationInput').style.display = 'none';

                    const sortBy = document.getElementById('sortBy').value;
                    if (sortBy === 'date') {
                        document.getElementById('dateInputs').style.display = 'flex';
                    } else if (sortBy === 'employee') {
                        document.getElementById('employeeInput').style.display = 'block';
                    } else if (sortBy === 'application') {
                        document.getElementById('applicationInput').style.display = 'block';
                    }
                }

                // Show success modal if there is a success message
                @if (session('success'))
                    $(document).ready(function() {
                        $('#successModal').modal('show');
                    });
                @endif
            </script>
        </div>
    </div>

    <!-- Bootstrap Modal for Success Message -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog text-center">
            <div class="modal-content">
                <div class="modal-body">
                    {{ session('success') }} <!-- Display success message -->
                </div>
                <div class="modal-footer d-flex align-items-center">
                    <button type="button" class="btn btn-secondary bg-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

</x-accountant-layout>
