@section('title', 'Dashboard')

<x-accountant-layout>
    <x-slot name="header">
    </x-slot>

    <div style="padding: 0px 20px 32px 20px">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-2 p-2">
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
        </div>

        <div class="mt-3">
            <div class="card">
                <div class="card-header-tab card-header">
                    Payments Under Clarification
                    <div class="d-flex py-3">
                        <form method="GET" action="{{ route('sort-clarifications') }}" style="display: contents;">
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
                                        @foreach ($clarifications_unique as $app)
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
                            <a href="{{ route('export.transactions', ['download' => 'excel', 'type' => 'pending', 'sortBy' => $sortBy, 'employee' => $employee, 'application' => $application, 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-primary" id="exportExcel">Export to Excel</a>
                        </div>
                    </div>
                </div>
                <div style="border-top: none" class="d-block p-3 card-footer">
                    <table id="example1" class="table align-middle mb-0 bg-white" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th>Transaction ID</th>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
                                <th>Assistant</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $transaction)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <p class="fw-normal mb-1">{{ $transaction->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ $transaction->amount }}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ $transaction->created_at }}</p>
                                </td>
                                <td>
                                    <p class="fw-normal mb-1">{{ $transaction->application->appAssistant->names }}</p>
                                </td>
                                <td class="text-center">
                                    <a style="font-weight: 600; border: 1.3px solid;" href="{{ route('transaction-review', ['transaction' => $transaction->id]) }}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm mr-1 sd-btn">
                                        Review
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                XLSX.utils.book_append_sheet(wb, ws, 'Transactions Waiting For Clarification');

                // Write the workbook to a file
                XLSX.writeFile(wb, 'Transactions_Waiting_For_Clarification.xlsx');
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

        function formatNumber(value) {
            if (value >= 1_000_000_000) {
                return (value / 1_000_000_000).toFixed(1) + ' B'; // Billions
            } else if (value >= 1_000_000) {
                return (value / 1_000_000).toFixed(1) + ' M'; // Millions
            } else if (value >= 1_000) {
                return (value / 1_000).toFixed(1) + ' K'; // Thousands
            } else {
                return value.toString(); // Less than 1,000
            }
        }

        // Apply formatting to all elements with the "widget-numbers" class
        document.querySelectorAll('.widget-numbers').forEach(function (element) {
            const value = parseInt(element.textContent.replace(/\D/g, '')); // Extract numeric value
            element.textContent = formatNumber(value);
        });

    </script>


</x-accountant-layout>
