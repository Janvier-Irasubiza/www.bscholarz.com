@section('title', 'Services Costs')

<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="chat-container flex bg-white">
        <div class="dashboard-container col-lg-12 px-5">
            <div class="d-flex justify-content-between align-items-center">
                <header class="dashboard-header text-left">
                    <h1>BScholarz Services Costs</h1>
                </header>
                <a href="{{ route('admin.service-costs.new') }}" class="continue-btn px-4 py-2 text-white">New Service Cost</a>
            </div>

            @if(Session::has('success'))
                <div class="alert alert-success p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                    style="font-size: 17px" role="alert">
                    <div>
                        {{ Session::get('success') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
                    </button>
                </div>
                @php
                    Session::forget('success');
                @endphp
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger p-3 alert-dismissible mb-0 mt-0 fade show d-flex align-items-center justify-content-between"
                    style="font-size: 17px" role="alert">
                    <div>
                        {{ Session::get('error') }}
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="fa fa-times" style="font-size: 18px"></span>
                    </button>
                </div>
                @php
                    Session::forget('error');
                @endphp
            @endif

            <div class="cards-container mt-5">
                <div class="border rounded-lg p-4 mb-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Service</th>
                                <th>Cost</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($costs as $cost)
                                <tr>
                                    <td>{{ $cost->service }}</td>
                                    <td>{{ $cost->cost }}</td>
                                    <td>
                                        <a href="{{ route('admin.edit-service-cost', ['cost' =>  $cost->id]) }}" class="badge rounded-pill px-4 bg-warning" style="color: white">
                                            Edit
                                        </a>

                                        <button class="badge rounded-pill px-3 bg-danger"
                                            onclick="confirmDelete('{{ route('admin.delete-service-cost', $cost->id) }}')">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    // Function to confirm deletion
    function confirmDelete(deleteUrl) {
        // Show confirmation dialog
        if (confirm('Are you sure you want to delete this service cost?')) {
            // If user confirms, redirect to the delete URL
            window.location.href = deleteUrl;
        }
    }
</script>
