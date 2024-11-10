@section('title', 'Pending Payments')

<x-accountant-layout>
    <x-slot name="header"></x-slot>

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
                                    <a href="{{ route('accountant-deptors', ['download' => 'excel']) }}" class="btn btn-primary" id="exportExcel">Export to Excel</a>
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
                                                        <p class="fw-bold mb-1">{{ $dept -> names }}</p>
                                                        <p class="text-muted mb-0">{{ $dept -> email }} <br> {{ $dept -> phone_number }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center" style="margin: 0px">
                                                    <div class="" style="padding: 0px 5px">
                                                        <p class="fw-bold mb-1">{{ $dept -> discipline_name }}</p>
                                                        <p class="text-muted mb-0">{{ $dept -> discipline_organization }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="fw-normal mb-1"><strong>{{ $dept -> outstanding_amount}}</strong> </p>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <div class="action-btn mr-1">
                                                        <a href="{{ route('remind-debtor', ['transaction' => $dept->application_id]) }}" type="button" class="btn btn-link btn-sm btn-rounded action-btn debtorId" style="text-decoration: none; background-color: #0D6EFD; color: white; border-radius: 20px;">
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

        <!-- Success/Error Modal -->
        @if (session('success'))
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog text-center">
                <div class="modal-content">
                    <div class="modal-body">
                        {{ session('success') }}
                    </div>
                    <div class="modal-footer d-flex align-items-center">
                        <button type="button" class="btn btn-secondary bg-success" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (session('error'))
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog text-center">
                <div class="modal-content">
                    <div class="modal-body">
                        {{ session('error') }}
                    </div>
                    <div class="modal-footer d-flex align-items-center">
                        <button type="button" class="btn btn-secondary bg-danger" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        <!-- Load Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>

        // Show the modal if there is a success or error message
        @if (session('success') || session('error'))
        $(document).ready(function() {
            $('#successModal').modal('show');
        });
        @endif
    </script>

</x-accountant-layout>
