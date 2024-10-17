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
                            <div class="card-header-tab card-header py-3 d-flex">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal col-lg-6">
                                    Complete Transactions
                                </div>
                                <div class="btn-actions-pane-right text-capitalize text-right col-lg-6">
                                    <button class="btn btn-primary" id="exportExcel">Export to Excel</button>
                                </div>
                            </div>
                            <div style="border-top: none" class="d-block p-3 card-footer">
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

            <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

            <script>
                document.getElementById('exportExcel').addEventListener('click', function () {
                    const wb = XLSX.utils.book_new();
                    const ws = XLSX.utils.table_to_sheet(document.getElementById('example1'));
                    XLSX.utils.book_append_sheet(wb, ws, 'Complete Transactions');
                    XLSX.writeFile(wb, 'Complete_Transactions.xlsx');
                });

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
